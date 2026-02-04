<x-public-layout>
    <x-slot name="title">Sinais - Plataforma Digital Libras+</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-blue-600 mb-4">Sinais</h1>
            <p class="text-gray-600 mb-8">
                Explore todos os sinais catalogados na plataforma
            </p>

            <!-- Search -->
            <div class="mb-8">
                <x-global-search placeholder="Buscar sinais..." />
            </div>

            <!-- Sinais Grid -->
            @php
                $sinais = \App\Models\Sinal::where('status', 'publicado')
                    ->with('video', 'categorias')
                    ->latest()
                    ->paginate(12);
            @endphp

            @if($sinais->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sinais as $sinal)
                        <a href="{{ route('public.sinal.show', $sinal->slug) }}" 
                           class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden border border-gray-200">
                            @if($sinal->video)
                                <div class="aspect-video bg-gray-100">
                                    <video class="w-full h-full object-cover" preload="metadata">
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

                <div class="mt-8">
                    {{ $sinais->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="ph ph-hand-waving text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-600">Nenhum sinal disponível no momento.</p>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
