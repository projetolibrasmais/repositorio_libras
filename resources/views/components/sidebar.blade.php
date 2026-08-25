<div x-data="{
    open: window.innerWidth >= 1024,
    collapsed: false,
    toggleCollapsed() {
        this.collapsed = !this.collapsed;
        window.dispatchEvent(new CustomEvent('sidebar-toggled', { detail: { collapsed: this.collapsed } }));
    }
}" x-init="window.dispatchEvent(new CustomEvent('sidebar-toggled', { detail: { collapsed: collapsed } }))"
    @resize.window="if (window.innerWidth >= 1024) { open = true; } else { collapsed = false; window.dispatchEvent(new CustomEvent('sidebar-toggled', { detail: { collapsed: false } })); }"
    @toggle-sidebar.window="open = !open" class="relative">

    <!-- Overlay para mobile -->
    <div x-show="open && window.innerWidth < 1024" @click="open = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden" style="display: none;">
    </div>

    <!-- Sidebar -->
    <aside
        :class="{
            'translate-x-0': open,
            '-translate-x-full lg:translate-x-0': !open,
            'w-[280px]': !collapsed || window.innerWidth < 1024,
            'lg:w-20': collapsed && window.innerWidth >= 1024
        }"
        class="fixed top-0 left-0 h-full bg-white border-r border-slate-200 shadow-lg lg:shadow-sm transition-all duration-300 ease-in-out z-50 overflow-y-auto flex-shrink-0">
        <div class="flex flex-col h-full">
            <!-- Header com botão de toggle -->
            <div class="flex items-center p-4 pb-3 border-b border-slate-200"
                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : 'justify-between'">

                <!-- Logo e título quando expandido -->
                <div x-show="!collapsed || window.innerWidth < 1024"
                    x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-simple.png') }}" alt="Logo" class="h-10 w-10">
                    <p class="font-sans antialiased text-base text-current font-semibold text-brand-800">
                        Repositório Libras+
                    </p>
                </div>

                <!-- Logo centralizada quando colapsado -->
                <div x-show="collapsed && window.innerWidth >= 1024"
                    x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" class="flex items-center justify-center cursor-pointer"
                    @click="toggleCollapsed()">
                    <img src="{{ asset('images/logo-simple.png') }}" alt="Logo" class="h-10 w-10">
                </div>

                <!-- Toggle button desktop -->
                <button x-show="!collapsed || window.innerWidth < 1024" @click="toggleCollapsed()"
                    class="hidden lg:block p-2 rounded-md text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg x-show="!collapsed" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="collapsed" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Close button mobile -->
                <button @click="open = false" class="lg:hidden p-2 rounded-md text-slate-600 hover:bg-slate-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu items -->
            <div class="flex-1 p-3">
                <ul class="flex flex-col gap-0.5">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                            :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                            class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                            <span class="grid place-items-center shrink-0"
                                :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                <i class="ph ph-house text-xl"></i>
                            </span>
                            <span x-show="!collapsed || window.innerWidth < 1024"
                                x-transition:enter="transition ease-in-out duration-200"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                class="flex-1">Dashboard</span>
                        </a>
                    </li>

                    @can(['view_categorias', 'view_sinais'])
                        <small x-show="!collapsed || window.innerWidth < 1024"
                            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" class="text-xs font-bold text-gray-500">CONTEÚDO</small>
                        <hr class="mb-3">
                    @endcan

                    @can('view_sinais')
                        <!-- Sinais -->
                        <li>
                            <a href="{{ route('sinais.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('sinais.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-hand-waving text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Sinais</span>
                            </a>
                        </li>
                    @endcan

                    @can('view_categorias')
                        <!-- Categories -->
                        <li>
                            <a href="{{ route('categorias.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('categorias.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-bookmarks text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Categorias</span>
                            </a>
                        </li>
                    @endcan

                    @can('view_materiais')
                        <!-- Materials -->
                        <li>
                            <a href="{{ route('materiais.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('materiais.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-file text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Materiais</span>
                            </a>
                        </li>
                    @endcan

                    @can(['view_permissions', 'view_roles'])
                        <small x-show="!collapsed || window.innerWidth < 1024"
                            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            class="text-xs font-bold text-gray-500">PERMISSÕES</small>
                        <hr class="mb-3">
                    @endcan

                    @can('view_roles')
                        <!-- Roles -->
                        <li>
                            <a href="{{ route('roles.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-shield-checkered text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Funções</span>
                            </a>
                        </li>
                    @endcan

                    @can('view_permissions')
                        <!-- Permissions -->
                        <li>
                            <a href="{{ route('permissions.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('permissions.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-shield-check text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Permissões</span>
                            </a>
                        </li>
                    @endcan

                    @can(['view_logs', 'view_users'])
                        <small x-show="!collapsed || window.innerWidth < 1024"
                            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" class="text-xs font-bold text-gray-500">SISTEMA</small>
                        <hr class="mb-3">
                    @endcan

                    @can('view_users')
                        <!-- Users -->
                        <li>
                            <a href="{{ route('users.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-users text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Usuários</span>
                            </a>
                        </li>
                    @endcan

                    @can('view_logs')
                        <!-- Logs -->
                        <li>
                            <a href="{{ route('logs.index') }}"
                                :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                                class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('logs.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <i class="ph ph-clock-counter-clockwise text-xl"></i>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    class="flex-1">Logs</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Ajuda -->
                    <li>
                        <a href="{{ route('ajuda.index') }}"
                            :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : ''"
                            class="flex items-center py-2.5 px-3 rounded-md transition-all duration-200 {{ request()->routeIs('ajuda.*') ? 'bg-brand-50 text-brand-600 font-medium' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-100' }} group">
                            <span class="grid place-items-center shrink-0"
                                :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                <i class="ph ph-question text-xl"></i>
                            </span>
                            <span x-show="!collapsed || window.innerWidth < 1024"
                                x-transition:enter="transition ease-in-out duration-200"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                class="flex-1">Ajuda</span>
                        </a>
                    </li>

                    <!-- More (com submenu) -->
                    {{-- <li x-data="{ submenuOpen: false }">
                        <button @click="submenuOpen = !submenuOpen"
                            :class="collapsed && window.innerWidth >= 1024 ? 'justify-center' : 'justify-between'"
                            class="w-full flex items-center py-2.5 px-3 rounded-md transition-all duration-200 text-slate-600 hover:text-slate-800 hover:bg-slate-100">
                            <span class="flex items-center">
                                <span class="grid place-items-center shrink-0"
                                    :class="!collapsed || window.innerWidth < 1024 ? 'me-3' : ''">
                                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor"
                                        class="h-5 w-5">
                                        <path
                                            d="M7 12.5C7.27614 12.5 7.5 12.2761 7.5 12C7.5 11.7239 7.27614 11.5 7 11.5C6.72386 11.5 6.5 11.7239 6.5 12C6.5 12.2761 6.72386 12.5 7 12.5Z"
                                            fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M12 12.5C12.2761 12.5 12.5 12.2761 12.5 12C12.5 11.7239 12.2761 11.5 12 11.5C11.7239 11.5 11.5 11.7239 11.5 12C11.5 12.2761 11.7239 12.5 12 12.5Z"
                                            fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M17 12.5C17.2761 12.5 17.5 12.2761 17.5 12C17.5 11.7239 17.2761 11.5 17 11.5C16.7239 11.5 16.5 11.7239 16.5 12C16.5 12.2761 16.7239 12.5 17 12.5Z"
                                            fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                    </svg>
                                </span>
                                <span x-show="!collapsed || window.innerWidth < 1024"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100">More</span>
                            </span>
                            <span x-show="(!collapsed || window.innerWidth < 1024) && submenuOpen"
                                class="grid place-items-center">
                                <svg class="h-4 w-4 transform transition-transform duration-200"
                                    :class="submenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>

                        <!-- Submenu -->
                        <ul x-show="submenuOpen && (!collapsed || window.innerWidth < 1024)"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1" class="mt-1 ml-8 space-y-1"
                            style="display: none;">
                            <li>
                                <a href="#"
                                    class="block py-2 px-3 text-sm rounded-md text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                                    Inbox
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block py-2 px-3 text-sm rounded-md text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                                    Trash
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block py-2 px-3 text-sm rounded-md text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                                    Settings
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
        </div>
    </aside>

    <!-- Botão para abrir sidebar no mobile -->
    <button @click="open = true" x-show="!open"
        class="fixed bottom-4 left-4 lg:hidden z-30 p-3 rounded-full bg-brand-600 text-white shadow-lg hover:bg-brand-700 transition-colors"
        style="display: none;">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>
