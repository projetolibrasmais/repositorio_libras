@props(['currentLetter' => null])

<div class="flex items-center justify-center gap-1 mb-8 flex-wrap">
    <!-- Botão Todos (ícone #) -->
    <a href="{{ route('public.catalogo') }}" 
       class="w-10 h-10 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors
              {{ !$currentLetter ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600 hover:bg-blue-200' }}">
        #
    </a>

    <!-- Letras A-Z -->
    @foreach(range('A', 'Z') as $letter)
        <a href="{{ route('public.catalogo', ['letra' => $letter]) }}" 
           class="w-10 h-10 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors
                  {{ $currentLetter === $letter ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600 hover:bg-blue-200' }}">
            {{ $letter }}
        </a>
    @endforeach
</div>
