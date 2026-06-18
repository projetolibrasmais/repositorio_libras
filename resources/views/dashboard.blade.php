<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <!-- Cards de Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total de Sinais -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-logo-sky">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Sinais Cadastrados</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalSinais }}</p>
                        </div>
                        <div class="bg-brand-100 rounded-full p-3">
                            <i class="ph ph-hands-clapping text-brand-600 text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de Categorias -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Categorias Cadastradas</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalCategorias }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="ph ph-tag text-green-500 text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de Materiais -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Materiais Produzidos</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalMateriais }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <i class="ph ph-file-text text-purple-500 text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            @can('view_users')
                <!-- Total de Usuários -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-orange-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Usuários Ativos</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalUsuarios }}</p>
                            </div>
                            <div class="bg-orange-100 rounded-full p-3">
                                <i class="ph ph-users text-orange-500 text-3xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        <!-- Seção de Gráficos e Listas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Últimos Sinais Cadastrados -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="ph ph-clock-counter-clockwise text-brand-600 mr-2 text-2xl"></i>
                        Últimos Sinais Cadastrados
                    </h3>
                    <div class="space-y-3">
                        @forelse($ultimosSinais as $sinal)
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $sinal->palavra_portugues }}</p>
                                    <p class="text-sm text-gray-600">
                                        @if ($sinal->categorias->isNotEmpty())
                                            {{ $sinal->categorias->pluck('nome')->join(', ') }}
                                        @else
                                            Sem categoria
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $sinal->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Nenhum sinal cadastrado ainda.</p>
                        @endforelse
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('sinais.index') }}"
                            class="text-brand-600 hover:underline text-sm font-medium">
                            Ver todos os sinais →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categorias Mais Usadas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="ph ph-chart-bar text-green-500 mr-2 text-2xl"></i>
                        Categorias Mais Usadas
                    </h3>
                    <div class="space-y-3">
                        @forelse($categoriasMaisUsadas as $categoria)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-medium text-gray-900">{{ $categoria->nome }}</span>
                                        <span
                                            class="text-sm text-gray-600 font-semibold">{{ $categoria->sinais_count }}
                                            sinais</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full"
                                            style="width: {{ $totalSinais > 0 ? ($categoria->sinais_count / $totalSinais) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Nenhuma categoria cadastrada ainda.</p>
                        @endforelse
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('categorias.index') }}"
                            class="text-green-500 hover:underline text-sm font-medium">
                            Ver todas as categorias →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Crescimento Mensal e Atividades Recentes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Crescimento Mensal -->
            <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="ph ph-trend-up text-brand-600 mr-2 text-2xl"></i>
                        Crescimento Mensal de Sinais
                    </h3>
                    <div class="flex items-end justify-between space-x-2 h-64">
                        @forelse($crescimentoMensal as $mes)
                            @php
                                $maxTotal = $crescimentoMensal->max('total') ?: 1;
                                $altura = ($mes->total / $maxTotal) * 100;
                                $meses = [
                                    'Jan',
                                    'Fev',
                                    'Mar',
                                    'Abr',
                                    'Mai',
                                    'Jun',
                                    'Jul',
                                    'Ago',
                                    'Set',
                                    'Out',
                                    'Nov',
                                    'Dez',
                                ];
                                $nomeMes = $meses[$mes->mes - 1];
                            @endphp
                            <div class="flex-1 flex flex-col items-center">
                                <div class="relative w-full bg-gray-200 rounded-t-lg flex items-end justify-center"
                                    style="height: {{ $altura }}%; min-height: 30px;">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-brand-600 to-logo-sky rounded-t-lg">
                                    </div>
                                    <span class="relative text-white font-bold text-xs mb-1">{{ $mes->total }}</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-2 font-medium">{{ $nomeMes }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center w-full py-8">Sem dados para exibir</p>
                        @endforelse
                    </div>
                </div>
            </div>

            @can('view_logs')
                <!-- Atividades Recentes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="ph ph-activity text-purple-500 mr-2 text-2xl"></i>
                            Atividades Recentes
                        </h3>
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @forelse($atividadesRecentes as $atividade)
                                <div class="flex items-start space-x-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                    <div class="flex-shrink-0">
                                        @if ($atividade->event === 'created')
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-plus text-green-600 text-sm"></i>
                                            </div>
                                        @elseif($atividade->event === 'updated')
                                            <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-pencil text-brand-600 text-sm"></i>
                                            </div>
                                        @elseif($atividade->event === 'deleted')
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-trash text-red-600 text-sm"></i>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-dot-outline text-gray-600 text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900">
                                            <span class="font-medium">{{ $atividade->causer->name ?? 'Sistema' }}</span>
                                            {{ $atividade->description }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $atividade->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4 text-sm">Nenhuma atividade recente.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <!-- Estatísticas Adicionais -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

            <!-- Total de Vídeos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-gray-600">Total de Vídeos</h4>
                        <i class="ph ph-video text-red-500 text-2xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalVideos }}</p>
                    <p class="text-xs text-gray-500 mt-2">Vídeos de sinais cadastrados</p>
                </div>
            </div>

            <!-- Materiais por Tipo -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-gray-600">Tipos de Materiais</h4>
                        <i class="ph ph-files text-logo-pink text-2xl"></i>
                    </div>
                    <div class="space-y-2">
                        @forelse($materiaisPorTipo as $tipo)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-700">{{ ucfirst($tipo->tipo ?? 'Outro') }}</span>
                                <span class="font-semibold text-gray-900">{{ $tipo->total }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-500">Nenhum material cadastrado</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Acesso Rápido -->
            <div class="bg-brand-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold">Acesso Rápido</h4>
                        <i class="ph ph-lightning text-2xl"></i>
                    </div>
                    <div class="space-y-2">
                        @can('create_sinais')
                            <a href="{{ route('sinais.create') }}"
                                class="block px-3 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition text-sm">
                                <i class="ph ph-plus-circle mr-2"></i>Novo Sinal
                            </a>
                        @endcan
                        @can('create_categorias')
                            <a href="{{ route('categorias.create') }}"
                                class="block px-3 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition text-sm">
                                <i class="ph ph-plus-circle mr-2"></i>Nova Categoria
                            </a>
                        @endcan
                        @can('create_users')
                            <a href="{{ route('users.create') }}"
                                class="block px-3 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition text-sm">
                                <i class="ph ph-plus-circle mr-2"></i>Novo Usuário
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
