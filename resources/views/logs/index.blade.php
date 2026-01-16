<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Logs') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Logs" description="Verifique o registro de atividades do sistema" />

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
                                    placeholder="Pesquisar logs..."
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
                                    @if(request()->hasAny(['user_id', 'event', 'log_name', 'date_from', 'date_to']))
                                        <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-blue-600 rounded-full">
                                            {{ collect(['user_id', 'event', 'log_name', 'date_from', 'date_to'])->filter(fn($key) => request()->filled($key))->count() }}
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
                                @if(request('search') || request()->hasAny(['user_id', 'event', 'log_name', 'date_from', 'date_to']))
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
                                <!-- User Filter -->
                                @if(count($users) > 0)
                                    <div>
                                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="ph ph-user mr-1"></i>
                                            Usuário
                                        </label>
                                        <select name="user_id" id="user_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="">Todos os usuários</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- Event Filter -->
                                @if(count($events) > 0)
                                    <div>
                                        <label for="event" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="ph ph-lightning mr-1"></i>
                                            Evento
                                        </label>
                                        <select name="event" id="event"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="">Todos os eventos</option>
                                            @foreach($events as $event)
                                                <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                                                    {{ ucfirst($event) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- Log Name Filter -->
                                @if(count($logNames) > 0)
                                    <div>
                                        <label for="log_name" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="ph ph-tag mr-1"></i>
                                            Nome do Log
                                        </label>
                                        <select name="log_name" id="log_name"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="">Todos os tipos</option>
                                            @foreach($logNames as $logName)
                                                <option value="{{ $logName }}" {{ request('log_name') == $logName ? 'selected' : '' }}>
                                                    {{ $logName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

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
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                @if ($logs->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header :sortable="false">
                            Nome
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Descrição
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Evento
                        </x-table-header>
                        <x-table-header column="subject_id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            ID do Objeto
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Usuário
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                            @foreach ($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-clock-countdown text-orange-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $log->log_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <span
                                            class="inline-flex items-center rounded-md text-xs font-medium">
                                            {{ $log->description }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex uppercase text-xs leading-5 font-semibold rounded-md 
                                            {{ $log->event == 'created' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $log->event == 'updated' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $log->event == 'restored' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $log->event == 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $log->event == 'force_deleted' ? 'bg-gray-800 text-white' : '' }}">
                                            {{ $log->event }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->subject_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->user->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('logs.show', $log) }}"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                                                <i class="ph ph-eye text-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table>

                    <!-- Pagination -->
                    <x-pagination :paginator="$logs" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-md mb-4">
                            <i class="ph ph-shield-checkered text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum log encontrado</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontrados logs com o termo "{{ request('search') }}".
                            @else
                                Não há logs cadastrados no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
