<x-public-layout>
    <x-slot name="title">Resultados da Busca - {{ $query }}</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    Resultados da busca
                </h1>
                <p class="text-gray-600">
                    Mostrando resultados para: <span class="font-semibold text-[#4A83FF]">"{{ $query }}"</span>
                </p>
            </div>

            <!-- Search Again -->
            <div class="mb-12">
                <x-global-search placeholder="Refinar busca..." />
            </div>

            <!-- Sinais Results -->
            @if($sinais->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ph ph-hand-waving text-[#4A83FF]"></i>
                        Sinais ({{ $sinais->total() }})
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($sinais as $sinal)
                            <a href="{{ route('public.sinal.show', $sinal->slug) }}" 
                               class="bg-white rounded-xl transition-shadow overflow-hidden border border-gray-200">
                                @if($sinal->video)
                                    <div class="aspect-video bg-gray-100">
                                        <video class="w-full h-full object-cover" preload="metadata" autoplay muted playsinline loop>
                                            <source src="{{ Storage::url($sinal->video->url_video) }}" type="video/mp4">
                                        </video>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2">
                                        {{ $sinal->palavra_portugues }}
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                        {{ $sinal->definicao }}
                                    </p>
                                    @if($sinal->categorias->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($sinal->categorias->take(2) as $categoria)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                    {{ $categoria->nome }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $sinais->appends(['query' => $query])->links() }}
                    </div>
                </div>
            @endif

            <!-- Categorias Results -->
            @if($categorias->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ph ph-folders text-[#4A83FF]"></i>
                        Categorias ({{ $categorias->total() }})
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($categorias as $categoria)
                            <a href="{{ route('public.categoria.show', $categoria->slug) }}" 
                               class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 border border-gray-200">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="ph ph-folder text-[#4A83FF] text-2xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-lg text-gray-900 mb-2">
                                            {{ $categoria->nome }}
                                        </h3>
                                        <span class="text-[#4A83FF] text-sm font-medium">
                                            {{ $categoria->sinais_count }} sinais
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $categorias->appends(['query' => $query])->links() }}
                    </div>
                </div>
            @endif

            <!-- No Results -->
            @if($sinais->count() === 0 && $categorias->count() === 0)
                <div class="text-center py-12">
                    <i class="ph ph-magnifying-glass text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Nenhum resultado encontrado
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Tente usar palavras-chave diferentes ou mais gerais
                    </p>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-6 py-3 bg-[#4A83FF] text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="ph ph-house mr-2"></i>
                        Voltar para o início
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
