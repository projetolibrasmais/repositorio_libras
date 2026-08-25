@props([
    'permissao' => null,
    'titulo',
    'descricao' => '',
    'imagem',
])

@php
    $podeVer = $permissao ? auth()->user()?->can($permissao) : true;
@endphp

@if ($podeVer)
    <div x-data="{ open: false }" class="h-full">
        <button type="button"
            @click="open = true"
            class="h-full w-full text-left bg-white border border-gray-200 rounded-lg shadow-sm p-5 hover:border-logo-sky hover:shadow-md focus:outline-none focus:ring-2 focus:ring-logo-sky focus:ring-offset-2 transition">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                    <i class="ph ph-question text-brand-600 text-xl"></i>
                </div>

                <div class="min-w-0">
                    <h3 class="text-base font-semibold text-gray-900">
                        {{ $titulo }}
                    </h3>

                    @if ($descricao)
                        <p class="text-sm text-gray-600 mt-1 line-clamp-3">
                            {{ $descricao }}
                        </p>
                    @endif

                    <span class="inline-flex items-center gap-1 mt-4 text-sm font-medium text-brand-600">
                        Ver passo a passo
                        <i class="ph ph-arrow-right"></i>
                    </span>
                </div>
            </div>
        </button>

        <div x-show="open"
            x-transition.opacity
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70 px-4 py-6">
            <div @click.outside="open = false"
                class="bg-white rounded-lg shadow-xl max-w-5xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $titulo }}
                        </h3>
                        @if ($descricao)
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $descricao }}
                            </p>
                        @endif
                    </div>

                    <button type="button"
                        @click="open = false"
                        class="p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                        <i class="ph ph-x text-xl"></i>
                    </button>
                </div>

                <div class="p-6 overflow-auto bg-gray-50">
                    <img src="{{ asset($imagem) }}"
                        alt="{{ $titulo }}"
                        class="w-full h-auto rounded-lg border border-gray-200 object-contain bg-white">
                </div>
            </div>
        </div>
    </div>
@endif
