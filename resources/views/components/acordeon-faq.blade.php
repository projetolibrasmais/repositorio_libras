@props([
    'nome',        // Pergunta
    'descricao',   // Resposta
])

<div
    x-data="{ open: false }"
    class="bg-white border border-gray-200 rounded-xl shadow-sm
           hover:shadow-md transition">

    <!-- Cabeçalho (Pergunta) -->
    <button
        @click="open = !open"
        class="w-full flex items-center justify-between p-6 text-left">

        <div class="flex items-center gap-4">
            <!-- Ícone FAQ -->
            <div class="w-12 h-12 rounded-full bg-blue-100
                        flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-blue-500"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8.228 9c.549-1.165 2.03-2 3.772-2
                             2.21 0 4 1.343 4 3
                             0 1.4-1.017 2.318-2 2.732
                             -.805.34-1 1-1 2m.01 3h.01" />
                </svg>
            </div>

            <h3 class="text-lg font-semibold text-gray-800">
                {{ $nome }}
            </h3>
        </div>

        <!-- Ícone seta -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5 text-gray-500 transform transition-transform duration-300"
             :class="open ? 'rotate-180' : ''"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Conteúdo (Resposta) -->
    <div
        x-show="open"
        x-collapse
        class="px-6 pb-6 text-sm text-gray-600 leading-relaxed">
        {{ $descricao }}
    </div>
</div>
