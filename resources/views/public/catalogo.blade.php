<x-public-layout>
    <x-slot name="title">Catálogo - Plataforma Digital Libras+</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <h1 class="text-4xl font-bold text-brand-600 mb-4">{{ __('Catálogo') }}</h1>
            <p class="text-gray-600 mb-8">{{ __('Explore os sinais em ordem alfabética ou refine a busca usando os filtros.') }}</p>

            <!-- Search Bar -->
            <div class="mb-10">
                <x-global-search :placeholder="__('Buscar sinais...')" />
            </div>

            <!-- Alphabet Filter -->
            <x-alphabet-filter :currentLetter="request('letra')" />

            <!-- Section Title -->
            <div class="my-8">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="ph ph-hand-waving text-brand-600"></i>
                    {{ __('Sinais') }}
                </h2>
            </div>

            <!-- Sinais Grid -->
            @if ($sinais->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                    @foreach ($sinais as $sinal)
                        <a href="{{ route('public.sinal.show', $sinal->slug) }}"
                            class="bg-white rounded-xl transition-shadow overflow-hidden border border-gray-200 group">
                            @if ($sinal->video)
                                <div class="aspect-video bg-gray-200 relative">
                                    <video class="w-full h-full object-cover" preload="metadata">
                                        <source src="{{ Storage::url($sinal->video->url_video) }}" type="video/mp4">
                                    </video>
                                    <!-- Play Button Overlay -->
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 group-hover:bg-opacity-40 transition-all">
                                    </div>
                                </div>
                            @else
                                <div class="aspect-video bg-gray-200 flex items-center justify-center">
                                    <i class="ph ph-video-camera text-gray-400 text-6xl"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-900">
                                    {{ $sinal->palavra_portugues }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $sinais->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl">
                    <i class="ph ph-magnifying-glass text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Nenhum sinal encontrado
                    </h3>
                    <p class="text-gray-600">
                        @if (request('letra'))
                            Não há sinais que começam com a letra "{{ request('letra') }}"
                        @else
                            Não há sinais disponíveis no momento
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
