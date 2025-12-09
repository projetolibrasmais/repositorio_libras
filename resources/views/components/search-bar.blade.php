@props(['action' => null, 'placeholder' => 'Pesquisar...'])

<div class="mb-4">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
            </div>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="{{ $placeholder }}"
                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
            />
        </div>
        
        <div class="flex gap-2">
            <button 
                type="submit"
                class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
            >
                <i class="ph ph-magnifying-glass mr-2"></i>
                Buscar
            </button>
            
            @if(request('search'))
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
    </form>
</div>
