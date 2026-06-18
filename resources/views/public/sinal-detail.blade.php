<x-public-layout>
    <x-slot name="title">{{ $sinal->palavra_portugues }} - Plataforma Digital Libras+</x-slot>

    @php
        $parametros = [
            [
                'titulo' => 'Configuração de mão',
                'valor' => $sinal->config_mao,
                'icone' => 'ph-hand',
                'cor' => 'text-brand-600',
                'fundo' => 'bg-brand-100',
            ],
            [
                'titulo' => 'Ponto de articulação',
                'valor' => $sinal->ponto_articulacao,
                'icone' => 'ph-crosshair',
                'cor' => 'text-logo-green',
                'fundo' => 'bg-green-100',
            ],
            [
                'titulo' => 'Orientação da palma',
                'valor' => $sinal->orientacao_palma_mao,
                'icone' => 'ph-arrows-clockwise',
                'cor' => 'text-logo-orange',
                'fundo' => 'bg-orange-100',
            ],
            [
                'titulo' => 'Movimento',
                'valor' => $sinal->movimento,
                'icone' => 'ph-path',
                'cor' => 'text-logo-pink',
                'fundo' => 'bg-pink-100',
            ],
            [
                'titulo' => 'Expressão não manual',
                'valor' => $sinal->expressao_nao_manual,
                'icone' => 'ph-smiley',
                'cor' => 'text-logo-yellow',
                'fundo' => 'bg-yellow-100',
            ],
        ];
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center gap-2 text-gray-600">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">
                            <i class="ph ph-house"></i>
                        </a>
                    </li>
                    <li class="text-gray-400">
                        <i class="ph ph-caret-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('public.sinais') }}" class="hover:text-brand-600 transition-colors">Sinais</a>
                    </li>
                    <li class="text-gray-400">
                        <i class="ph ph-caret-right"></i>
                    </li>
                    <li class="font-medium text-gray-900">{{ $sinal->palavra_portugues }}</li>
                </ol>
            </nav>

            <div class="mb-8 overflow-hidden rounded-lg bg-white shadow-sm border border-gray-200">
                <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.5fr)_minmax(320px,0.8fr)]">
                    <div class="bg-brand-900">
                        @if ($sinal->video)
                            <video controls
                                class="w-full h-full min-h-[280px] max-h-[560px] object-contain bg-brand-900"
                                preload="metadata" autoplay muted playsinline loop>
                                <source src="{{ Storage::url($sinal->video->url_video) }}" type="video/mp4">
                                Seu navegador não suporta vídeo.
                            </video>
                        @else
                            <div class="min-h-[320px] flex items-center justify-center text-white">
                                <div class="text-center">
                                    <i class="ph ph-video-slash text-5xl opacity-80"></i>
                                    <p class="mt-3 text-sm opacity-90">Vídeo não disponível</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <aside class="p-6 lg:p-8 flex flex-col justify-between gap-8">
                        <div>
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-700 text-sm font-medium mb-4">
                                <i class="ph ph-hand-waving"></i>
                                Sinal em Libras
                            </div>

                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                                {{ $sinal->palavra_portugues }}
                            </h1>

                            @if ($sinal->definicao)
                                <p class="mt-4 text-gray-700 leading-relaxed">
                                    {{ $sinal->definicao }}
                                </p>
                            @endif
                        </div>

                        <section>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center">
                                    <i class="ph ph-book-open text-brand-600 text-xl"></i>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900">Contexto de utilização</h2>
                            </div>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $sinal->contexto_utilizacao ?: 'Nenhum contexto de utilização informado para este sinal.' }}
                            </p>
                        </section>
                    </aside>
                </div>
            </div>

            @if ($sinal->imagens->count() > 0)
                <section class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center">
                            <i class="ph ph-images text-brand-600 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Imagens de apoio</h2>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach ($sinal->imagens as $imagem)
                            <img src="{{ Storage::url($imagem->url_imagem) }}" alt="{{ $sinal->palavra_portugues }}"
                                class="w-full aspect-video object-cover rounded-lg border border-gray-200 bg-gray-50">
                        @endforeach
                    </div>
                </section>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-6">
                <div class="lg:col-span-2 space-y-8">
                    <section>
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Parâmetros do sinal</h2>
                            <span
                                class="hidden sm:inline-flex h-1 flex-1 rounded-full bg-gradient-to-r from-logo-green via-logo-sky to-logo-pink"></span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($parametros as $parametro)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-11 h-11 rounded-full {{ $parametro['fundo'] }} flex items-center justify-center shrink-0">
                                            <i
                                                class="ph {{ $parametro['icone'] }} {{ $parametro['cor'] }} text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $parametro['titulo'] }}</h3>
                                            <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                                                {{ $parametro['valor'] ?: 'Não informado.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="ph ph-folders text-brand-600"></i>
                            Categorias
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse ($sinal->categorias as $categoria)
                                <p
                                    class="inline-flex items-center px-3 py-1.5 rounded-full bg-brand-100 text-brand-700 text-sm font-medium hover:bg-brand-600 hover:text-white transition-colors">
                                    {{ $categoria->nome }}
                                </p>
                            @empty
                                <span class="text-sm text-gray-500">Sem categorias vinculadas.</span>
                            @endforelse
                        </div>
                    </section>

                    {{-- <section class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="ph ph-info text-brand-600"></i>
                            Informações
                        </h2>
                        <dl class="space-y-4 text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-gray-500">Criado em</dt>
                                <dd class="font-medium text-gray-900">{{ $sinal->created_at->format('d/m/Y') }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-gray-500">Atualizado em</dt>
                                <dd class="font-medium text-gray-900">{{ $sinal->updated_at->format('d/m/Y') }}</dd>
                            </div>
                        </dl>
                    </section> --}}

                    <a href="{{ route('public.sinais') }}"
                        class="inline-flex w-full items-center justify-center gap-2 px-4 py-3 rounded-lg bg-brand-600 text-white font-medium hover:bg-brand-700 transition-colors">
                        <i class="ph ph-arrow-left"></i>
                        Voltar para sinais
                    </a>
                </aside>
            </div>
        </div>
    </div>
</x-public-layout>
