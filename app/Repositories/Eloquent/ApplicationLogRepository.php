<?php

namespace App\Repositories\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationLogRepository
{
    private const HEADER = '/^\[(\d{4}-\d\d-\d\d \d\d:\d\d:\d\d)\] (\S+)\.([A-Z]+): (.*)$/';

    public function paginate(array $filters, int $perPage): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $entries = [];
        foreach ($this->entries() as $entry) {
            if ($this->matches($entry, $filters)) {
                $entries[] = $entry;
            }
        }

        $entries = array_reverse($entries);

        return new LengthAwarePaginator(
            array_slice($entries, ($page - 1) * $perPage, $perPage),
            count($entries),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => request()->except('page')]
        );
    }

    public function find(int $id): ?array
    {
        foreach ($this->entries() as $entry) {
            if ($entry['id'] === $id) {
                return $entry;
            }
        }

        return null;
    }

    private function entries(): \Generator
    {
        $path = storage_path('logs/laravel.log');
        if (!is_file($path) || !is_readable($path)) {
            return;
        }

        $file = fopen($path, 'rb');
        if ($file === false) {
            return;
        }

        try {
            $entry = null;
            $lineNumber = 0;
            while (($line = fgets($file)) !== false) {
                $lineNumber++;
                if (preg_match(self::HEADER, rtrim($line, "\r\n"), $parts)) {
                    if ($entry !== null) {
                        yield $entry;
                    }
                    $entry = [
                        'id' => $lineNumber,
                        'date' => $parts[1],
                        'channel' => $parts[2],
                        'level' => $parts[3],
                        'message' => $parts[4],
                        'details' => '',
                    ];
                } elseif ($entry !== null) {
                    $entry['details'] .= $line;
                }
            }
            if ($entry !== null) {
                yield $entry;
            }
        } finally {
            fclose($file);
        }
    }

    private function matches(array $entry, array $filters): bool
    {
        if (!empty($filters['level']) && $entry['level'] !== strtoupper($filters['level'])) {
            return false;
        }

        return empty($filters['search']) || stripos($entry['message']."\n".$entry['details'], $filters['search']) !== false;
    }
}
