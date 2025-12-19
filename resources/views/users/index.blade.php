<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Usuários" description="Gerencie todos os usuários do sistema">
                    <x-slot name="action">
                        @can('create_users')
                            <a href="{{ route('users.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="ph ph-plus mr-2"></i>
                                Novo Usuário
                            </a>
                        @endcan
                    </x-slot>
                </x-page-header>

                <div x-data="{ filtersOpen: false }" class="mb-4">
                    <!-- Search and Filter Bar -->
                    <form method="GET" class="space-y-3">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Search Input -->
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Pesquisar usuários..."
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                />
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2 sm:justify-end">
                                <!-- Filter Button -->
                                <button 
                                    @click.prevent="filtersOpen = !filtersOpen"
                                    type="button"
                                    class="inline-flex items-center px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors relative"
                                >
                                    <i class="ph ph-funnel mr-2"></i>
                                    Filtros
                                    <span x-show="filtersOpen" class="ml-2">
                                        <i class="ph ph-caret-up"></i>
                                    </span>
                                    <span x-show="!filtersOpen" class="ml-2">
                                        <i class="ph ph-caret-down"></i>
                                    </span>
                                    @if(request()->hasAny(['role', 'date_from', 'date_to']))
                                        <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-blue-600 rounded-full">
                                            {{ collect(['role', 'date_from', 'date_to'])->filter(fn($key) => request()->filled($key))->count() }}
                                        </span>
                                    @endif
                                </button>

                                <!-- Search Button -->
                                <button 
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                                >
                                    <i class="ph ph-magnifying-glass mr-2"></i>
                                    Buscar
                                </button>
                                
                                <!-- Clear Button -->
                                @if(request('search') || request()->hasAny(['role', 'date_from', 'date_to']))
                                    <a 
                                        href="{{ url()->current() }}"
                                        class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors"
                                    >
                                        <i class="ph ph-x mr-2"></i>
                                        Limpar
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Filter Panel -->
                        <div x-show="filtersOpen" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="bg-gray-50 border border-gray-200 rounded-lg p-4"
                            style="display: none;">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Role Filter -->
                                @if(count($roles) > 0)
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="ph ph-shield-checkered mr-1"></i>
                                            Função
                                        </label>
                                        <select name="role" id="role"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="">Todas as funções</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- Date From -->
                                <div>
                                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="ph ph-calendar mr-1"></i>
                                        Data Início
                                    </label>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>

                                <!-- Date To -->
                                <div>
                                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="ph ph-calendar mr-1"></i>
                                        Data Fim
                                    </label>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                @if ($users->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            #
                        </x-table-header>
                        <x-table-header column="name" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Nome
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Função
                        </x-table-header>
                        <x-table-header column="email" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Email
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-user text-purple-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $user->email }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('users.show', $user) }}"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                                                <i class="ph ph-eye text-lg"></i>
                                            </a>
                                            @can('edit_users')
                                                <a href="{{ route('users.edit', $user) }}"
                                                    class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">
                                                    <i class="ph ph-pencil text-lg"></i>
                                                </a>
                                            @endcan
                                            @can('delete_users')
                                                @if ($user->id !== 1)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                        class="delete-form-{{ $user->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="deleteForm = document.querySelector('.delete-form-{{ $user->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-user' }));"
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
                    <x-pagination :paginator="$users" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-shield-checkered text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum usuário encontrado</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontrados usuários com o termo "{{ request('search') }}".
                            @else
                                Não há usuários cadastrados no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <x-delete-modal name="delete-user" title="Confirmar Exclusão de Usuário"
        message="Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita." />

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
