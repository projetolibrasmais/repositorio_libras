@props(['action' => null, 'placeholder' => 'Pesquisar...', 'filterKeys' => []])

<div x-data="{ filtersOpen: false }" class="mb-4">
    <form method="GET" class="space-y-3">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="{{ $placeholder }}"
                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm"
                />
            </div>
            
            <div class="flex gap-2">
                @if(isset($filters))
                    <!-- Filter Button -->
                    <button @click.prevent="filtersOpen = !filtersOpen" type="button"
                        class="inline-flex items-center px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors relative">
                        <i class="ph ph-funnel mr-2"></i>
                        Filtros
                        <span x-show="filtersOpen" class="ml-2">
                            <i class="ph ph-caret-up"></i>
                        </span>
                        <span x-show="!filtersOpen" class="ml-2">
                            <i class="ph ph-caret-down"></i>
                        </span>
                        @if (count($filterKeys) > 0 && request()->hasAny($filterKeys))
                            <span
                                class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-brand-600 rounded-full">
                                {{ collect($filterKeys)->filter(fn($key) => request()->filled($key))->count() }}
                            </span>
                        @endif
                    </button>
                @endif

                <button 
                    type="submit"
                    class="inline-flex items-center px-4 py-2.5 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors"
                >
                    <i class="ph ph-magnifying-glass mr-2"></i>
                    Buscar
                </button>
                
                @if(request('search') || (count($filterKeys) > 0 && request()->hasAny($filterKeys)))
                    <a 
                        href="{{ url()->current() }}"
                        class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors"
                    >
                        <i class="ph ph-x mr-2"></i>
                        Limpar
                    </a>
                @endif
            </div>
            
            @if($action)
                <div class="flex-shrink-0">
                    {{ $action }}
                </div>
            @endif
        </div>

        @if(isset($filters))
            <!-- Filter Panel -->
            <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="bg-gray-50 border border-gray-200 rounded-lg p-4" style="display: none;">
                {{ $filters }}
            </div>
        @endif
    </form>
</div>
