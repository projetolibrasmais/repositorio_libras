@props([
    'permissao' => null,
    'titulo',
    'descricao' => '',
    'imagem'
])

@php
    $podeVer = $permissao ? auth()->user()?->can($permissao) : true;
@endphp

@if($podeVer)
<div x-data="{ open: false }">

    <!-- CARD -->
    <div
        @click="open = true"
        class="bg-white border border-gray-200 rounded-xl shadow-sm p-5
               cursor-pointer hover:shadow-md transition"
    >
        <h2 class="text-lg font-semibold text-gray-900">
            {{ $titulo }}
        </h2>

        @if($descricao)
            <p class="text-sm text-gray-500 mt-1">
                {{ $descricao }}
            </p>
        @endif
    </div>

    <!-- MODAL -->
    <div
        x-show="open"
        x-transition
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
    >
        <div
            @click.outside="open = false"
            class="bg-white rounded-xl shadow-lg max-w-4xl w-full p-6"
        >
            <h3 class="text-xl font-semibold mb-4">
                {{ $titulo }}
            </h3>

            <img
                src="{{ asset($imagem) }}"
                alt="{{ $titulo }}"
                class="w-full h-auto rounded-lg border object-contain"
            >

            <div class="mt-6 text-right">
                <button
                    @click="open = false"
                    class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800"
                >
                    Fechar
                </button>
            </div>
        </div>
    </div>

</div>
@endif
