<nav class="bg-[#4A83FF]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <i class="ph ph-hand-waving text-[#4A83FF] text-2xl"></i>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('home') }}" 
                   class="text-white hover:bg-[#3B6ED8] px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-[#3B6ED8]' : '' }}">
                    INÍCIO
                </a>
                <a href="{{ route('public.sinais') }}" 
                   class="text-white hover:bg-[#3B6ED8] px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.sinais') ? 'bg-[#3B6ED8]' : '' }}">
                    SINAIS
                </a>
                <a href="{{ route('public.catalogo') }}" 
                   class="text-white hover:bg-[#3B6ED8] px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.catalogo') ? 'bg-[#3B6ED8]' : '' }}">
                    CATÁLOGO
                </a>
                <a href="{{ route('public.categorias') }}" 
                   class="text-white hover:bg-[#3B6ED8] px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.categorias') ? 'bg-[#3B6ED8]' : '' }}">
                    CATEGORIAS
                </a>
                <a href="{{ route('public.about') }}" 
                   class="text-white hover:bg-[#3B6ED8] px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.about') ? 'bg-[#3B6ED8]' : '' }}">
                    SOBRE
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" 
                        x-data="" 
                        @click="$dispatch('toggle-mobile-menu')"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-100 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <i class="ph ph-list text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-data="{ open: false }" 
         @toggle-mobile-menu.window="open = !open"
         x-show="open" 
         x-transition
         class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-blue-700">
            <a href="{{ route('home') }}" 
               class="text-white hover:text-blue-100 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-800' : '' }}">
                INÍCIO
            </a>
            <a href="{{ route('public.sinais') }}" 
               class="text-white hover:text-blue-100 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.sinais') ? 'bg-blue-800' : '' }}">
                SINAIS
            </a>
            <a href="{{ route('public.catalogo') }}" 
               class="text-white hover:text-blue-100 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.catalogo') ? 'bg-blue-800' : '' }}">
                CATÁLOGO
            </a>
            <a href="{{ route('public.categorias') }}" 
               class="text-white hover:text-blue-100 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.categorias') ? 'bg-blue-800' : '' }}">
                CATEGORIAS
            </a>
            <a href="{{ route('public.about') }}" 
               class="text-white hover:text-blue-100 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.about') ? 'bg-blue-800' : '' }}">
                SOBRE
            </a>
        </div>
    </div>
</nav>
