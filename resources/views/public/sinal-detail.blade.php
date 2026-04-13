<x-public-layout>
    <x-slot name="title">{{ $sinal->palavra_portugues }} - Plataforma Digital Libras+</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">
                            <i class="ph ph-house"></i>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-gray-400 mx-2"></i>
                            <a href="{{ route('public.sinais') }}" class="text-gray-600 hover:text-blue-600">Sinais</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-gray-400 mx-2"></i>
                            <span class="text-gray-900 font-medium">{{ $sinal->palavra_portugues }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Video -->
                    @if ($sinal->video)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <video controls class="w-full" preload="metadata" autoplay muted playsinline loop>
                                <source src="{{ Storage::url($sinal->video->url_video) }}" type="video/mp4">
                                Seu navegador não suporta vídeo.
                            </video>
                        </div>
                    @endif

                    <!-- Title -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            {{ $sinal->palavra_portugues }}
                        </h1>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="ph ph-calendar"></i>
                            <span>Atualizado em {{ $sinal->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <!-- Definition -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="ph ph-book-open text-blue-600"></i>
                            Definição
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $sinal->definicao }}
                        </p>
                    </div>

                    <!-- Configuração de Mão -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="ph ph-list-bullets text-blue-600"></i>
                            Configuração de Mão
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $sinal->config_mao }}
                        </p>
                    </div>

                    <!-- Ponto de Articulação -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="ph ph-list-bullets text-blue-600"></i>
                            Ponto de Articulação
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $sinal->ponto_articulacao }}
                        </p>
                    </div>

                    <!-- Orientação da Palma da Mão -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="ph ph-list-bullets text-blue-600"></i>
                            Orientação da Palma da Mão
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $sinal->orientacao_palma_mao }}
                        </p>
                    </div>

                    <!-- Movimento -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="ph ph-list-bullets text-blue-600"></i>
                            Movimento
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $sinal->movimento }}
                        </p>
                    </div>

                    <!-- Expressão não Manual -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="ph ph-list-bullets text-blue-600"></i>
                            Expressão não Manual
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $sinal->expressao_nao_manual }}
                        </p>
                    </div>

                    <!-- Context -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="ph ph-chat-text text-blue-600"></i>
                            Contexto de Utilização
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $sinal->contexto_utilizacao }}
                        </p>
                    </div>

                    <!-- Images -->
                    @if ($sinal->imagens->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="ph ph-images text-blue-600"></i>
                                Imagens
                            </h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($sinal->imagens as $imagem)
                                    <img src="{{ Storage::url($imagem->url_imagem) }}"
                                        alt="{{ $sinal->palavra_portugues }}"
                                        class="w-full h-48 object-cover rounded-lg border border-gray-200">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Categories -->
                    @if ($sinal->categorias->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="ph ph-folders text-blue-600"></i>
                                Categorias
                            </h3>
                            <div class="space-y-2">
                                @foreach ($sinal->categorias as $categoria)
                                    <span class="font-medium text-blue-900">{{ $categoria->nome }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Status -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="ph ph-info text-blue-600"></i>
                            Informações
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600">Status:</span>
                                <span
                                    class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                    {{ ucfirst($sinal->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Criado em:</span>
                                <span class="ml-2 text-sm text-gray-900">
                                    {{ $sinal->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
