<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissões') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Permissões" description="Gerencie todas as permissões do sistema" />

                <!-- Search Bar -->
                <x-search-bar placeholder="Pesquisar permissões..." />

                <!-- Table -->
                @if ($permissions->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            #
                        </x-table-header>
                        <x-table-header column="name" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Nome
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Descrição
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
                        @foreach ($permissions as $permission)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $permission->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-lock-key text-blue-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $permission->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $permission->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-800">
                                        {{ $permission->guard_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $permission->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('permissions.show', $permission) }}"
                                        class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors text-center flex items-center justify-center">
                                        <i class="ph ph-eye text-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </x-slot>
                    </x-table>

                    <!-- Pagination -->
                    <x-pagination :paginator="$permissions" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-lock-key text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhuma permissão encontrada</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontradas permissões com o termo "{{ request('search') }}".
                            @else
                                Não há permissões cadastradas no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
