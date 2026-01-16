<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sinais') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Sinais" description="Gerencie todas os sinais do sistema">
                    <x-slot name="action">
                        @can('create_sinais')
                            <a href="{{ route('sinais.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="ph ph-plus mr-2"></i>
                                Novo Sinal
                            </a>
                        @endcan
                    </x-slot>
                </x-page-header>

                <!-- Search Bar -->
                <div x-data="{ filtersOpen: false }" class="mb-4">
                    <!-- Search and Filter Bar -->
                    <form method="GET" class="space-y-3">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Search Input -->
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Pesquisar sinais..."
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" />
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 sm:justify-end">
                                <!-- Filter Button -->
                                <button @click.prevent="filtersOpen = !filtersOpen" type="button"
                                    class="inline-flex items-center px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors relative">
                                    <i class="ph ph-funnel mr-2"></i>
                                    Filtros
                                    <span x-show="filtersOpen" class="ml-2">
                                        <i class="ph ph-caret-up"></i>
                                    </span>
                                    <span x-show="!filtersOpen" class="ml-2">
                                        <i class="ph ph-caret-down"></i>
                                    </span>
                                    @if (request()->hasAny(['categoria_id', 'date_from', 'date_to', 'show_deleted']))
                                        <span
                                            class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-blue-600 rounded-full">
                                            {{ collect(['categoria_id', 'date_from', 'date_to', 'show_deleted'])->filter(fn($key) => request()->filled($key))->count() }}
                                        </span>
                                    @endif
                                </button>

                                <!-- Search Button -->
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="ph ph-magnifying-glass mr-2"></i>
                                    Buscar
                                </button>

                                <!-- Clear Button -->
                                @if (request('search') || request()->hasAny(['categoria_id', 'date_from', 'date_to', 'show_deleted']))
                                    <a href="{{ url()->current() }}"
                                        class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
                                        <i class="ph ph-x mr-2"></i>
                                        Limpar
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Filter Panel -->
                        <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="bg-gray-50 border border-gray-200 rounded-lg p-4" style="display: none;">

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- User Filter -->
                                @if (count($categorias) > 0)
                                    <div>
                                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="ph ph-bookmark mr-1"></i>
                                            Categoria
                                        </label>
                                        <select name="categoria_id" id="categoria_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="">Todas as categorias</option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}"
                                                    {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                    {{ $categoria->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                 <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="ph ph-tag mr-1"></i>
                                        Status
                                    </label>
                                    <select name="status" id="status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Todos</option>
                                        <option value="catalogado" {{ request('status') == 'catalogado' ? 'selected' : '' }}>Catalogado</option>
                                        <option value="em_validacao" {{ request('status') == 'em_validacao' ? 'selected' : '' }}>Em Validação</option>
                                        <option value="publicado" {{ request('status') == 'publicado' ? 'selected' : '' }}>Publicado</option>
                                    </select>
                                </div>

                                <!-- Date From -->
                                <div>
                                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="ph ph-calendar mr-1"></i>
                                        Criado de
                                    </label>
                                    <input type="date" name="date_from" id="date_from"
                                        value="{{ request('date_from') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>

                                <!-- Date To -->
                                <div>
                                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="ph ph-calendar mr-1"></i>
                                        Criado até
                                    </label>
                                    <input type="date" name="date_to" id="date_to"
                                        value="{{ request('date_to') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>

                                <!-- Show Deleted Filter -->
                                <div>
                                    <label for="show_deleted" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="ph ph-trash mr-1"></i>
                                        Sinais Deletados
                                    </label>
                                    <select name="show_deleted" id="show_deleted"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="" {{ request('show_deleted') == '' ? 'selected' : '' }}>Apenas Ativos</option>
                                        <option value="with" {{ request('show_deleted') == 'with' ? 'selected' : '' }}>Todos</option>
                                        <option value="only" {{ request('show_deleted') == 'only' ? 'selected' : '' }}>Apenas Deletados</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                @if ($sinais->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            #
                        </x-table-header>
                        <x-table-header column="palavra_portugues" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Palavra em Português
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Status
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Categorias
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                            @foreach ($sinais as $sinal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $sinal->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-hand-waving text-purple-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $sinal->palavra_portugues }}
                                                </div>
                                                @if($sinal->trashed())
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="ph ph-trash text-xs mr-1"></i>
                                                        Deletado
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @switch($sinal->status)
                                                @case('em_validacao')
                                                    <div
                                                        class="text-xs font-medium text-orange-700 bg-orange-200 py-1 px-2 rounded-md">
                                                        Em Validação
                                                    </div>
                                                @break

                                                @case('catalogado')
                                                    <div
                                                        class="text-xs font-medium text-blue-700 bg-blue-200 py-1 px-2 rounded-md">
                                                        Catalogado
                                                    </div>
                                                @break

                                                @case('publicado')
                                                    <div
                                                        class="text-xs font-medium text-green-700 bg-green-200 py-1 px-2 rounded-md">
                                                        Publicado
                                                    </div>
                                                @break

                                                @default
                                            @endswitch
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            @if ($sinal->categorias && $sinal->categorias->count())
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($sinal->categorias as $categoria)
                                                        @php
                                                        $cores = [
                                                            'bg-blue-100 text-blue-800 border-blue-200',
                                                            'bg-green-100 text-green-800 border-green-200',
                                                            'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                            'bg-red-100 text-red-800 border-red-200',
                                                            'bg-purple-100 text-purple-800 border-purple-200',
                                                            'bg-pink-100 text-pink-800 border-pink-200',
                                                            'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                            'bg-teal-100 text-teal-800 border-teal-200',
                                                        ];
                                                        // garante índice válido mesmo se o ID for alto
                                                        $cor = $cores[($categoria->id - 1) % count($cores)];
                                                    @endphp

                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold border {{ $cor }}">
                                                        {{ $categoria->nome }}
                                                    </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-600">Nenhuma categoria atribuída a este sinal.</p>
                                            @endif
                                        </div>
                                    </td>


                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $sinal->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            @if($sinal->trashed())
                                                <!-- Restore Button -->
                                                @can('edit_sinais')
                                                    <form action="{{ route('sinais.restore', $sinal->id) }}" method="POST"
                                                        class="restore-form-{{ $sinal->id }}">
                                                        @csrf
                                                        <button type="button"
                                                            onclick="restoreForm = document.querySelector('.restore-form-{{ $sinal->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'restore-sinal' }));"
                                                            class="bg-green-100 text-green-600 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors"
                                                            title="Restaurar">
                                                            <i class="ph ph-arrow-counter-clockwise text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                                
                                                <!-- Force Delete Button -->
                                                @can('delete_sinais')
                                                    <form action="{{ route('sinais.force-delete', $sinal->id) }}" method="POST"
                                                        class="force-delete-form-{{ $sinal->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="forceDeleteForm = document.querySelector('.force-delete-form-{{ $sinal->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'force-delete-sinal' }));"
                                                            class="bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors"
                                                            title="Excluir Permanentemente">
                                                            <i class="ph ph-trash text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @else
                                                <a href="{{ route('sinais.show', $sinal) }}"
                                                    class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                                                    <i class="ph ph-eye text-lg"></i>
                                                </a>
                                                @can('edit_sinais')
                                                    <a href="{{ route('sinais.edit', $sinal) }}"
                                                        class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">
                                                        <i class="ph ph-pencil text-lg"></i>
                                                    </a>
                                                @endcan
                                                @can('delete_sinais')
                                                    <form action="{{ route('sinais.destroy', $sinal) }}" method="POST"
                                                        class="delete-form-{{ $sinal->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="deleteForm = document.querySelector('.delete-form-{{ $sinal->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-sinal' }));"
                                                            class="bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors">
                                                            <i class="ph ph-trash text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table>

                    <!-- Pagination -->
                    <x-pagination :paginator="$sinais" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-shield-checkered text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhuma sinal encontrada</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontradas sinais com o termo "{{ request('search') }}".
                            @else
                                Não há sinais cadastradas no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <x-delete-modal name="delete-sinal" title="Confirmar Exclusão do Sinal"
        message="Tem certeza que deseja excluir este sinal? O sinal e o vídeo associado serão movidos para a lixeira, mas o arquivo permanecerá no storage." />

    <!-- Restore Modal -->
    <x-restore-modal name="restore-sinal" title="Confirmar Restauração do Sinal"
        message="Tem certeza que deseja restaurar este sinal? O sinal e o vídeo associado serão restaurados." />

    <!-- Force Delete Modal -->
    <x-force-delete-modal name="force-delete-sinal" title="Confirmar Exclusão Permanente do Sinal"
        message="Tem certeza que deseja excluir este sinal permanentemente? O sinal, o vídeo e o arquivo no storage serão removidos. Esta ação não pode ser desfeita!" />

    @push('scripts')
        <script>
            let deleteForm = null;
            let restoreForm = null;
            let forceDeleteForm = null;

            function confirmDelete() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            }

            function confirmRestore() {
                if (restoreForm) {
                    restoreForm.submit();
                }
            }

            function confirmForceDelete() {
                if (forceDeleteForm) {
                    forceDeleteForm.submit();
                }
            }
        </script>
    @endpush
</x-app-layout>
