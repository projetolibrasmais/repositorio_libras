<nav class="bg-brand-700 border-b-4 border-logo-green">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center relative bg-white rounded-full h-16 p-1">
                    <img src="{{ asset('images/logo-simple.png') }}" alt="Logo" class="h-full w-auto rounded-full">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('home') }}" 
                   class="text-white hover:bg-brand-800 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-brand-800' : '' }}">
                    {{ __('INÍCIO') }}
                </a>
                <a href="{{ route('public.sinais') }}" 
                   class="text-white hover:bg-brand-800 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.sinais') ? 'bg-brand-800' : '' }}">
                    {{ __('SINAIS') }}
                </a>
                <a href="{{ route('public.catalogo') }}" 
                   class="text-white hover:bg-brand-800 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.catalogo') ? 'bg-brand-800' : '' }}">
                    {{ __('CATÁLOGO') }}
                </a>
                <a href="{{ route('public.categorias') }}" 
                   class="text-white hover:bg-brand-800 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.categorias') ? 'bg-brand-800' : '' }}">
                    {{ __('CATEGORIAS') }}
                </a>

                <a href="{{ route('public.faq') }}" 
                   class="text-white hover:bg-brand-800 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.faq') ? 'bg-brand-800' : '' }}">
                    {{ __('FAQ') }}
                </a>
                
                <a href="{{ route('public.about') }}" 
                   class="text-white hover:bg-brand-800 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('public.about') ? 'bg-brand-800' : '' }}">
                    {{ __('SOBRE') }}
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" 
                        x-data="" 
                        @click="$dispatch('toggle-mobile-menu')"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-brand-100 hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
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
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-brand-700">
            <a href="{{ route('home') }}" 
               class="text-white hover:text-brand-100 hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-brand-800' : '' }}">
                {{ __('INÍCIO') }}
            </a>
            <a href="{{ route('public.sinais') }}" 
               class="text-white hover:text-brand-100 hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.sinais') ? 'bg-brand-800' : '' }}">
                {{ __('SINAIS') }}
            </a>
            <a href="{{ route('public.catalogo') }}" 
               class="text-white hover:text-brand-100 hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.catalogo') ? 'bg-brand-800' : '' }}">
                {{ __('CATÁLOGO') }}
            </a>
            <a href="{{ route('public.categorias') }}" 
               class="text-white hover:text-brand-100 hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.categorias') ? 'bg-brand-800' : '' }}">
                {{ __('CATEGORIAS') }}
            </a>
            <a href="{{ route('public.about') }}" 
               class="text-white hover:text-brand-100 hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.about') ? 'bg-brand-800' : '' }}">
                {{ __('SOBRE') }}
            </a>
        </div>
    </div>
</nav>
