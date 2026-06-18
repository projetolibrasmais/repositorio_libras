<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorias') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Categorias" description="Gerencie todas as categorias do sistema">
                    <x-slot name="action">
                        @can('create_categorias')
                            <a href="{{ route('categorias.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                                <i class="ph ph-plus mr-2"></i>
                                Nova Categoria
                            </a>
                        @endcan
                    </x-slot>
                </x-page-header>

                <!-- Search Bar -->
                <x-search-bar placeholder="Pesquisar categorias..." :filterKeys="['date_from', 'date_to', 'show_deleted']">
                    <x-slot name="filters">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Date From -->
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="ph ph-calendar mr-1"></i>
                                    Criado de
                                </label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
                            </div>

                            <!-- Date To -->
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="ph ph-calendar mr-1"></i>
                                    Criado até
                                </label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
                            </div>

                            <!-- Show Deleted Filter -->
                            <div>
                                <label for="show_deleted" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="ph ph-trash mr-1"></i>
                                    Categorias Deletadas
                                </label>
                                <select name="show_deleted" id="show_deleted"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
                                    <option value="" {{ request('show_deleted') == '' ? 'selected' : '' }}>Apenas
                                        Ativas</option>
                                    <option value="with" {{ request('show_deleted') == 'with' ? 'selected' : '' }}>
                                        Todas</option>
                                    <option value="only" {{ request('show_deleted') == 'only' ? 'selected' : '' }}>
                                        Apenas Deletadas</option>
                                </select>
                            </div>
                        </div>
                    </x-slot>
                </x-search-bar>

                <!-- Table -->
                @if ($categorias->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            #
                        </x-table-header>
                        <x-table-header column="nome" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Nome
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                            @foreach ($categorias as $categoria)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $categoria->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-bookmark text-purple-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $categoria->nome }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $categoria->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            @if($categoria->trashed())
                                                <!-- Restore Button -->
                                                @can('restore_categorias')
                                                    <form action="{{ route('categorias.restore', $categoria->id) }}" method="POST"
                                                        class="restore-form-{{ $categoria->id }}">
                                                        @csrf
                                                        <button type="button"
                                                            onclick="restoreForm = document.querySelector('.restore-form-{{ $categoria->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'restore-categoria' }));"
                                                            class="bg-green-100 text-green-600 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors"
                                                            title="Restaurar">
                                                            <i class="ph ph-arrow-counter-clockwise text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                                
                                                <!-- Force Delete Button -->
                                                @can('force_delete_categorias')
                                                    <form action="{{ route('categorias.force-delete', $categoria->id) }}" method="POST"
                                                        class="force-delete-form-{{ $categoria->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="forceDeleteForm = document.querySelector('.force-delete-form-{{ $categoria->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'force-delete-categoria' }));"
                                                            class="bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors"
                                                            title="Excluir Permanentemente">
                                                            <i class="ph ph-trash text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @else
                                                <a href="{{ route('categorias.show', $categoria) }}"
                                                    class="bg-brand-100 text-brand-600 px-3 py-1 rounded-lg hover:bg-brand-100 transition-colors">
                                                    <i class="ph ph-eye text-lg"></i>
                                                </a>
                                                @can('edit_categorias')
                                                    <a href="{{ route('categorias.edit', $categoria) }}"
                                                        class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">
                                                        <i class="ph ph-pencil text-lg"></i>
                                                    </a>
                                                @endcan
                                                @can('delete_categorias')
                                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                                        class="delete-form-{{ $categoria->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="deleteForm = document.querySelector('.delete-form-{{ $categoria->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-categoria' }));"
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
                    <x-pagination :paginator="$categorias" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-shield-checkered text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhuma categoria encontrada</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontradas categorias com o termo "{{ request('search') }}".
                            @else
                                Não há categorias cadastradas no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <x-delete-modal name="delete-categoria" title="Confirmar Exclusão da Categoria"
        message="Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita." />

    <!-- Restore Modal -->
    <x-restore-modal name="restore-categoria" title="Confirmar Restauração da Categoria"
        message="Tem certeza que deseja restaurar esta categoria? A categoria será restaurada." />

    <!-- Force Delete Modal -->
    <x-force-delete-modal name="force-delete-categoria" title="Confirmar Exclusão Permanente da Categoria"
        message="Tem certeza que deseja excluir esta categoria permanentemente? Esta ação não pode ser desfeita!" />

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
