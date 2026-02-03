<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Sinal') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Visualizar Sinal"
                    description="Detalhes completos do sinal {{ $sinal->palavra_portugues }}" >
                    <x-slot name="action">
                        <div class="flex gap-2">
                            <a href="{{ route('sinais.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
                                <i class="ph ph-arrow-left mr-2"></i>
                                Voltar
                            </a>
                            @can('edit_sinais')
                                <a href="{{ route('sinais.edit', $sinal) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="ph ph-pencil mr-2"></i>
                                    Editar
                                </a>
                            @endcan
                        </div>
                    </x-slot>
                </x-page-header>

                <!-- Sinal Details -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Info Card -->
                    <div class="lg:col-span-2">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-info mr-2 text-blue-600"></i>
                                    Informações Gerais
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Palavra em Português -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1 ">
                                        Palavra em Português
                                    </label>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3 break-all overflow-hidden">
                                        {{ $sinal->palavra_portugues }}
                                    </p>
                                </div>                                

                                <!-- ID -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        ID
                                    </label>
                                    <p class="text-sm text-gray-900 font-mono bg-gray-50 rounded-lg p-3">
                                        #{{ $sinal->id }}
                                    </p>
                                </div>

                                <!-- Definição -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Definição
                                    </label>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3 break-all overflow-hidden">
                                        {{ $sinal->definicao ?? 'Nenhuma definição fornecida.' }}
                                    </p>
                                </div>

                                <!-- Parâmetros -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Parâmetros
                                    </label>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3 break-all overflow-hidden">
                                        {{ $sinal->parametros ?? 'Nenhuma instrução fornecida.' }}
                                    </p>
                                </div>

                                <!-- Contexto de Utilização -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Contexto de Utilização
                                    </label>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3 break-all overflow-hidden">
                                        {{ $sinal->contexto_utilizacao ?? 'Nenhum contexto fornecido.' }}
                                    </p>
                                </div>

                                <!-- Status -->
                               <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Status
                                    </label>

                                    @php
                                        $statusMap = [
                                            'catalogado' => [
                                                'label' => 'Catalogado',
                                                'class' => 'bg-blue-100 text-blue-800',
                                            ],
                                            'em_validacao' => [
                                                'label' => 'Em Validação',
                                                'class' => 'bg-yellow-100 text-yellow-800',
                                            ],
                                            'publicado' => [
                                                'label' => 'Publicado',
                                                'class' => 'bg-green-100 text-green-800',
                                            ],
                                        ];

                                        $status = $statusMap[$sinal->status] ?? [
                                            'label' => ucwords(str_replace('_', ' ', $sinal->status ?? 'Indefinido')),
                                            'class' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </div>

                                <!-- Categorias -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Categorias
                                    </label>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        @if ($sinal->categorias && $sinal->categorias->count())
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($sinal->categorias as $categoria)
                                                    @php
                                                    $cores = [
                                                        'bg-blue-100 text-blue-800 border-blue-200',
                                                        'bg-green-100 text-green-800 border-green-200',
                                                        'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                        'bg-red-100 text-red-800 border-red-200',
                                                        'bg-purple-100 text-purple-800 border-purple-200',
                                                        'bg-pink-100 text-pink-800 border-pink-200',
                                                        'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                        'bg-teal-100 text-teal-800 border-teal-200',
                                                    ];

                                                    // garante índice válido mesmo se o ID for alto
                                                    $cor = $cores[($categoria->id - 1) % count($cores)];
                                                @endphp

                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold border {{ $cor }}">
                                                    {{ $categoria->nome }}
                                                </span>

                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-600">Nenhuma categoria atribuída a este sinal.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Video -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Vídeo do Sinal
                                    </label>
                                    @if ($sinal->video && $sinal->video->url_video)
                                        <div class="mb-4 flex justify-center">
                                            <video controls class="w-full max-w-2xl rounded-lg border" preload="metadata">
                                                <source src="{{ Storage::url($sinal->video->url_video) }}" type="video/mp4">
                                                Seu navegador não suporta vídeo.
                                            </video>
    
                                        </div>
                                    @endif
                                </div>

                                <!-- Imagens -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Imagens do Sinal
                                    </label>
                                    @if ($sinal->imagens && $sinal->imagens->count())
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                            @foreach ($sinal->imagens as $imagem)
                                                <div class="border rounded-lg overflow-hidden">
                                                    <img src="{{ Storage::url($imagem->url_imagem) }}" alt="Imagem do Sinal"
                                                        class="w-full h-32 object-cover">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-600">Nenhuma imagem disponível para este sinal.</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Timestamps Card -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-clock mr-2 text-blue-600"></i>
                                    Registro
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Created At -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Criado em
                                    </label>
                                    <p class="text-sm text-gray-900 flex items-center">
                                        <i class="ph ph-calendar-plus mr-2 text-gray-400"></i>
                                        {{ $sinal->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $sinal->created_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Updated At -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Atualizado em
                                    </label>
                                    <p class="text-sm text-gray-900 flex items-center">
                                        <i class="ph ph-calendar-check mr-2 text-gray-400"></i>
                                        {{ $sinal->updated_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $sinal->updated_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Difference -->
                                <div class="pt-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-500">
                                        <i class="ph ph-timer mr-1"></i>
                                        Criado {{ $sinal->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
