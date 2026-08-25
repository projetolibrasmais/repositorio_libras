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
    'multiple' => false,
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
    files: [],
    error: '',
    isMultiple: {{ $multiple ? 'true' : 'false' }},
    dataTransfer: null,
    init() {
        if (this.isMultiple) {
            this.dataTransfer = new DataTransfer();
        }
    },
    handleFiles(fileList) {
        if (fileList.length === 0) return;
        
        this.error = '';
        
        if (this.isMultiple) {
            // Handle multiple files - accumulate them
            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];
                const validation = this.validateFile(file);
                
                if (validation.valid) {
                    // Add to DataTransfer
                    this.dataTransfer.items.add(file);
                    
                    const fileData = {
                        name: file.name,
                        size: this.formatFileSize(file.size),
                        previewUrl: null,
                        file: file
                    };
                    
                    // Generate preview
                    @if($showPreview)
                        if (file.type.startsWith('{{ $previewType }}/')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                fileData.previewUrl = e.target.result;
                                this.$nextTick(() => {
                                    this.files = [...this.files];
                                });
                            };
                            reader.readAsDataURL(file);
                        }
                    @endif
                    
                    this.files.push(fileData);
                } else {
                    this.error = validation.error;
                    return;
                }
            }
            
            // Update input with accumulated files
            this.$refs.fileInput.files = this.dataTransfer.files;
        } else {
            // Handle single file
            const file = fileList[0];
            const validation = this.validateFile(file);
            
            if (!validation.valid) {
                this.error = validation.error;
                this.$refs.fileInput.value = '';
                return;
            }
            
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
        }
    },
    validateFile(file) {
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
                return { valid: false, error: 'Tipo de arquivo não permitido: ' + file.name };
            }
        }
        
        // Validate file size
        @if($maxSize)
            if (file.size > {{ $maxSize }} * 1024) {
                return { valid: false, error: 'Arquivo muito grande: ' + file.name + '. Tamanho máximo: {{ $maxSizeMB }}MB' };
            }
        @endif
        
        return { valid: true };
    },
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    },
    removeFile(index) {
        // Remove from files array
        this.files.splice(index, 1);
        
        if (this.isMultiple) {
            // Rebuild DataTransfer without this file
            this.dataTransfer = new DataTransfer();
            
            for (let i = 0; i < this.files.length; i++) {
                if (this.files[i].file) {
                    this.dataTransfer.items.add(this.files[i].file);
                }
            }
            
            // Update input
            this.$refs.fileInput.files = this.dataTransfer.files;
            
            if (this.files.length === 0) {
                this.clearFile();
            }
        } else {
            this.clearFile();
        }
    },
    clearFile() {
        this.fileName = '';
        this.fileSize = '';
        this.previewUrl = null;
        this.files = [];
        this.error = '';
        this.$refs.fileInput.value = '';
        
        if (this.isMultiple) {
            this.dataTransfer = new DataTransfer();
        }
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
            'border-logo-sky bg-brand-50': isDragging,
            'border-red-500 bg-red-50': error,
            'border-gray-300 bg-white': !isDragging && !error
        }"
        class="relative border-2 border-dashed rounded-lg p-6 transition-all duration-200 cursor-pointer hover:border-logo-sky hover:bg-gray-50"
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
            {{ $multiple ? 'multiple' : '' }}
            class="hidden"
            {{ $attributes }}
        >

        <!-- Empty State -->
        <div x-show="!fileName && !error && files.length === 0" class="text-center">
            <div class="mx-auto h-12 w-12 text-gray-400 mb-3">
                <i class="ph ph-upload-simple text-4xl"></i>
            </div>
            <div class="flex text-sm text-gray-600 justify-center">
                <span class="font-semibold text-brand-600 hover:text-logo-sky">
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

        <!-- File Info (Single File) -->
        <div x-show="fileName && !error && !isMultiple" class="flex items-center justify-between">
            <div class="flex items-center space-x-3 flex-1 min-w-0">
                <div class="flex-shrink-0">
                    <i class="ph ph-file text-brand-600 text-3xl"></i>
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

        <!-- Multiple Files List -->
        <div x-show="files.length > 0 && isMultiple" class="space-y-2">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-700">
                    <span x-text="files.length"></span> arquivo(s) selecionado(s)
                </p>
                <button 
                    type="button"
                    @click.stop="clearFile()"
                    class="text-sm text-red-600 hover:text-red-700 font-medium"
                >
                    Remover todos
                </button>
            </div>
            
            <template x-for="(file, index) in files" :key="index">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <div class="flex-shrink-0">
                            <i class="ph ph-file text-brand-600 text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate" x-text="file.name"></p>
                            <p class="text-xs text-gray-500" x-text="file.size"></p>
                        </div>
                    </div>
                    <button 
                        type="button"
                        @click.stop="removeFile(index)"
                        class="flex-shrink-0 ml-3 p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                    >
                        <i class="ph ph-x text-lg"></i>
                    </button>
                </div>
            </template>
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
                class="mt-2 text-sm text-brand-600 hover:text-brand-700 font-medium"
            >
                Tentar novamente
            </button>
        </div>
    </div>

    <!-- Preview -->
    @if($showPreview)
        <!-- Single File Preview -->
        <div x-show="previewUrl && !isMultiple" class="mt-4">
            @if($previewType === 'image')
                <img :src="previewUrl" alt="Preview" class="max-h-64 rounded-lg border border-gray-200 mx-auto">
            @elseif($previewType === 'video')
                <video :src="previewUrl" controls class="max-h-64 rounded-lg border border-gray-200 mx-auto"></video>
            @endif
        </div>
        
        <!-- Multiple Files Preview -->
        <div x-show="files.length > 0 && isMultiple" class="mt-4">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="(file, index) in files" :key="index">
                    <div x-show="file.previewUrl" class="relative group">
                        @if($previewType === 'image')
                            <img :src="file.previewUrl" :alt="file.name" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        @elseif($previewType === 'video')
                            <video :src="file.previewUrl" class="w-full h-32 object-cover rounded-lg border border-gray-200"></video>
                        @endif
                        <button 
                            type="button"
                            @click.stop="removeFile(index)"
                            class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600"
                        >
                            <i class="ph ph-x text-sm"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    @endif

    <!-- Error Message from Server -->
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
