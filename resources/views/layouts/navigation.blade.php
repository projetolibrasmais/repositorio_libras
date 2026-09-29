<nav x-data="{ open: false }" class="admin-navbar sticky top-0 z-30 bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full px-2">
        <div class="flex justify-between h-[4.4rem]">
            <!-- Navegação mobile -->
            <div class="md:hidden flex items-center gap-2">
                <button type="button" @click="$dispatch('toggle-sidebar')"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-brand-800 hover:bg-brand-50 focus:outline-none focus:ring-2 focus:ring-logo-sky"
                    aria-label="Abrir menu de administração">
                    <i class="ph ph-list text-2xl" aria-hidden="true"></i>
                    <span class="text-sm font-semibold">Menu</span>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center" aria-label="Ir para o painel">
                    <img src="{{ asset('images/logo.svg') }}" alt="Libras+" class="h-11 w-11 object-contain">
                </a>
            </div>

            <div class="hidden md:flex items-center gap-3 px-4">
                <span class="w-9 h-9 rounded-full bg-brand-100 flex items-center justify-center">
                    <i class="ph ph-gear-six text-brand-600 text-xl"></i>
                </span>
                <div>
                    <p class="text-sm font-semibold text-brand-800 leading-tight">Área administrativa</p>
                    <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-brand-600">Visualizar site</a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex sm:items-center sm:ms-6 pe-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 border border-brand-100 text-sm leading-4 font-medium rounded-lg text-brand-800 bg-brand-50 hover:bg-brand-100 focus:outline-none focus:ring-2 focus:ring-logo-sky transition ease-in-out duration-150">
                            <span class="w-7 h-7 rounded-full bg-brand-600 text-white flex items-center justify-center">
                                <i class="ph ph-user"></i>
                            </span>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Conta no mobile -->
            <div class="flex items-center md:hidden pe-1">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-600 text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-logo-sky focus:ring-offset-2"
                    :aria-expanded="open.toString()" aria-controls="mobile-account-menu" aria-label="Abrir opções da conta">
                    <i class="ph text-xl" :class="open ? 'ph-x' : 'ph-user'" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-account-menu" x-show="open" x-transition class="md:hidden bg-white shadow-lg" style="display: none;">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('home')">
                    <i class="ph ph-arrow-square-out mr-2"></i>
                    {{ __('Visualizar site') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
