@props(['placeholder' => 'O que você procura?'])

<div x-data="globalSearch()" x-init="init()" class="relative w-full max-w-2xl mx-auto">
    <div class="relative">
        <input 
            type="text" 
            x-model="query"
            @input.debounce.300ms="search()"
            @focus="showResults = true"
            @click.away="showResults = false"
            placeholder="{{ $placeholder }}"
            class="w-full p-4 text-lg text-gray-600 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-[#4A83FF] focus:border-[#4A83FF]"
            autocomplete="on"
        />
        <button 
            type="submit"
            @click="performSearch()"
            class="absolute inset-y-0 right-0 pr-4 flex items-center">
            <i class="ph ph-magnifying-glass text-2xl hover:text-[#4A83FF] cursor-pointer text-gray-600"></i>
        </button>
    </div>

    <!-- Autocomplete Results -->
    <div x-show="showResults && results.length > 0" 
         x-transition
         class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow border border-gray-200 max-h-96 overflow-y-auto">
        <template x-for="(result, index) in results" :key="index">
            <a :href="result.url" 
               class="block px-4 py-3 hover:bg-blue-50 transition-colors border-b border-gray-100 last:border-b-0">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 mt-1">
                        <i :class="result.icon" class="text-[#4A83FF] text-xl"></i>
                    </div>
                    <div class="w-full text-start">
                        <p class="text-sm font-semibold text-gray-900" x-text="result.title"></p>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2" x-text="result.description"></p>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full"
                              :class="result.type === 'sinal' ? 'bg-blue-100 text-[#4A83FF]' : 'bg-gray-100 text-gray-800'"
                              x-text="result.type_label"></span>
                    </div>
                </div>
            </a>
        </template>
    </div>

    <!-- Loading State -->
    <div x-show="loading" 
         x-transition
         class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow border border-gray-200 p-4 text-center">
        <i class="ph ph-circle-notch animate-spin text-[#4A83FF] text-2xl"></i>
        <p class="text-sm text-gray-600 mt-2">Buscando...</p>
    </div>

    <!-- No Results -->
    <div x-show="showResults && !loading && query.length >= 2 && results.length === 0" 
         x-transition
         class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow border border-gray-200 p-6 text-center">
        <i class="ph ph-magnifying-glass text-gray-400 text-4xl"></i>
        <p class="text-sm text-gray-600 mt-2">Nenhum resultado encontrado</p>
    </div>
</div>

<script>
function globalSearch() {
    return {
        query: '',
        results: [],
        loading: false,
        showResults: false,

        init() {
            // Initialize component
        },

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }

            this.loading = true;

            try {
                const response = await fetch(`{{ route('search.autocomplete') }}?query=${encodeURIComponent(this.query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                this.results = data.results || [];
            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
            } finally {
                this.loading = false;
            }
        },

        performSearch() {
            if (this.query.length >= 2) {
                window.location.href = `{{ route('search.results') }}?query=${encodeURIComponent(this.query)}`;
            }
        }
    }
}
</script>
