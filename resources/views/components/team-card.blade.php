@props([
    'nome',
    'descricao' => null,
    'foto' => null, // caminho da imagem (opcional)
])

<div
    class="bg-white border border-gray-200 rounded-xl shadow-sm p-6
            flex flex-col items-center text-center
            hover:shadow-md transition">

    <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center mb-4 overflow-hidden">
        @if ($foto)
            <img src="{{ asset($foto) }}" alt="Foto de {{ $nome }}" class="w-full h-full object-cover">
        @else
            <!-- Ícone padrão -->
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256" class="w-16 h-16 text-logo-sky" fill="currentColor">
                <path d="M192,96a64,64,0,1,1-64-64A64,64,0,0,1,192,96Z" opacity="0.2"></path>
                <path
                    d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                </path>
            </svg>
        @endif

    </div>

    <h3 class="text-lg font-semibold text-gray-800">
        {{ $nome }}
    </h3>

    @if ($descricao)
        <span class="text-sm text-gray-500 mt-1">
            {{ $descricao }}
        </span>
    @endif
</div>
