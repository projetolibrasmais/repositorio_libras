@props(['paginator'])

@if ($paginator->hasPages())
    @php
        $windows = array_values(array_filter(
            \Illuminate\Pagination\UrlWindow::make($paginator->onEachSide(1))
        ));
    @endphp

    <nav aria-label="Paginação" class="mt-8 flex flex-col items-center justify-between gap-4 border-t border-gray-200 pt-5 sm:flex-row">
        <p class="text-center text-sm text-gray-600 sm:text-left">
            Exibindo <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
            a <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
            de <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span> resultados
        </p>

        <div class="flex max-w-full items-center gap-1 overflow-x-auto pb-1">
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Página anterior"
                    class="inline-flex h-10 min-w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-gray-400">
                    <i class="ph ph-caret-left" aria-hidden="true"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Página anterior"
                    class="inline-flex h-10 min-w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-brand-700 transition hover:border-brand-600 hover:bg-brand-50 focus:outline-none focus:ring-2 focus:ring-logo-sky">
                    <i class="ph ph-caret-left" aria-hidden="true"></i>
                </a>
            @endif

            @foreach ($windows as $window)
                @unless ($loop->first)
                    <span aria-hidden="true" class="hidden px-1 text-gray-500 sm:inline">…</span>
                @endunless
                @foreach ($window as $page => $url)
                    @if ($page === $paginator->currentPage())
                        <span aria-current="page" aria-label="Página {{ $page }}"
                            class="inline-flex h-10 min-w-10 shrink-0 items-center justify-center rounded-lg bg-brand-700 px-2 text-sm font-semibold text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" aria-label="Ir para a página {{ $page }}"
                            class="hidden h-10 min-w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white px-2 text-sm font-medium text-brand-800 transition hover:border-brand-600 hover:bg-brand-50 focus:outline-none focus:ring-2 focus:ring-logo-sky sm:inline-flex">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Próxima página"
                    class="inline-flex h-10 min-w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-brand-700 transition hover:border-brand-600 hover:bg-brand-50 focus:outline-none focus:ring-2 focus:ring-logo-sky">
                    <i class="ph ph-caret-right" aria-hidden="true"></i>
                </a>
            @else
                <span aria-disabled="true" aria-label="Próxima página"
                    class="inline-flex h-10 min-w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-gray-400">
                    <i class="ph ph-caret-right" aria-hidden="true"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
