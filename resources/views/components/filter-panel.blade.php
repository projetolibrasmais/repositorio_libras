@props(['users' => [], 'events' => [], 'logNames' => []])

<div x-data="{ open: false }" class="mb-4">
    <!-- Filter Toggle Button -->
    <button @click="open = !open" type="button"
        class="inline-flex items-center px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
        <i class="ph ph-funnel mr-2"></i>
        Filtros
        <span x-show="open" class="ml-2">
            <i class="ph ph-caret-up"></i>
        </span>
        <span x-show="!open" class="ml-2">
            <i class="ph ph-caret-down"></i>
        </span>
        @if(request()->hasAny(['user_id', 'event', 'log_name', 'date_from', 'date_to']))
            <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-brand-600 rounded-full">
                {{ collect(['user_id', 'event', 'log_name', 'date_from', 'date_to'])->filter(fn($key) => request()->filled($key))->count() }}
            </span>
        @endif
    </button>

    <!-- Filter Panel -->
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="mt-3 bg-gray-50 border border-gray-200 rounded-lg p-4"
        style="display: none;">
        
        <form method="GET" class="space-y-4">
            <!-- Preserve search parameter -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- User Filter -->
                @if(count($users) > 0)
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="ph ph-user mr-1"></i>
                            Usuário
                        </label>
                        <select name="user_id" id="user_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
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
                        Data Início
                    </label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="ph ph-calendar mr-1"></i>
                        Data Fim
                    </label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-200">
                <a href="{{ url()->current() }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
                    <i class="ph ph-x mr-2"></i>
                    Limpar Filtros
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                    <i class="ph ph-funnel mr-2"></i>
                    Aplicar Filtros
                </button>
            </div>
        </form>
    </div>
</div>