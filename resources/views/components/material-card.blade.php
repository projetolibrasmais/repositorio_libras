@props([
    'titulo',
    'descricao',
    'link',
])

@php
    $modalId = 'material-modal-' . md5($titulo . $link);
    // Detectar tipo de arquivo pela extensão
    $fileExtension = strtolower(pathinfo($link, PATHINFO_EXTENSION));
    $isPdf = $fileExtension === 'pdf';
    $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    $isVideo = in_array($fileExtension, ['mp4', 'webm', 'ogg']);
@endphp

<div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer"
     x-data="{ showModal: false }"
     @click="showModal = true">
    
    <!-- Card Content -->
    <div class="p-6">
        <!-- Ícone do documento -->
        <div class="w-16 h-16 rounded-full bg-brand-100 flex items-center justify-center mb-4 mx-auto">
            @if($isPdf)
                <i class="ph ph-file-pdf text-brand-600 text-3xl"></i>
            @elseif($isImage)
                <i class="ph ph-file-image text-brand-600 text-3xl"></i>
            @elseif($isVideo)
                <i class="ph ph-file-video text-brand-600 text-3xl"></i>
            @else
                <i class="ph ph-file-text text-brand-600 text-3xl"></i>
            @endif
        </div>

        <!-- Título -->
        <h3 class="text-lg font-semibold text-gray-800 text-center mb-2 line-clamp-2">
            {{ $titulo }}
        </h3>

        <!-- Descrição -->
        <p class="text-sm text-gray-600 text-center line-clamp-3">
            {{ $descricao }}
        </p>

        <!-- Botão Ver mais -->
        <div class="mt-4 text-center">
            <span class="text-brand-600 text-sm font-medium hover:underline">
                Ver mais →
            </span>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" 
         x-cloak
         @click.away="showModal = false"
         @keydown.escape.window="showModal = false"
         class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
         style="display: none;">
        
        <!-- Overlay -->
        <div x-show="showModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
             @click="showModal = false">
        </div>

        <!-- Modal Content -->
        <div x-show="showModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-lg shadow-xl transform transition-all sm:max-w-5xl sm:mx-auto"
             @click.stop>
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-brand-700 to-logo-sky px-6 py-4 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white">
                        {{ $titulo }}
                    </h2>
                    <button @click="showModal = false" 
                            class="text-white hover:text-gray-200 transition">
                        <i class="ph ph-x text-2xl"></i>
                    </button>
                </div>
                @if($descricao)
                    <p class="text-white text-sm mt-2 opacity-90">
                        {{ $descricao }}
                    </p>
                @endif
            </div>

            <!-- Modal Body - Visualização do Documento -->
            <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                @if($isPdf)
                    <!-- PDF Viewer -->
                    <div class="bg-gray-50 rounded-lg p-4 min-h-[500px] flex items-center justify-center">
                        <iframe src="{{ Storage::url($link) }}" 
                                class="w-full h-[500px] border-0 rounded"
                                title="{{ $titulo }}">
                        </iframe>
                    </div>
                @elseif($isImage)
                    <!-- Image Viewer -->
                    <div class="flex items-center justify-center bg-gray-50 rounded-lg p-4">
                        <img src="{{ Storage::url($link) }}" 
                             alt="{{ $titulo }}" 
                             class="max-w-full h-auto rounded-lg shadow">
                    </div>
                @elseif($isVideo)
                    <!-- Video Viewer -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <video controls class="w-full rounded-lg">
                            <source src="{{ Storage::url($link) }}" type="video/{{ $fileExtension }}">
                            Seu navegador não suporta a reprodução de vídeos.
                        </video>
                    </div>
                @else
                    <!-- Mensagem para outros tipos de arquivo -->
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                        <i class="ph ph-file text-gray-400 text-6xl mb-4"></i>
                        <p class="text-gray-600 mb-2">
                            Pré-visualização não disponível para este tipo de arquivo.
                        </p>
                        <p class="text-sm text-gray-500">
                            Use os botões abaixo para visualizar ou baixar o material.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Modal Footer - Ações -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex flex-col sm:flex-row gap-3 justify-end">
                <!-- Botão Baixar -->
                <a href="{{ Storage::url($link) }}" 
                   download
                   class="inline-flex items-center justify-center px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                    <i class="ph ph-download-simple mr-2 text-xl"></i>
                    Baixar Material
                </a>

                <!-- Botão Abrir em Nova Aba -->
                <a href="{{ Storage::url($link) }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center justify-center px-6 py-2.5 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700 transition-colors shadow-sm">
                    <i class="ph ph-arrow-square-out mr-2 text-xl"></i>
                    Abrir em Nova Página
                </a>

                <!-- Botão Fechar -->
                <button @click="showModal = false"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-400 transition-colors shadow-sm">
                    <i class="ph ph-x mr-2 text-xl"></i>
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
