<x-public-layout>
    <x-slot name="title">Sobre - Plataforma Digital Libras+</x-slot>

    <div class="bg-slate-50 py-8 sm:py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8" x-data="{
            activeTab: 'projeto',
            tabs: ['projeto', 'objetivos', 'equipe', 'apoio', 'materiais', 'contato'],
            init() {
                const tab = window.location.hash.replace('#', '');
                if (this.tabs.includes(tab)) this.activeTab = tab;
            },
            selectTab(tab, updateUrl = true) {
                if (!this.tabs.includes(tab)) return;
                this.activeTab = tab;
                if (updateUrl) history.replaceState(null, '', '#' + tab);
            },
            moveTab(direction) {
                const current = this.tabs.indexOf(this.activeTab);
                const next = (current + direction + this.tabs.length) % this.tabs.length;
                this.selectTab(this.tabs[next]);
                this.$nextTick(() => document.getElementById('tab-' + this.tabs[next])?.focus());
            }
        }"
            @hashchange.window="selectTab(window.location.hash.replace('#', '') || 'projeto', false)">

            <nav aria-label="Navegação estrutural" class="mb-7">
                <ol class="flex items-center gap-2 text-sm text-slate-600">
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
                    <li aria-current="page" class="font-medium text-slate-900">Sobre</li>
                </ol>
            </nav>

            <header class="overflow-hidden rounded-2xl bg-brand-700 text-white shadow-sm">
                <div class="grid items-center gap-8 px-6 py-9 sm:px-10 sm:py-12 lg:grid-cols-[minmax(0,1fr)_17rem]">
                    <div>
                        <p class="mb-3 text-sm font-bold uppercase tracking-wider text-brand-100">Plataforma Digital
                            Libras+</p>
                        <h1 class="max-w-3xl text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl">
                            Conhecimento em Libras mais acessível
                        </h1>
                        <p class="mt-5 max-w-3xl text-lg leading-relaxed text-slate-100">
                            Um repositório colaborativo criado para ampliar o acesso à terminologia acadêmica em Libras
                            e apoiar ensino, pesquisa e extensão.
                        </p>
                    </div>

                    <div class="hidden justify-center lg:flex" aria-hidden="true">
                        <div class="flex h-52 w-52 items-center justify-center rounded-full bg-white p-7 shadow-lg">
                            <img src="{{ asset('images/logo.svg') }}" alt=""
                                class="h-full w-full object-contain">
                        </div>
                    </div>
                </div>
            </header>

            <section class="mt-7" aria-labelledby="conteudo-sobre">
                <h2 id="conteudo-sobre" class="sr-only">Conteúdo sobre a plataforma</h2>

                <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">
                    <div role="tablist" aria-label="Informações sobre o projeto" class="flex gap-1 overflow-x-auto"
                        @keydown.right.prevent="moveTab(1)" @keydown.left.prevent="moveTab(-1)"
                        @keydown.home.prevent="selectTab(tabs[0]); $nextTick(() => document.getElementById('tab-' + tabs[0])?.focus())"
                        @keydown.end.prevent="selectTab(tabs[tabs.length - 1]); $nextTick(() => document.getElementById('tab-' + tabs[tabs.length - 1])?.focus())">
                        @php
                            $abas = [
                                ['id' => 'projeto', 'label' => 'O projeto', 'icone' => 'ph-info'],
                                ['id' => 'objetivos', 'label' => 'Objetivos', 'icone' => 'ph-target'],
                                ['id' => 'equipe', 'label' => 'Equipe', 'icone' => 'ph-users-three'],
                                ['id' => 'apoio', 'label' => 'Apoio', 'icone' => 'ph-hand-heart'],
                                ['id' => 'materiais', 'label' => 'Materiais', 'icone' => 'ph-books'],
                                ['id' => 'contato', 'label' => 'Contato', 'icone' => 'ph-envelope'],
                            ];
                        @endphp

                        @foreach ($abas as $aba)
                            <button type="button" id="tab-{{ $aba['id'] }}" role="tab"
                                aria-controls="panel-{{ $aba['id'] }}"
                                :aria-selected="activeTab === '{{ $aba['id'] }}'"
                                :tabindex="activeTab === '{{ $aba['id'] }}' ? 0 : -1"
                                @click="selectTab('{{ $aba['id'] }}')"
                                class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2"
                                :class="activeTab === '{{ $aba['id'] }}'
                                    ?
                                    'bg-brand-700 text-white shadow-sm' :
                                    'text-slate-700 hover:bg-slate-100'">
                                <i class="ph {{ $aba['icone'] }} text-lg" aria-hidden="true"></i>
                                {{ $aba['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5 min-h-[28rem]">
                    <section x-show="activeTab === 'projeto'" x-cloak id="panel-projeto" role="tabpanel"
                        aria-labelledby="tab-projeto" tabindex="0"
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm focus:outline-none sm:p-9">
                        <div class="grid gap-9 lg:grid-cols-[minmax(0,1.5fr)_minmax(16rem,0.7fr)]">
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wider text-brand-700">Nossa história</p>
                                <h2 class="mt-2 text-2xl font-bold text-slate-950 sm:text-3xl">O que é a Libras+?</h2>
                                <div class="mt-5 space-y-4 text-base leading-relaxed text-slate-700">
                                    <p>
                                        A Plataforma Digital Libras+ é uma iniciativa dedicada à criação de um
                                        repositório digital em Libras. Seu propósito é promover a inclusão de acadêmicos
                                        surdos no ensino superior, especialmente nos cursos da Universidade Aberta do
                                        Brasil (UAB) e da Unimontes.
                                    </p>
                                    <p>
                                        O projeto identifica e cataloga sinais específicos para terminologias acadêmicas
                                        em áreas como Letras, História, Geografia, Pedagogia, Educação Física,
                                        Matemática e Biologia, reunindo conteúdos de difícil acesso em um só lugar.
                                    </p>
                                    <p>
                                        A plataforma é desenvolvida de forma colaborativa por professores e
                                        pesquisadores surdos e ouvintes, aproximando conhecimento linguístico,
                                        experiência acadêmica e tecnologia.
                                    </p>
                                </div>
                            </div>

                            <aside class="rounded-2xl bg-brand-50 p-6" aria-labelledby="principios-titulo">
                                <h3 id="principios-titulo" class="text-lg font-bold text-brand-900">Princípios do
                                    projeto</h3>
                                <ul class="mt-5 space-y-4">
                                    <li class="flex gap-3 text-slate-700">
                                        <i class="ph ph-check-circle mt-0.5 shrink-0 text-xl text-brand-700"
                                            aria-hidden="true"></i>
                                        <span>Acesso claro e simples ao conhecimento.</span>
                                    </li>
                                    <li class="flex gap-3 text-slate-700">
                                        <i class="ph ph-check-circle mt-0.5 shrink-0 text-xl text-brand-700"
                                            aria-hidden="true"></i>
                                        <span>Valorização da Libras e da comunidade surda.</span>
                                    </li>
                                    <li class="flex gap-3 text-slate-700">
                                        <i class="ph ph-check-circle mt-0.5 shrink-0 text-xl text-brand-700"
                                            aria-hidden="true"></i>
                                        <span>Construção colaborativa e baseada em pesquisa.</span>
                                    </li>
                                </ul>
                            </aside>
                        </div>
                    </section>

                    <section x-show="activeTab === 'objetivos'" x-cloak id="panel-objetivos" role="tabpanel"
                        aria-labelledby="tab-objetivos" tabindex="0"
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm focus:outline-none sm:p-9">
                        <p class="text-sm font-bold uppercase tracking-wider text-brand-700">Onde queremos chegar</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-950 sm:text-3xl">Objetivos da plataforma</h2>
                        <p class="mt-4 max-w-4xl text-base leading-relaxed text-slate-700">
                            Desenvolver e manter uma plataforma digital destinada à catalogação, organização e
                            disponibilização de sinais em Libras de difícil acesso ou pouco difundidos.
                        </p>

                        <div class="mt-7 grid gap-4 md:grid-cols-2">
                            @foreach ([['ph-database', 'Centralizar', 'Reunir sinais acadêmicos em um repositório único, confiável e fácil de consultar.'], ['ph-student', 'Apoiar a educação', 'Oferecer suporte às atividades de ensino, pesquisa e extensão da UAB e da Unimontes.'], ['ph-hands-clapping', 'Valorizar a Libras', 'Contribuir para a preservação e difusão do conhecimento linguístico em Libras.'], ['ph-equals', 'Promover equidade', 'Fortalecer práticas educacionais inclusivas e ampliar o acesso ao conhecimento acadêmico.']] as [$icone, $titulo, $descricao])
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                                    <div
                                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-100 text-brand-800">
                                        <i class="ph {{ $icone }} text-2xl" aria-hidden="true"></i>
                                    </div>
                                    <h3 class="mt-4 text-lg font-bold text-slate-950">{{ $titulo }}</h3>
                                    <p class="mt-2 leading-relaxed text-slate-700">{{ $descricao }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section x-show="activeTab === 'equipe'" x-cloak id="panel-equipe" role="tabpanel"
                        aria-labelledby="tab-equipe" tabindex="0"
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm focus:outline-none sm:p-9">
                        <p class="text-sm font-bold uppercase tracking-wider text-brand-700">Construção colaborativa</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-950 sm:text-3xl">Nossa equipe</h2>
                        <p class="mt-3 max-w-3xl leading-relaxed text-slate-600">
                            Pessoas de diferentes áreas trabalhando juntas para tornar o conhecimento em Libras mais
                            acessível.
                        </p>

                        <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ([['Caio Luis Silva Macedo', 'Desenvolvedor'], ['Matheus de Sousa Barbosa', 'Desenvolvedor'], ['Helen Maria Rodrigues Cordeiro', 'Pesquisadora'], ['Simone Maria Oliveira Azevedo Rocha', 'Pesquisadora'], ['Christine Martins de Matos', 'Coordenadora'], ['Joeli Teixeira Antunes', 'Coordenadora']] as [$nome, $funcao])
                                <article class="flex items-center gap-4 rounded-xl border border-slate-200 p-5">
                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-800"
                                        aria-hidden="true">
                                        <i class="ph ph-user text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold leading-snug text-slate-950">{{ $nome }}</h3>
                                        <p class="mt-1 text-sm text-slate-600">{{ $funcao }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section x-show="activeTab === 'apoio'" x-cloak id="panel-apoio" role="tabpanel"
                        aria-labelledby="tab-apoio" tabindex="0"
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm focus:outline-none sm:p-9">
                        <p class="text-sm font-bold uppercase tracking-wider text-brand-700">Parcerias que tornam o
                            projeto possível</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-950 sm:text-3xl">Financiamento e apoio</h2>
                        <p class="mt-4 max-w-3xl leading-relaxed text-slate-700">
                            O desenvolvimento do projeto conta com financiamento institucional para pesquisa, inovação e
                            ampliação do acesso à educação.
                        </p>

                        <div class="mt-8 max-w-xl rounded-2xl border border-slate-200 bg-slate-50 p-7">
                            <img src="{{ asset('images/fapemig.png') }}" alt="Logotipo da FAPEMIG"
                                class="mx-auto h-24 max-w-full object-contain sm:h-28">
                            <div class="mt-6 border-t border-slate-200 pt-5 text-center">
                                <h3 class="font-bold text-slate-950">FAPEMIG</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                    Fundação de Amparo à Pesquisa do Estado de Minas Gerais.
                                </p>
                            </div>
                        </div>
                    </section>

                    <section x-show="activeTab === 'materiais'" x-cloak id="panel-materiais" role="tabpanel"
                        aria-labelledby="tab-materiais" tabindex="0"
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm focus:outline-none sm:p-9">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wider text-brand-700">Conteúdo para
                                    consulta</p>
                                <h2 class="mt-2 text-2xl font-bold text-slate-950 sm:text-3xl">Materiais e produções
                                </h2>
                                <p class="mt-3 max-w-3xl leading-relaxed text-slate-600">
                                    Consulte publicações e materiais produzidos no contexto do projeto.
                                </p>
                            </div>
                            @if ($materiais->isNotEmpty())
                                <span
                                    class="inline-flex w-fit rounded-full bg-brand-50 px-3 py-1 text-sm font-semibold text-brand-800">
                                    {{ $materiais->count() }}
                                    {{ $materiais->count() === 1 ? 'material' : 'materiais' }}
                                </span>
                            @endif
                        </div>

                        @if ($materiais->isNotEmpty())
                            <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($materiais as $material)
                                    <x-material-card titulo="{{ $material->titulo }}"
                                        descricao="{{ $material->descricao }}"
                                        link="{{ $material->arquivo_path }}" />
                                @endforeach
                            </div>
                        @else
                            <div
                                class="mt-7 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                                <i class="ph ph-books text-4xl text-slate-400" aria-hidden="true"></i>
                                <h3 class="mt-3 font-bold text-slate-900">Nenhum material disponível</h3>
                                <p class="mt-1 text-sm text-slate-600">Novos conteúdos serão publicados aqui.</p>
                            </div>
                        @endif
                    </section>

                    <section x-show="activeTab === 'contato'" x-cloak id="panel-contato" role="tabpanel"
                        aria-labelledby="tab-contato" tabindex="0"
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm focus:outline-none sm:p-9">
                        <div class="flex flex-col gap-3">
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wider text-brand-700">Mande uma mensagem
                                </p>
                                <h2 class="mt-2 text-2xl font-bold text-slate-950 sm:text-3xl">Entre em contato</h2>
                                <p class="mt-3 max-w-3xl leading-relaxed text-slate-600">
                                    Caso tenha dúvidas ou sugestões, preencha o formulário abaixo.
                                </p>
                            </div>
                            <form action="{{ route('public.contato') }}" method="POST" class="mt-5 sm:mt-0">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="nome" :value="__('Nome')" />
                                        <x-text-input id="nome" class="mt-1 block w-full" type="text" name="nome"
                                            :value="old('nome')" required autofocus />
                                        <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="mt-1 block w-full" type="email"
                                            name="email" :value="old('email')" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <x-input-label for="assunto" :value="__('Assunto')" />
                                    <x-text-input id="assunto" class="mt-1 block w-full" type="text" name="assunto"
                                        :value="old('assunto')" required />
                                    <x-input-error :messages="$errors->get('assunto')" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                    <x-input-label for="mensagem" :value="__('Mensagem')" />
                                    <textarea id="mensagem" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring focus:ring-brand-500 focus:ring-opacity-50 sm:text-sm"
                                        name="mensagem" rows="4" required>{{ old('mensagem') }}</textarea>
                                    <x-input-error :messages="$errors->get('mensagem')" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                    <x-primary-button class="w-full justify-center">
                                        Enviar mensagem
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
</x-public-layout>
