<x-public-layout>
    <x-slot name="title">Sinais - Plataforma Digital Libras+</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(request()->has('categoria') && isset($categoriaAtual))
                <!-- Breadcrumb -->
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-600 flex items-center gap-1">
                                <i class="ph ph-house text-lg"></i>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="ph ph-caret-right text-gray-400 mx-2"></i>
                                <a href="{{ route('public.categorias') }}" class="text-gray-600 hover:text-brand-600">Categorias</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="ph ph-caret-right text-gray-400 mx-2"></i>
                                <span class="text-gray-900 font-medium">{{ $categoriaAtual->nome }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-4xl font-bold text-brand-600 mb-2">{{ $categoriaAtual->nome }}</h1>
                        <p class="text-gray-600">
                            @if($categoriaAtual->descricao)
                                {{ $categoriaAtual->descricao }}
                            @else
                                Sinais da categoria {{ $categoriaAtual->nome }}
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('public.sinais') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                        <i class="ph ph-x"></i>
                        <span>Limpar filtro</span>
                    </a>
                </div>
            @else
                <h1 class="text-4xl font-bold text-brand-600 mb-4">{{ __('Sinais') }}</h1>
                <p class="text-gray-600 mb-8">
                    {{ __('Explore todos os sinais catalogados na plataforma') }}
                </p>
            @endif

            <!-- Search -->
            <div class="mb-8">
                <x-global-search :placeholder="__('Buscar sinais...')" />
            </div>

            <!-- Sinais Grid -->
            @php
                $query = \App\Models\Sinal::with('video', 'imagens', 'categorias');
                
                // Filtrar por categoria se fornecido
                if (request()->has('categoria')) {
                    $categoriaSlug = request()->get('categoria');
                    $query->whereHas('categorias', function($q) use ($categoriaSlug) {
                        $q->where('slug', $categoriaSlug);
                    });
                    
                    // Buscar nome da categoria para exibir
                    $categoriaAtual = \App\Models\Categoria::where('slug', $categoriaSlug)->first();
                }
                
                $sinais = $query->latest()->paginate(12);
            @endphp

            @if($sinais->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($sinais as $sinal)
                        <a href="{{ route('public.sinal.show', $sinal->slug) }}" 
                           class="bg-white rounded-xl transition-shadow overflow-hidden border border-gray-200 group">
                            @if($sinal->video)
                                <div class="aspect-video bg-gray-900 relative overflow-hidden">
                                    <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" preload="metadata" muted>
                                        <source src="{{ Storage::url($sinal->video->url_video) }}" type="video/mp4">
                                    </video>
                                </div>
                            @elseif($sinal->imagens->first())
                                <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                    <img src="{{ Storage::url($sinal->imagens->first()->url_imagem) }}" 
                                         alt="{{ $sinal->palavra_portugues }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="aspect-video bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                                    <i class="ph ph-hand-waving text-brand-100 text-6xl"></i>
                                </div>
                            @endif
                            <div class="p-4 flex flex-col justify-between flex-1">
                                <h3 class="font-semibold text-lg text-gray-900 mb-2">
                                    {{ $sinal->palavra_portugues }}
                                </h3>
                                <p class="text-gray-600 text-xs line-clamp-2 mb-3">
                                    {{ $sinal->definicao }}
                                </p>
                                @if($sinal->categorias->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($sinal->categorias->take(2) as $categoria)
                                            <span class="px-2 py-1 bg-brand-100 text-brand-600 text-xs rounded-md font-semibold border border-logo-sky">
                                                {{ $categoria->nome }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $sinais->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="ph ph-hand-waving text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-600">{{ __('Nenhum sinal disponível no momento.') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
