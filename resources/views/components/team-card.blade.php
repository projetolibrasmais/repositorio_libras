@props([
    'nome',
    'descricao' => null,
    'foto' => null, // caminho da imagem (opcional)
])

<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6
            flex flex-col items-center text-center
            hover:shadow-md transition">

    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-4 overflow-hidden">
        
        @if($foto)
            <img
                src="{{ asset($foto) }}"
                alt="Foto de {{ $nome }}"
                class="w-full h-full object-cover"
            >
        @else
            <!-- Ícone padrão -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-10 h-10 text-blue-500"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5.121 17.804A9 9 0 1118.9 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        @endif

    </div>

    <h3 class="text-lg font-semibold text-gray-800">
        {{ $nome }}
    </h3>

    @if($descricao)
        <span class="text-sm text-gray-500 mt-1">
            {{ $descricao }}
        </span>
    @endif
</div>