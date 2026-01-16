<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Funções') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Funções" description="Gerencie todas as funções do sistema">
                    <x-slot name="action">
                        @can('create_roles')
                            <a href="{{ route('roles.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="ph ph-plus mr-2"></i>
                                Nova Função
                            </a>
                        @endcan
                    </x-slot>
                </x-page-header>

                <!-- Search Bar -->
                <x-search-bar placeholder="Pesquisar funções..." />

                <!-- Table -->
                @if ($roles->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            #
                        </x-table-header>
                        <x-table-header column="name" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Nome
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Permissões
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Guard
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                        @foreach ($roles as $role)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $role->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-shield-checkered text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $role->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $role->permissions()->count() }} permissões
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-800">
                                        {{ $role->guard_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $role->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('roles.show', $role) }}"
                                            class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                                            <i class="ph ph-eye text-lg"></i>
                                        </a>
                                        @can('edit_roles')
                                            <a href="{{ route('roles.edit', $role) }}"
                                                class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">
                                                <i class="ph ph-pencil text-lg"></i>
                                            </a>
                                        @endcan
                                        @can('delete_roles')
                                            @if ($role->id !== 1)
                                                <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                                    class="delete-form-{{ $role->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="deleteForm = document.querySelector('.delete-form-{{ $role->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-role' }));"
                                                        class="bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors">
                                                        <i class="ph ph-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </x-slot>
                    </x-table>

                    <!-- Pagination -->
                    <x-pagination :paginator="$roles" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-shield-checkered text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhuma função encontrada</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontradas funções com o termo "{{ request('search') }}".
                            @else
                                Não há funções cadastradas no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <x-delete-modal name="delete-role" title="Confirmar Exclusão de Função"
        message="Tem certeza que deseja excluir esta função? Todos os usuários associados a esta função perderão suas permissões. Esta ação não pode ser desfeita." />

    @push('scripts')
        <script>
            let deleteForm = null;

            function confirmDelete() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            }
        </script>
    @endpush
</x-app-layout>
