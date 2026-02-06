<x-public-layout>
    <x-slot name="title">Categorias - Plataforma Digital Libras+</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-blue-600 mb-4">{{ __('Categorias') }}</h1>
            <p class="text-gray-600 mb-8">
                {{ __('Explore os sinais organizados por áreas do conhecimento') }}
            </p>

            <!-- Categorias Grid -->
            @php
                $categorias = \App\Models\Categoria::withCount('sinais')
                    ->orderBy('nome')
                    ->get();
            @endphp

            @if($categorias->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categorias as $categoria)
                        <a href="{{ route('public.sinais', ['categoria' => $categoria->slug]) }}" 
                           class="bg-white rounded-lg transition-shadow p-6 border border-gray-200 hover:border-[#4A83FF] group">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="ph ph-folder text-blue-600 text-3xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-xl text-gray-900 group-hover:text-[#4A83FF] transition-colors mb-2">
                                        {{ $categoria->nome }}
                                    </h3>
                                    @if($categoria->descricao)
                                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                            {{ $categoria->descricao }}
                                        </p>
                                    @endif
                                    <div class="flex items-center gap-2 text-blue-600">
                                        <i class="ph ph-hand-waving"></i>
                                        <span class="text-sm font-medium">
                                            {{ $categoria->sinais_count }} {{ __('sinais') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="ph ph-folders text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-600">{{ __('Nenhuma categoria disponível no momento.') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
