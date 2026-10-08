<x-app-layout>
    <div class="min-w-0 space-y-6 p-3 sm:p-6 lg:p-8">
        <section
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-900 via-brand-700 to-brand-600 p-6 sm:p-8 text-white shadow-lg">
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="min-w-0">
                    <p class="mb-2 text-sm font-medium text-brand-100">Painel administrativo</p>
                    <h1 class="text-2xl sm:text-3xl font-bold">Olá, {{ auth()->user()->name }}!</h1>
                    <p class="mt-2 max-w-2xl text-sm sm:text-base text-brand-100">Acompanhe o crescimento da Plataforma
                        Digital Libras+ e acesse rapidamente as principais rotinas.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @can('create_sinais')
                        <a href="{{ route('sinais.create') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-brand-800 hover:bg-brand-50"><i
                                class="ph ph-plus-circle text-lg"></i>Novo sinal</a>
                    @endcan
                    <a href="{{ route('ajuda.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-white/40 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/20"><i
                            class="ph ph-question text-lg"></i>Central de ajuda</a>
                </div>
            </div>
            <i class="ph ph-hands-clapping absolute -bottom-10 -right-6 text-[180px] text-white/5"
                aria-hidden="true"></i>
        </section>

        <section aria-label="Indicadores gerais"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 @canany(['view_users', 'view_contatos']) 2xl:grid-cols-5 @else 2xl:grid-cols-4 @endcan gap-3 sm:gap-5">
            @php
                $indicators = [
                    [
                        'label' => 'Sinais',
                        'value' => $totalSinais,
                        'icon' => 'ph-hand-waving',
                        'iconClass' => 'text-brand-600',
                        'bgClass' => 'bg-brand-100',
                        'route' => route('sinais.index'),
                    ],
                    [
                        'label' => 'Categorias',
                        'value' => $totalCategorias,
                        'icon' => 'ph-folders',
                        'iconClass' => 'text-logo-green',
                        'bgClass' => 'bg-green-100',
                        'route' => route('categorias.index'),
                    ],
                    [
                        'label' => 'Materiais',
                        'value' => $totalMateriais,
                        'icon' => 'ph-file-text',
                        'iconClass' => 'text-logo-orange',
                        'bgClass' => 'bg-orange-100',
                        'route' => route('materiais.index'),
                    ],
                    // [
                    //     'label' => 'Vídeos',
                    //     'value' => $totalVideos,
                    //     'icon' => 'ph-video-camera',
                    //     'iconClass' => 'text-logo-pink',
                    //     'bgClass' => 'bg-pink-100',
                    //     'route' => route('sinais.index'),
                    // ],
                ];
            @endphp
            @foreach ($indicators as $indicator)
                <a href="{{ $indicator['route'] }}"
                    class="group rounded-xl border border-brand-100 bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:border-logo-sky hover:shadow-md transition">
                    <div class="flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">{{ $indicator['label'] }}
                            </p>
                            <p class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $indicator['value'] }}</p>
                        </div>
                        <span
                            class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl {{ $indicator['bgClass'] }}"><i
                                class="ph {{ $indicator['icon'] }} {{ $indicator['iconClass'] }} text-xl sm:text-2xl"></i></span>
                    </div>
                </a>
            @endforeach
            @can('view_users')
                <a href="{{ route('users.index') }}"
                    class="group rounded-xl border border-brand-100 bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:border-logo-sky hover:shadow-md transition">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-gray-600">Usuários</p>
                            <p class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalUsuarios }}</p>
                        </div><span
                            class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-purple-100"><i
                                class="ph ph-users text-purple-600 text-xl sm:text-2xl"></i></span>
                    </div>
                </a>
            @endcan
            @can('view_contatos')
                <a href="{{ route('contatos.index', ['status' => 'nao_lidos']) }}"
                    class="group rounded-xl border border-brand-100 bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:border-logo-sky hover:shadow-md transition">
                    <div class="flex items-center justify-between gap-3">
                        <div><p class="text-xs sm:text-sm font-medium text-gray-600">Contatos novos</p><p class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalContatosNovos }}</p></div>
                        <span class="flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl bg-brand-100"><i class="ph ph-envelope-simple text-brand-600 text-xl sm:text-2xl"></i></span>
                    </div>
                </a>
            @endcan
        </section>

        @can('view_contatos')
            @if ($contatosNovos->isNotEmpty())
                <section class="rounded-xl border border-gray-200 bg-white shadow-sm">
                    <header class="flex items-center justify-between gap-4 border-b border-gray-200 px-5 py-4">
                        <div class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100"><i class="ph ph-envelope-simple text-brand-600 text-xl"></i></span><div><h2 class="font-semibold text-gray-900">Contatos novos</h2><p class="text-xs text-gray-500">Mensagens ainda não lidas</p></div></div>
                        <a href="{{ route('contatos.index', ['status' => 'nao_lidos']) }}" class="text-sm font-medium text-brand-600 hover:text-brand-800">Ver todos</a>
                    </header>
                    <div class="divide-y divide-gray-100 px-4">
                        @foreach ($contatosNovos as $contato)
                            <a href="{{ route('contatos.show', $contato) }}" class="flex items-center gap-4 rounded-lg px-3 py-3 hover:bg-brand-50">
                                <span class="min-w-0 flex-1"><strong class="block truncate text-sm text-gray-900">{{ $contato->assunto }}</strong><span class="block truncate text-xs text-gray-500">{{ $contato->nome }} · {{ $contato->email }}</span></span>
                                <span class="hidden sm:block text-xs text-gray-500">{{ $contato->created_at->diffForHumans() }}</span><i class="ph ph-caret-right text-gray-400"></i>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        @endcan

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <section class="min-w-0 xl:col-span-2 rounded-xl border border-gray-200 bg-white shadow-sm">
                <header class="flex items-center justify-between gap-4 border-b border-gray-200 px-5 py-4">
                    <div class="flex items-center gap-3"><span
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100"><i
                                class="ph ph-clock-counter-clockwise text-brand-600 text-xl"></i></span>
                        <div>
                            <h2 class="font-semibold text-gray-900">Sinais recentes</h2>
                            <p class="text-xs text-gray-500">Últimos cadastros realizados</p>
                        </div>
                    </div>
                    <a href="{{ route('sinais.index') }}"
                        class="text-sm font-medium text-brand-600 hover:text-brand-800">Ver todos</a>
                </header>
                <div class="p-4 sm:p-5">
                    @forelse ($ultimosSinais as $sinal)
                        <a href="{{ route('sinais.show', $sinal) }}"
                            class="flex items-center gap-4 rounded-lg px-3 py-3 hover:bg-brand-50">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-100"><i
                                    class="ph ph-hand-waving text-brand-600"></i></span>
                            <span class="min-w-0 flex-1"><strong
                                    class="block truncate text-sm text-gray-900">{{ $sinal->palavra_portugues }}</strong><span
                                    class="block truncate text-xs text-gray-500">{{ $sinal->categorias->pluck('nome')->join(', ') ?: 'Sem categoria' }}</span></span>
                            <span
                                class="hidden sm:block text-xs text-gray-500">{{ $sinal->created_at->diffForHumans() }}</span><i
                                class="ph ph-caret-right text-gray-400"></i>
                        </a>
                    @empty
                        <div class="py-10 text-center"><span
                                class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-brand-100"><i
                                    class="ph ph-hand-waving text-brand-600 text-2xl"></i></span>
                            <h3 class="mt-3 font-semibold text-gray-900">Nenhum sinal cadastrado</h3>
                            <p class="mt-1 text-sm text-gray-500">Cadastre o primeiro sinal para começar a preencher o
                                repositório.</p>
                            @can('create_sinais')
                                <a href="{{ route('sinais.create') }}"
                                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700"><i
                                        class="ph ph-plus"></i>Cadastrar sinal</a>
                            @endcan
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="min-w-0 rounded-xl border border-gray-200 bg-white shadow-sm">
                <header class="flex items-center gap-3 border-b border-gray-200 px-5 py-4"><span
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100"><i
                            class="ph ph-chart-bar text-logo-green text-xl"></i></span>
                    <div>
                        <h2 class="font-semibold text-gray-900">Categorias em destaque</h2>
                        <p class="text-xs text-gray-500">Mais utilizadas nos sinais</p>
                    </div>
                </header>
                <div class="p-5 space-y-4">
                    @forelse ($categoriasMaisUsadas as $categoria)
                        @php($percentage = $totalSinais > 0 ? min(100, ($categoria->sinais_count / $totalSinais) * 100) : 0)
                        <div>
                            <div class="mb-1.5 flex items-center justify-between gap-3 text-sm"><span
                                    class="truncate font-medium text-gray-800">{{ $categoria->nome }}</span><span
                                    class="shrink-0 text-xs text-gray-500">{{ $categoria->sinais_count }}
                                    {{ $categoria->sinais_count === 1 ? 'sinal' : 'sinais' }}</span></div>
                            <div class="h-2 overflow-hidden rounded-full bg-gray-200">
                                <div class="h-full rounded-full bg-logo-green" style="width: {{ $percentage }}%">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-gray-500">Nenhuma categoria cadastrada.</p>
                    @endforelse
                    <a href="{{ route('categorias.index') }}"
                        class="inline-flex items-center gap-1 text-sm font-medium text-brand-600 hover:text-brand-800">Ver
                        categorias <i class="ph ph-arrow-right"></i></a>
                </div>
            </section>
        </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <section class="min-w-0 @can(['view_logs', 'view_materiais']) xl:col-span-2 @else xl:col-span-3 @endcan rounded-xl border border-gray-200 bg-white shadow-sm">
                    <header class="border-b border-gray-200 px-5 py-4">
                        <div class="flex items-center gap-3"><span
                                class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100"><i
                                    class="ph ph-trend-up text-brand-600 text-xl"></i></span>
                            <div>
                            <h2 class="font-semibold text-gray-900">Crescimento mensal</h2>
                            <p class="text-xs text-gray-500">Sinais cadastrados nos últimos meses</p>
                        </div>
                    </div>
                </header>
                <div class="p-5">
                    @if ($crescimentoMensal->isNotEmpty())
                        <div class="overflow-x-auto pb-2" role="region" aria-label="Gráfico de crescimento mensal" tabindex="0">
                        <div class="flex h-52 min-w-[420px] items-end gap-3 sm:gap-5">
                            @php($maxTotal = $crescimentoMensal->max('total') ?: 1)
                            @foreach ($crescimentoMensal as $mes)
                                @php($altura = max(12, ($mes->total / $maxTotal) * 100))
                                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2"><span
                                        class="text-xs font-semibold text-brand-700">{{ $mes->total }}</span>
                                    <div class="w-full max-w-16 rounded-t-lg bg-gradient-to-t from-brand-700 to-logo-sky"
                                        style="height: {{ $altura }}%"></div><span
                                        class="text-xs font-medium text-gray-500">{{ ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'][$mes->mes - 1] }}/{{ substr($mes->ano, -2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        </div>
                    @else
                        <div class="py-10 text-center"><i class="ph ph-chart-line text-4xl text-gray-300"></i>
                            <p class="mt-2 text-sm text-gray-500">O gráfico aparecerá após o cadastro dos primeiros
                                sinais.</p>
                        </div>
                    @endif
                </div>
            </section>

            <div class="space-y-6">
                @can('view_logs')
                    <section class="rounded-xl border border-gray-200 bg-white shadow-sm">
                        <header class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                            <h2 class="font-semibold text-gray-900">Atividades recentes</h2><a
                                href="{{ route('logs.index') }}" class="text-xs font-medium text-brand-600">Ver logs</a>
                        </header>
                        <div class="max-h-64 overflow-y-auto p-3">
                            @forelse ($atividadesRecentes->take(5) as $atividade)
                                <div class="flex gap-3 rounded-lg p-2 hover:bg-gray-50"><span
                                        class="mt-1 h-2 w-2 shrink-0 rounded-full bg-logo-sky"></span>
                                    <div class="min-w-0">
                                        <p class="line-clamp-2 text-sm text-gray-700">
                                            <strong>{{ $atividade->causer->name ?? 'Sistema' }}</strong>
                                            {{ $atividade->description }} - {{ $atividade->log_name }}</p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $atividade->created_at->diffForHumans() }}</p>
                                    </div>
                            </div>@empty<p class="py-6 text-center text-sm text-gray-500">Nenhuma atividade recente.
                                </p>
                            @endforelse
                        </div>
                    </section>
                @endcan
                @can('view_materiais')
                    <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="font-semibold text-gray-900">Materiais por tipo</h2>
                                <p class="text-xs text-gray-500">{{ $totalMateriais }} no total</p>
                            </div><i class="ph ph-files text-logo-orange text-2xl"></i>
                        </div>
                        <div class="mt-4 space-y-2">
                            @forelse ($materiaisPorTipo as $tipo)
                                <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2 text-sm">
                                    <span class="text-gray-700">{{ ucfirst($tipo->tipo ?? 'Outro') }}</span><strong
                                    class="text-gray-900">{{ $tipo->total }}</strong></div>@empty<p
                                    class="text-sm text-gray-500">Nenhum material cadastrado.</p>
                            @endforelse
                        </div>
                    </section>
                @endcan
            </div>
        </div>

        <section class="rounded-xl border border-brand-100 bg-white p-5 shadow-sm">
            <div class="mb-4">
                <h2 class="font-semibold text-gray-900">Ações rápidas</h2>
                <p class="text-xs text-gray-500">Atalhos para as tarefas mais frequentes</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @can('create_sinais')
                    <a href="{{ route('sinais.create') }}"
                        class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 hover:border-logo-sky hover:bg-brand-50"><i
                            class="ph ph-hand-waving text-brand-600 text-xl"></i><span
                            class="text-sm font-medium text-gray-800">Novo sinal</span></a>
                @endcan
                @can('create_categorias')
                    <a href="{{ route('categorias.create') }}"
                        class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 hover:border-logo-green hover:bg-green-50"><i
                            class="ph ph-folder-plus text-logo-green text-xl"></i><span
                            class="text-sm font-medium text-gray-800">Nova categoria</span></a>
                @endcan
                @can('create_materiais')
                    <a href="{{ route('materiais.create') }}"
                        class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 hover:border-logo-orange hover:bg-orange-50"><i
                            class="ph ph-file-plus text-logo-orange text-xl"></i><span
                            class="text-sm font-medium text-gray-800">Novo material</span></a>
                @endcan
                @can('create_users')
                    <a href="{{ route('users.create') }}"
                        class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 hover:border-logo-pink hover:bg-pink-50"><i
                            class="ph ph-user-plus text-logo-pink text-xl"></i><span
                            class="text-sm font-medium text-gray-800">Novo usuário</span></a>
                @endcan
            </div>
        </section>
    </div>
</x-app-layout>
