<x-public-layout>
    <x-slot name="title">Catálogo - Plataforma Digital Libras+</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <h1 class="text-4xl font-bold text-[#4A83FF] mb-8 text-center">Catálogo</h1>

            <!-- Search Bar -->
            <div class="mb-8">
                <x-global-search placeholder="O que você procura?" />
            </div>

            <!-- Alphabet Filter -->
            <x-alphabet-filter :currentLetter="request('letra')" />

            <!-- Divisor -->
            <div class="flex items-center justify-center py-10 px-10">
                <div class="flex-grow border-t border-gray-300"></div>
                <div class="mx-4">
                    <i class="ph ph-hand-waving text-[#4A83FF] text-3xl"></i>
                </div>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <!-- Section Title -->
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-[#4A83FF] text-center">Sinais</h2>
            </div>

            <!-- Sinais Grid -->
            @if ($sinais->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($sinais as $sinal)
                        <a href="{{ route('public.sinal.show', $sinal->slug) }}"
                            class="bg-white rounded-xl transition-shadow overflow-hidden group">
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
                            <div class="p-4 text-center">
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
                <div class="text-center py-12 bg-white rounded-xl shadow-lg">
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
