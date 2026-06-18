@props(['currentLetter' => null])

<div class="flex items-center justify-center gap-1 mb-8 flex-wrap">
    <!-- Botão Todos (ícone #) -->
    <a href="{{ route('public.catalogo') }}" 
       class="w-10 h-10 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors
              {{ !$currentLetter ? 'bg-brand-600 text-white' : 'bg-brand-100 text-brand-600 hover:bg-brand-500 hover:text-white' }}">
        #
    </a>

    <!-- Letras A-Z -->
    @foreach(range('A', 'Z') as $letter)
        <a href="{{ route('public.catalogo', ['letra' => $letter]) }}" 
           class="w-10 h-10 flex items-center justify-center rounded-lg font-semibold text-sm transition-colors
                  {{ $currentLetter === $letter ? 'bg-brand-600 text-white' : 'bg-brand-100 text-brand-600 hover:bg-brand-500 hover:text-white' }}">
            {{ $letter }}
        </a>
    @endforeach
</div>
