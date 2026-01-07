<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StorageHelper
{
    /**
     * Directory where videos are stored.
     */
    const VIDEO_DIRECTORY = 'videos';

    /**
     * Allowed video extensions.
     */
    const ALLOWED_EXTENSIONS = ['mp4', 'mov', 'avi', 'webm', 'mkv'];

    /**
     * Maximum file size in kilobytes (50MB).
     */
    const MAX_FILE_SIZE = 51200;

    /**
     * Upload a video file.
     *
     * @param UploadedFile $file
     * @param string|null $customName
     * @param string|null $subdirectory
     * @return string|false Returns the file path on success, false on failure
     */
    public static function uploadVideo(UploadedFile $file, ?string $customName = null, ?string $subdirectory = null)
    {
        try {
            $extension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($extension), self::ALLOWED_EXTENSIONS)) {
                throw new \Exception('Tipo de arquivo não permitido. Use: ' . implode(', ', self::ALLOWED_EXTENSIONS));
            }

            if ($file->getSize() > self::MAX_FILE_SIZE * 1024) {
                throw new \Exception('Arquivo muito grande. Tamanho máximo: ' . (self::MAX_FILE_SIZE / 1024) . 'MB');
            }

            $filename = $customName 
                ? Str::slug($customName) . '.' . $extension
                : Str::random(40) . '.' . $extension;

            $directory = self::VIDEO_DIRECTORY;
            if ($subdirectory) {
                $directory .= '/' . trim($subdirectory, '/');
            }

            $path = $file->storeAs($directory, $filename, 'public');

            return $path;
        } catch (\Exception $e) {
            Log::error('Error uploading video: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a video file.
     *
     * @param string $path
     * @return bool
     */
    public static function deleteVideo(string $path): bool
    {
        try {
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting video: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Replace an existing video with a new one.
     * Deletes the old video and uploads the new one.
     *
     * @param string|null $oldPath Path of the video to be replaced
     * @param UploadedFile $newFile New video file to upload
     * @param string|null $customName Custom name for the new file
     * @param string|null $subdirectory Subdirectory to store the new file
     * @return string|false Returns the new file path on success, false on failure
     */
    public static function replaceVideo(?string $oldPath, UploadedFile $newFile, ?string $customName = null, ?string $subdirectory = null)
    {
        try {
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                self::deleteVideo($oldPath);
            }

            $newPath = self::uploadVideo($newFile, $customName, $subdirectory);

            if (!$newPath) {
                throw new \Exception('Falha ao fazer upload do novo vídeo.');
            }

            return $newPath;
        } catch (\Exception $e) {
            Log::error('Error replacing video: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete multiple video files.
     *
     * @param array $paths
     * @return bool
     */
    public static function deleteVideos(array $paths): bool
    {
        try {
            $existingPaths = array_filter($paths, function($path) {
                return Storage::disk('public')->exists($path);
            });

            if (empty($existingPaths)) {
                return false;
            }

            return Storage::disk('public')->delete($existingPaths);
        } catch (\Exception $e) {
            Log::error('Error deleting videos: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the full path of a video file.
     *
     * @param string $path
     * @return string|null
     */
    public static function getVideoPath(string $path): ?string
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->path($path);
        }
        return null;
    }

    /**
     * Get the public URL of a video file.
     *
     * @param string|null $path
     * @return string|null
     */
    public static function getVideoUrl(?string $path): ?string
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return null;
        }

        return asset('storage/' . $path);
    }

    /**
     * Clean up old videos in a directory.
     *
     * @param int $days Delete videos older than X days
     * @param string|null $subdirectory
     * @return int Number of deleted files
     */
    public static function cleanupOldVideos(int $days = 30, ?string $subdirectory = null): int
    {
        try {
            $directory = self::VIDEO_DIRECTORY;
            if ($subdirectory) {
                $directory .= '/' . trim($subdirectory, '/');
            }

            $files = Storage::disk('public')->files($directory);
            $deleted = 0;
            $cutoffTime = now()->subDays($days)->timestamp;

            foreach ($files as $file) {
                $lastModified = Storage::disk('public')->lastModified($file);
                
                if ($lastModified < $cutoffTime) {
                    if (Storage::disk('public')->delete($file)) {
                        $deleted++;
                    }
                }
            }

            return $deleted;
        } catch (\Exception $e) {
            Log::error('Error cleaning up old videos: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Format bytes to human-readable format.
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    protected static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
