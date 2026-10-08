<x-public-layout>
    <x-slot name="title">{{ $sinal->palavra_portugues }} - Repositório de Libras</x-slot>

    @php
        $parametros = [
            [
                'titulo' => 'Configuração de mão',
                'valor' => $sinal->config_mao,
                'icone' => 'ph-hand',
            ],
            [
                'titulo' => 'Ponto de articulação',
                'valor' => $sinal->ponto_articulacao,
                'icone' => 'ph-crosshair',
            ],
            [
                'titulo' => 'Orientação da palma',
                'valor' => $sinal->orientacao_palma_mao,
                'icone' => 'ph-arrows-clockwise',
            ],
            [
                'titulo' => 'Movimento',
                'valor' => $sinal->movimento,
                'icone' => 'ph-path',
            ],
            [
                'titulo' => 'Expressão não manual',
                'valor' => $sinal->expressao_nao_manual,
                'icone' => 'ph-smiley',
            ],
        ];
    @endphp

    <div class="sinal-detail bg-slate-50 py-8 sm:py-12">
        <article class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Navegação estrutural" class="mb-7">
                <ol class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
                    <li>
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 rounded-md font-medium text-brand-700 hover:text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                            <i class="ph ph-house" aria-hidden="true"></i>
                            Início
                        </a>
                    </li>
                    <li aria-hidden="true" class="text-slate-400">
                        <i class="ph ph-caret-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('public.sinais') }}"
                            class="rounded-md font-medium text-brand-700 hover:text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                            Sinais
                        </a>
                    </li>
                    <li aria-hidden="true" class="text-slate-400">
                        <i class="ph ph-caret-right"></i>
                    </li>
                    <li aria-current="page" class="max-w-52 truncate font-medium text-slate-900 sm:max-w-none">
                        {{ $sinal->palavra_portugues }}
                    </li>
                </ol>
            </nav>

            <header class="mb-7 flex flex-col md:flex-row md:items-center md:justify-between md:gap-4">
                <div class="flex-col items-center gap-2">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl lg:text-5xl">
                        {{ $sinal->palavra_portugues }}
                    </h1>

                    @if ($sinal->definicao)
                        <p class=" max-w-3xl text-lg leading-relaxed text-slate-700">
                            {{ $sinal->definicao }}
                        </p>
                    @endif
                </div>

                @if ($sinal->categorias->isNotEmpty())
                    <div class="mt-2 flex flex-wrap gap-2" aria-label="Categorias deste sinal">
                        @foreach ($sinal->categorias as $categoria)
                            <a href="{{ route('public.sinais', ['categorias' => ['nome' => $categoria->nome]]) }}"
                                class="inline-flex min-h-8 items-center rounded-full border border-brand-100 bg-brand-50 px-4 py-2 text-xs font-semibold text-brand-800 transition hover:border-brand-500 hover:bg-brand-100 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                                {{ $categoria->nome }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </header>

            {{-- <nav aria-label="Conteúdo desta página"
                class="mb-7 flex flex-wrap gap-2 rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                <a href="#demonstracao"
                    class="inline-flex min-h-11 items-center gap-2 rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                    <i class="ph ph-play-circle text-lg" aria-hidden="true"></i>
                    Ver demonstração
                </a>
                <a href="#parametros"
                    class="inline-flex min-h-11 items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                    <i class="ph ph-list-checks text-lg" aria-hidden="true"></i>
                    Ver características
                </a>
                @if ($sinal->imagens->isNotEmpty())
                    <a href="#imagens"
                        class="inline-flex min-h-11 items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                        <i class="ph ph-images text-lg" aria-hidden="true"></i>
                        Ver imagens
                    </a>
                @endif
            </nav> --}}

            <section id="demonstracao" aria-labelledby="demonstracao-titulo"
                class="scroll-mt-28 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-slate-950 p-3 sm:p-6">
                    @if ($sinal->video)
                        <video controls playsinline autoplay loop preload="metadata"
                            class="mx-auto aspect-video max-h-[36rem] w-full rounded-xl bg-black object-contain"
                            aria-label="Vídeo demonstrando o sinal {{ $sinal->palavra_portugues }}">
                            <source src="{{ Storage::url($sinal->video->url_video) }}" type="video/mp4">
                            Seu navegador não oferece suporte à reprodução de vídeo.
                        </video>
                    @else
                        <div
                            class="flex aspect-video min-h-64 flex-col items-center justify-center rounded-xl border border-slate-700 bg-slate-900 px-6 text-center text-white">
                            <i class="ph ph-video-camera-slash mb-3 text-4xl" aria-hidden="true"></i>
                            <p class="text-lg font-semibold">Vídeo indisponível</p>
                            <p class="mt-1 text-sm text-slate-300">Consulte as características do sinal logo abaixo.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- <aside class="p-5 sm:p-7" aria-labelledby="uso-titulo">
                        <h2 id="uso-titulo" class="flex items-center gap-2 text-lg font-bold text-slate-950">
                            <i class="ph ph-chat-text text-2xl text-brand-700" aria-hidden="true"></i>
                            Contexto de uso
                        </h2>
                        @if ($sinal->contexto_utilizacao)
                            <p class="mt-3 whitespace-pre-line text-base leading-relaxed text-slate-700">
                                {{ $sinal->contexto_utilizacao }}</p>
                        @else
                            <p class="mt-3 text-base leading-relaxed text-slate-600">
                                Nenhum contexto de uso foi informado para este sinal.
                            </p>
                        @endif

                        <div class="mt-6 rounded-xl bg-brand-50 p-4 text-sm leading-relaxed text-brand-900">
                            <p class="flex gap-2">
                                <i class="ph ph-info mt-0.5 shrink-0 text-lg" aria-hidden="true"></i>
                                <span>Observe as mãos, o movimento, o rosto e a posição do corpo durante toda a
                                    demonstração.</span>
                            </p>
                        </div>
                    </aside> --}}
            </section>

            <section id="parametros" aria-labelledby="parametros-titulo"
                class="mt-8 scroll-mt-28 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="max-w-3xl">
                    <h2 id="parametros-titulo" class="text-2xl font-bold text-slate-950">Características do sinal</h2>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Informações visuais que ajudam a compreender e reproduzir o sinal corretamente.
                    </p>
                </div>

                <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div id="uso" class="scroll-mt-28 rounded-xl border border-slate-200 bg-slate-50 p-5 sm:col-span-2">
                        <dt class="flex items-center gap-3 font-bold text-slate-950">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-100 text-brand-800">
                                <i class="ph ph-chat-text text-xl" aria-hidden="true"></i>
                            </span>
                            Contexto de uso
                        </dt>
                        <dd class="mt-3 whitespace-pre-line text-base leading-relaxed text-slate-700">{{ filled($sinal->contexto_utilizacao) ? $sinal->contexto_utilizacao : 'Nenhum contexto de uso foi informado para este sinal.' }}</dd>
                    </div>
                    @foreach ($parametros as $indice => $parametro)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                            <dt class="flex items-center gap-3 font-bold text-slate-950">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-100 text-brand-800">
                                    <i class="ph {{ $parametro['icone'] }} text-xl" aria-hidden="true"></i>
                                </span>
                                <span>
                                    <span class="sr-only">Característica {{ $indice + 1 }}: </span>
                                    {{ $parametro['titulo'] }}
                                </span>
                            </dt>
                            <dd class="mt-3 text-base leading-relaxed text-slate-700">
                                {{ filled($parametro['valor']) ? $parametro['valor'] : 'Não informado' }}
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            @if ($sinal->imagens->isNotEmpty())
                <section id="imagens" aria-labelledby="imagens-titulo"
                    x-data="{
                        imagemAberta: null,
                        imagemAlt: '',
                        botaoOrigem: null,
                        abrir(event) {
                            this.botaoOrigem = event.currentTarget;
                            this.imagemAberta = this.botaoOrigem.dataset.src;
                            this.imagemAlt = this.botaoOrigem.dataset.alt;
                            this.$nextTick(() => this.$refs.fecharImagem.focus());
                        },
                        fechar() {
                            this.imagemAberta = null;
                            this.$nextTick(() => this.botaoOrigem?.focus());
                        }
                    }"
                    @keydown.escape.window="if (imagemAberta) fechar()"
                    class="mt-8 scroll-mt-28 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                    <h2 id="imagens-titulo" class="text-2xl font-bold text-slate-950">Imagens de apoio</h2>
                    <p class="mt-2 text-base text-slate-600">Selecione uma imagem para visualizá-la em tamanho maior.
                    </p>

                    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach ($sinal->imagens as $indice => $imagem)
                            <button type="button" @click="abrir($event)"
                                data-src="{{ Storage::url($imagem->url_imagem) }}"
                                data-alt="Imagem de apoio {{ $indice + 1 }} do sinal {{ $sinal->palavra_portugues }}"
                                class="group overflow-hidden rounded-xl border border-slate-200 bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                                <img src="{{ Storage::url($imagem->url_imagem) }}"
                                    alt="Imagem de apoio {{ $indice + 1 }} do sinal {{ $sinal->palavra_portugues }}"
                                    loading="lazy"
                                    class="aspect-square w-full object-cover transition duration-200 group-hover:scale-105">
                                <span
                                    class="flex min-h-11 items-center justify-center gap-2 bg-white px-3 py-2 text-sm font-semibold text-brand-800">
                                    <i class="ph ph-arrows-out" aria-hidden="true"></i>
                                    Ampliar imagem
                                </span>
                            </button>
                        @endforeach
                    </div>
                    <template x-teleport="body">
                        <div x-show="imagemAberta" x-cloak
                            class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-950/95 p-4 sm:p-8"
                            role="dialog" aria-modal="true" aria-label="Imagem ampliada"
                            @click.self="fechar()">
                            <button type="button" x-ref="fecharImagem" @click="fechar()"
                                class="absolute right-4 top-4 z-10 flex min-h-11 items-center gap-2 rounded-lg bg-white px-4 py-2 font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500"
                                aria-label="Fechar imagem ampliada">
                                <i class="ph ph-x text-xl" aria-hidden="true"></i>
                                <span class="hidden sm:inline">Fechar</span>
                            </button>
                            <img :src="imagemAberta" :alt="imagemAlt"
                                class="max-h-full max-w-full object-contain">
                        </div>
                    </template>
                </section>
            @endif

            <footer
                class="mt-8 flex flex-col gap-3 border-t border-slate-200 pt-7 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('public.sinais') }}"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 font-semibold text-slate-800 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                    <i class="ph ph-arrow-left" aria-hidden="true"></i>
                    Voltar para sinais
                </a>
                <a href="{{ route('public.sinais') }}"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-brand-700 px-5 py-3 font-semibold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                    <i class="ph ph-magnifying-glass" aria-hidden="true"></i>
                    Buscar outro sinal
                </a>
            </footer>
        </article>
    </div>
</x-public-layout>
