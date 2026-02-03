<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materiais') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Materiais" description="Gerencie todos os materiais do sistema">
                    <x-slot name="action">
                        @can('create_materiais')
                            <a href="{{ route('materiais.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="ph ph-plus mr-2"></i>
                                Novo Material
                            </a>
                        @endcan
                    </x-slot>
                </x-page-header>

                <!-- Search Bar -->
                <x-search-bar placeholder="Pesquisar materiais..." :filterKeys="['date_from', 'date_to', 'show_deleted']">
                    <x-slot name="filters">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Date From -->
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="ph ph-calendar mr-1"></i>
                                    Criado de
                                </label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>

                            <!-- Date To -->
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="ph ph-calendar mr-1"></i>
                                    Criado até
                                </label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>

                            <!-- Show Deleted Filter -->
                            <div>
                                <label for="show_deleted" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="ph ph-trash mr-1"></i>
                                    Materiais Deletados
                                </label>
                                <select name="show_deleted" id="show_deleted"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="" {{ request('show_deleted') == '' ? 'selected' : '' }}>Apenas
                                        Ativos</option>
                                    <option value="with" {{ request('show_deleted') == 'with' ? 'selected' : '' }}>
                                        Todos</option>
                                    <option value="only" {{ request('show_deleted') == 'only' ? 'selected' : '' }}>
                                        Apenas Deletados</option>
                                </select>
                            </div>
                        </div>
                    </x-slot>
                </x-search-bar>

                <!-- Table -->
                @if ($materiais->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            #
                        </x-table-header>
                        <x-table-header column="titulo" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Título
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                            @foreach ($materiais as $material)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $material->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-file-text text-blue-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $material->titulo }}
                                                </div>
                                                @if ($material->descricao)
                                                    <div class="text-sm text-gray-500">
                                                        {{ Str::limit($material->descricao, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $material->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            @if ($material->trashed())
                                                <!-- Restore Button -->
                                                @can('restore_materiais')
                                                    <form action="{{ route('materiais.restore', $material->id) }}"
                                                        method="POST" class="restore-form-{{ $material->id }}">
                                                        @csrf
                                                        <button type="button"
                                                            onclick="restoreForm = document.querySelector('.restore-form-{{ $material->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'restore-material' }));"
                                                            class="bg-green-100 text-green-600 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors"
                                                            title="Restaurar">
                                                            <i class="ph ph-arrow-counter-clockwise text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endcan

                                                <!-- Force Delete Button -->
                                                @can('force_delete_materiais')
                                                    <form action="{{ route('materiais.force-delete', $material->id) }}"
                                                        method="POST" class="force-delete-form-{{ $material->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="forceDeleteForm = document.querySelector('.force-delete-form-{{ $material->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'force-delete-material' }));"
                                                            class="bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors"
                                                            title="Excluir Permanentemente">
                                                            <i class="ph ph-trash text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @else
                                                <a href="{{ route('materiais.show', $material) }}"
                                                    class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                                                    <i class="ph ph-eye text-lg"></i>
                                                </a>
                                                @can('edit_materiais')
                                                    <a href="{{ route('materiais.edit', $material) }}"
                                                        class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">
                                                        <i class="ph ph-pencil text-lg"></i>
                                                    </a>
                                                @endcan
                                                <a href="{{ route('materiais.download', $material) }}"
                                                    class="bg-green-100 text-green-600 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors">
                                                    <i class="ph ph-download text-lg"></i>
                                                </a>
                                                @can('delete_materiais')
                                                    <form action="{{ route('materiais.destroy', $material) }}"
                                                        method="POST" class="delete-form-{{ $material->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="deleteForm = document.querySelector('.delete-form-{{ $material->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-material' }));"
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
                    <x-pagination :paginator="$materiais" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-file-dashed text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum material encontrado</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontrados materiais com o termo "{{ request('search') }}".
                            @else
                                Não há materiais cadastrados no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <x-delete-modal name="delete-material" title="Confirmar Exclusão do Material"
        message="Tem certeza que deseja excluir este material? Esta ação não pode ser desfeita." />

    <!-- Restore Modal -->
    <x-restore-modal name="restore-material" title="Confirmar Restauração do Material"
        message="Tem certeza que deseja restaurar este material? O material será restaurado." />

    <!-- Force Delete Modal -->
    <x-force-delete-modal name="force-delete-material" title="Confirmar Exclusão Permanente do Material"
        message="Tem certeza que deseja excluir permanentemente este material? Esta ação é irreversível e não pode ser desfeita." />

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
