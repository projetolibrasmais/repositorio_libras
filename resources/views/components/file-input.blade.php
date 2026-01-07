@props([
    'name' => 'file',
    'id' => null,
    'accept' => '*',
    'maxSize' => null,
    'label' => 'Arquivo',
    'required' => false,
    'description' => null,
    'showPreview' => false,
    'previewType' => 'image', // 'image' or 'video'
])

@php
    $inputId = $id ?? $name;
    $maxSizeMB = $maxSize ? $maxSize / 1024 : null;
@endphp

<div x-data="{
    isDragging: false,
    fileName: '',
    fileSize: '',
    previewUrl: null,
    error: '',
    handleFiles(files) {
        if (files.length === 0) return;
        
        const file = files[0];
        this.error = '';
        
        // Validate file type
        const acceptedTypes = '{{ $accept }}'.split(',').map(t => t.trim());
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        const fileMimeType = file.type;
        
        if ('{{ $accept }}' !== '*') {
            const isValidType = acceptedTypes.some(type => {
                if (type.includes('*')) {
                    const baseType = type.split('/')[0];
                    return fileMimeType.startsWith(baseType);
                }
                return type === fileMimeType || type === fileExtension;
            });
            
            if (!isValidType) {
                this.error = 'Tipo de arquivo não permitido.';
                this.$refs.fileInput.value = '';
                return;
            }
        }
        
        // Validate file size
        @if($maxSize)
            if (file.size > {{ $maxSize }} * 1024) {
                this.error = 'Arquivo muito grande. Tamanho máximo: {{ $maxSizeMB }}MB';
                this.$refs.fileInput.value = '';
                return;
            }
        @endif
        
        // Set file info
        this.fileName = file.name;
        this.fileSize = this.formatFileSize(file.size);
        
        // Generate preview
        @if($showPreview)
            if (file.type.startsWith('{{ $previewType }}/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        @endif
    },
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    },
    clearFile() {
        this.fileName = '';
        this.fileSize = '';
        this.previewUrl = null;
        this.error = '';
        this.$refs.fileInput.value = '';
    }
}" class="w-full">
    <!-- Label -->
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <!-- Description -->
    @if($description)
        <p class="text-sm text-gray-500 mb-2">{{ $description }}</p>
    @endif

    <!-- Drop Zone -->
    <div 
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
        @click="$refs.fileInput.click()"
        :class="{ 
            'border-blue-500 bg-blue-50': isDragging,
            'border-red-500 bg-red-50': error,
            'border-gray-300 bg-white': !isDragging && !error
        }"
        class="relative border-2 border-dashed rounded-lg p-6 transition-all duration-200 cursor-pointer hover:border-blue-400 hover:bg-gray-50"
    >
        <!-- Hidden File Input -->
        <input 
            type="file" 
            x-ref="fileInput"
            name="{{ $name }}"
            id="{{ $inputId }}"
            accept="{{ $accept }}"
            @change="handleFiles($event.target.files)"
            {{ $required ? 'required' : '' }}
            class="hidden"
            {{ $attributes }}
        >

        <!-- Empty State -->
        <div x-show="!fileName && !error" class="text-center">
            <div class="mx-auto h-12 w-12 text-gray-400 mb-3">
                <i class="ph ph-upload-simple text-4xl"></i>
            </div>
            <div class="flex text-sm text-gray-600 justify-center">
                <span class="font-semibold text-blue-600 hover:text-blue-500">
                    Clique para selecionar
                </span>
                <span class="ml-1">ou arraste e solte</span>
            </div>
            @if($accept !== '*')
                <p class="text-xs text-gray-500 mt-1">
                    Tipos permitidos: {{ str_replace(',', ', ', $accept) }}
                </p>
            @endif
            @if($maxSizeMB)
                <p class="text-xs text-gray-500">
                    Tamanho máximo: {{ $maxSizeMB }}MB
                </p>
            @endif
        </div>

        <!-- File Info -->
        <div x-show="fileName && !error" class="flex items-center justify-between">
            <div class="flex items-center space-x-3 flex-1 min-w-0">
                <div class="flex-shrink-0">
                    <i class="ph ph-file text-blue-600 text-3xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate" x-text="fileName"></p>
                    <p class="text-xs text-gray-500" x-text="fileSize"></p>
                </div>
            </div>
            <button 
                type="button"
                @click.stop="clearFile()"
                class="flex-shrink-0 ml-3 p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
            >
                <i class="ph ph-trash text-xl"></i>
            </button>
        </div>

        <!-- Error State -->
        <div x-show="error" class="text-center">
            <div class="mx-auto h-12 w-12 text-red-500 mb-3">
                <i class="ph ph-warning-circle text-4xl"></i>
            </div>
            <p class="text-sm text-red-600 font-medium" x-text="error"></p>
            <button 
                type="button"
                @click.stop="clearFile()"
                class="mt-2 text-sm text-blue-600 hover:text-blue-700 font-medium"
            >
                Tentar novamente
            </button>
        </div>
    </div>

    <!-- Preview -->
    @if($showPreview)
        <div x-show="previewUrl" class="mt-4">
            @if($previewType === 'image')
                <img :src="previewUrl" alt="Preview" class="max-h-64 rounded-lg border border-gray-200 mx-auto">
            @elseif($previewType === 'video')
                <video :src="previewUrl" controls class="max-h-64 rounded-lg border border-gray-200 mx-auto"></video>
            @endif
        </div>
    @endif

    <!-- Error Message from Server -->
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
