@props(['placeholder' => 'O que você procura?', 'category' => null])

<div x-data="globalSearch()" @pageshow.window="if ($event.persisted) resetToUrl()" class="relative w-full max-w-2xl mx-auto">
    <div class="relative">
        <input
            type="text"
            x-model="query"
            @input.debounce.300ms="search()"
            @keyup.enter="performSearch()"
            @focus="showResults = true"
            @click.away="showResults = false"
            placeholder="{{ $placeholder }}"
            class="w-full p-4 pr-20 text-lg text-gray-600 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-logo-sky focus:border-logo-sky"
            autocomplete="on"
        />

        <div class="absolute inset-y-0 right-0 flex items-center gap-1 pr-3">
            <!-- Botão Filtro -->
            <button type="button" @click="filtersOpen = true"
                class="relative p-2 text-gray-500 hover:text-brand-600 transition-colors" title="Filtros">
                <i class="ph ph-funnel text-xl"></i>
                <span x-show="activeFilterCount > 0" x-cloak x-text="activeFilterCount"
                    class="absolute -top-1 -right-1 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-brand-600 rounded-full"></span>
            </button>

            <button type="button" @click="performSearch()">
                <i class="ph ph-magnifying-glass text-2xl hover:text-brand-600 cursor-pointer text-gray-600"></i>
            </button>
        </div>
    </div>

    <!-- Resumo dos filtros ativos -->
    <div x-show="activeFilterCount > 0" x-cloak style="display: none;" class="flex flex-wrap items-center justify-center gap-2 mt-3">
        <span class="text-xs font-semibold text-gray-500">Filtros ativos:</span>
        <template x-for="field in textFields" :key="`active-${field.key}`">
            <button x-show="filters[field.key]" type="button" @click="removeFilter(field.key)"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-brand-100 text-brand-700 border border-logo-sky text-xs font-medium hover:bg-brand-50"
                :title="`Remover filtro ${field.label}`">
                <span x-text="`${field.label}: ${filters[field.key]}`"></span>
                <i class="ph ph-x" aria-hidden="true"></i>
            </button>
        </template>
        <button x-show="filters.categorias.nome" type="button" @click="removeFilter('categorias.nome')"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-brand-100 text-brand-700 border border-logo-sky text-xs font-medium hover:bg-brand-50"
            title="Remover filtro de categoria">
            <span x-text="`Categoria: ${filters.categorias.nome}`"></span>
            <i class="ph ph-x" aria-hidden="true"></i>
        </button>
        <button type="button" @click="clearFilters()" class="text-xs font-medium text-gray-600 underline hover:text-brand-700">
            Limpar todos
        </button>
    </div>

    <!-- Autocomplete Results -->
    <div x-show="showResults && !loading && results.length > 0"
         x-cloak
         x-transition
         class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow border border-gray-200 max-h-96 overflow-y-auto">
        <template x-for="(result, index) in results" :key="index">
            <a :href="result.url"
               class="block px-4 py-3 hover:bg-brand-50 transition-colors border-b border-gray-100 last:border-b-0">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 mt-1">
                        <i :class="result.icon" class="text-brand-600 text-xl"></i>
                    </div>
                    <div class="w-full text-start">
                        <p class="text-sm font-semibold text-gray-900" x-text="result.title"></p>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2" x-text="result.description"></p>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full"
                              :class="result.type === 'sinal' ? 'bg-brand-100 text-brand-600' : 'bg-gray-100 text-gray-800'"
                              x-text="result.type_label"></span>
                    </div>
                </div>
            </a>
        </template>
    </div>

    <!-- Loading State -->
    <div x-show="loading"
         x-cloak
         x-transition
         class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow border border-gray-200 p-4 text-center">
        <i class="ph ph-circle-notch animate-spin text-brand-600 text-2xl"></i>
        <p class="text-sm text-gray-600 mt-2">Buscando...</p>
    </div>

    <!-- No Results -->
    <div x-show="showResults && !loading && query.length >= 2 && results.length === 0"
         x-cloak
         x-transition
         class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow border border-gray-200 p-6 text-center">
        <i class="ph ph-magnifying-glass text-gray-400 text-4xl"></i>
        <p class="text-sm text-gray-600 mt-2">Nenhum resultado encontrado</p>
    </div>

    <!-- Modal de Filtros -->
    <template x-teleport="body">
        <div x-show="filtersOpen" x-transition.opacity
             class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50" @click="filtersOpen = false"></div>

            <!-- Painel -->
            <div x-show="filtersOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[85vh] overflow-y-auto"
                 @click.away="filtersOpen = false">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Filtros</h3>
                    <button @click="filtersOpen = false" class="text-gray-400 hover:text-gray-600">
                        <i class="ph ph-x text-xl"></i>
                    </button>
                </div>

                <div class="px-5 py-4 space-y-4">
                    <template x-for="field in textFields" :key="field.key">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" x-text="field.label"></label>
                            <input
                                type="text"
                                x-model="filters[field.key]"
                                :placeholder="`Buscar por ${field.label.toLowerCase()}...`"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm"
                            />
                        </div>
                    </template>

                    <!-- Campo relacionado: categorias.nome -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <select
                            x-model="filters.categorias.nome"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm bg-white"
                            >
                            <option value="" :selected="!filters.categorias.nome">Todas as categorias</option>
                            <template x-for="option in categoriaOptions" :key="option">
                                <option
                                    :value="option"
                                    x-text="option"
                                    :selected="option === filters.categorias.nome"
                                ></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 px-5 py-4 border-t border-gray-100">
                    <button type="button" @click="clearFilters()"
                        class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Limpar
                    </button>
                    <button type="button" @click="applyFilters()"
                        class="flex-1 px-4 py-2.5 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700">
                        Aplicar filtros
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function globalSearch() {
    return {
        query: '',
        results: [],
        loading: false,
        showResults: false,
        defaultCategory: @js($category ?? ''),

        resetToUrl() {
            // zera tudo e repovoa somente com o que está na URL
            this.query = '';
            this.textFields.forEach(field => { this.filters[field.key] = ''; });
            this.filters.categorias.nome = this.defaultCategory;
            this.hydrateFromUrl();

            this.results = [];
            this.showResults = false;
            this.filtersOpen = false;
            this.loading = false;
        },
        
        // --- Filtros ---
        filtersOpen: false,
        filterStorageKey: 'global-search-filters',

        // Campos de texto livre (nome do campo -> label exibida)
        textFields: [
            { key: 'definicao', label: 'Definição' },
            { key: 'config_mao', label: 'Configuração de mão' },
            { key: 'ponto_articulacao', label: 'Ponto de articulação' },
            { key: 'orientacao_palma_mao', label: 'Orientação da palma da mão' },
            { key: 'movimento', label: 'Movimento' },
            { key: 'expressao_nao_manual', label: 'Expressão não-manual' },
            { key: 'contexto_utilizacao', label: 'Contexto de utilização' },
        ],

        categoriaOptions: [
            'Letras Português',
            'Letras Inglês',
            'Pedagogia',
            'Matemática',
            'História',
            'Geografia',
            'Ciências Biológicas',
            'Educação Física',
        ],

        filters: {
            definicao: '',
            config_mao: '',
            ponto_articulacao: '',
            orientacao_palma_mao: '',
            movimento: '',
            expressao_nao_manual: '',
            contexto_utilizacao: '',
            categorias: { nome: @js($category ?? '') },
        },

        get activeFilterCount() {
            let count = 0;
            this.textFields.forEach(field => {
                if (this.filters[field.key]) count++;
            });
            if (this.filters.categorias.nome) count++;
            return count;
        },

        clearFilters() {
            this.textFields.forEach(field => { this.filters[field.key] = ''; });
            this.filters.categorias.nome = '';
            try {
                sessionStorage.removeItem(this.filterStorageKey);
            } catch (error) {
                console.warn('Could not clear saved search filters:', error);
            }
            this.filtersOpen = false;

            // Na página inicial, limpar filtros não deve iniciar uma busca nem
            // retirar o visitante da página. Em /sinais, atualiza os resultados.
            if (window.location.pathname === @js(route('public.sinais', [], false))) {
                this.performSearch(true);
            }
        },

        removeFilter(key) {
            if (key === 'categorias.nome') {
                this.filters.categorias.nome = '';
            } else if (Object.prototype.hasOwnProperty.call(this.filters, key)) {
                this.filters[key] = '';
            }

            this.persistFilters();

            if (window.location.pathname === @js(route('public.sinais', [], false))) {
                this.performSearch(true);
            }
        },

        applyFilters() {
            this.filtersOpen = false;
            this.performSearch(true);
        },
        // --- fim filtros ---

        init() {
            this.hydrateFromUrl();

            if (this.query.length >= 2) {
                this.search();
            }
        },

        async loadCategoryOptions() {
            try {
                const response = await fetch(@js(route('search.categories')), {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();

                if (Array.isArray(data.categories)) {
                    this.categoriaOptions = data.categories;
                }
            } catch (error) {
                console.warn('Não foi possível atualizar a lista de categorias:', error);
            }
        },

        // Lê os parâmetros da URL atual e repovoa o estado,
        // assim os filtros continuam "ativos" (refletidos no modal e no contador)
        // até que o usuário clique em "Limpar" — mesmo após navegar/recarregar a página.
        hydrateFromUrl() {
            const params = new URLSearchParams(window.location.search);

            if (params.has('query')) {
                this.query = params.get('query');
            }

            this.textFields.forEach(field => {
                if (params.has(field.key)) {
                    this.filters[field.key] = params.get(field.key);
                }
            });

            // categorias[nome] na querystring -> filters.categorias.nome
            const categoriaKey = params.has('categorias[nome]')
                ? 'categorias[nome]'
                : 'categorias.nome';
            if (params.has(categoriaKey)) {
                this.filters.categorias.nome = params.get(categoriaKey) || '';
            }
        },

        restoreFilters() {
            const params = new URLSearchParams(window.location.search);
            const hasCategoryInUrl = params.has('categorias[nome]') || params.has('categorias.nome') || params.has('categoria');

            try {
                const savedFilters = JSON.parse(sessionStorage.getItem(this.filterStorageKey) || 'null');
                if (savedFilters && typeof savedFilters === 'object') {
                    this.textFields.forEach(field => {
                        if (!params.has(field.key) && typeof savedFilters[field.key] === 'string') {
                            this.filters[field.key] = savedFilters[field.key];
                        }
                    });

                    if (!hasCategoryInUrl && typeof savedFilters.categorias?.nome === 'string') {
                        this.filters.categorias.nome = savedFilters.categorias.nome;
                    }
                }
            } catch (error) {
                console.warn('Could not restore saved search filters:', error);
            }

            this.persistFilters();
        },

        persistFilters() {
            try {
                sessionStorage.setItem(this.filterStorageKey, JSON.stringify(this.filters));
            } catch (error) {
                console.warn('Could not save search filters:', error);
            }
        },

        async search() {
            const searchTerm = this.query.trim();
            const requestId = ++this.searchSequence;

            if (searchTerm.length < 2) {
                this.results = [];
                this.loading = false;
                return;
            }

            // Esconde os resultados anteriores enquanto a nova consulta está em andamento.
            this.results = [];
            this.loading = true;

            try {
                const response = await fetch(`{{ route('search.autocomplete') }}?query=${encodeURIComponent(searchTerm)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                // Ignora respostas antigas caso o texto tenha mudado durante a requisição.
                if (requestId !== this.searchSequence) return;

                this.results = data.results || [];
            } catch (error) {
                if (requestId !== this.searchSequence) return;

                console.error('Search error:', error);
                this.results = [];
            } finally {
                if (requestId === this.searchSequence) {
                    this.loading = false;
                }
            }
        },

        performSearch(force = false) {
            const params = new URLSearchParams();

            if (this.query) {
                params.set('query', this.query);
            }

            this.textFields.forEach(field => {
                if (this.filters[field.key]) {
                    params.append(field.key, this.filters[field.key]);
                }
            });

            // categorias.nome vira categorias[nome]=valor -> request()->filled('categorias.nome') no Laravel
            if (this.filters.categorias.nome) {
                params.append('categorias[nome]', this.filters.categorias.nome);
            }

            // force=true é usado ao limpar filtros, pra sempre atualizar a página
            // mesmo quando query e filtros ficam vazios.
            if (force || this.query.length >= 2 || this.activeFilterCount > 0) {
                this.persistFilters();
                const queryString = params.toString();
                window.location.href = `{{ route('public.sinais') }}${queryString ? `?${queryString}` : ''}`;
            }
        }
    }
}
</script>
