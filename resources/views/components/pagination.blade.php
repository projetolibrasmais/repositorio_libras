@props(['paginator'])

@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
        <!-- Informação de registros -->
        <div class="text-sm text-gray-600">
            Mostrando 
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            até
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-medium">{{ $paginator->total() }}</span>
            resultados
        </div>

        <!-- Links de paginação -->
        <div class="flex items-center gap-2">
            {{-- Botão Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                    <i class="ph ph-caret-left mr-1"></i>
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                    <i class="ph ph-caret-left mr-1"></i>
                    Anterior
                </a>
            @endif

            {{-- Números de página --}}
            <div class="hidden sm:flex items-center gap-1">
                @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-white bg-brand-600 border border-brand-600 rounded-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Botão Próximo --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                    Próximo
                    <i class="ph ph-caret-right ml-1"></i>
                </a>
            @else
                <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                    Próximo
                    <i class="ph ph-caret-right ml-1"></i>
                </span>
            @endif
        </div>
    </div>
@endif
