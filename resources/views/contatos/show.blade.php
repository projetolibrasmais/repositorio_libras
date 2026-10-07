<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalhes do contato</h2></x-slot>
    <div class="p-2 w-full h-full"><div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"><div class="p-6">
        <x-page-header title="Visualizar contato" description="Mensagem recebida em {{ $contato->created_at->format('d/m/Y H:i') }}">
            <x-slot name="action"><a href="{{ route('contatos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors"><i class="ph ph-arrow-left mr-2"></i>Voltar</a></x-slot>
        </x-page-header>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"><h3 class="text-lg font-semibold text-gray-900"><i class="ph ph-envelope-simple mr-2 text-brand-600"></i>Mensagem</h3></div>
                    <div class="p-6 space-y-4">
                        <div><label class="block text-sm font-medium text-gray-500 mb-1">Assunto</label><p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3">{{ $contato->assunto }}</p></div>
                        <div><label class="block text-sm font-medium text-gray-500 mb-1">Mensagem</label><p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3 whitespace-pre-wrap break-words">{{ $contato->mensagem }}</p></div>
                    </div>
                </div>
                @if ($contato->resposta)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm"><div class="px-6 py-4 border-b border-gray-200 bg-gray-50"><h3 class="text-lg font-semibold text-gray-900"><i class="ph ph-reply mr-2 text-brand-600"></i>Resposta enviada</h3></div><p class="p-6 text-sm text-gray-900 whitespace-pre-wrap break-words">{{ $contato->resposta }}</p></div>
                @endif
                @can('edit_contatos') @unless ($contato->respondido_em)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"><h3 class="text-lg font-semibold text-gray-900"><i class="ph ph-paper-plane-tilt mr-2 text-brand-600"></i>Responder pelo sistema</h3></div>
                        <form method="POST" action="{{ route('contatos.answer', $contato) }}" class="p-6 space-y-4" x-data="{ sending: false }" @submit="sending = true">@csrf
                            <label for="resposta" class="block text-sm font-medium text-gray-700">Resposta por e-mail</label>
                            <textarea id="resposta" name="resposta" required rows="6" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500">{{ old('resposta') }}</textarea>
                            @error('resposta') <p class="text-sm text-red-700">{{ $message }}</p> @enderror
                            <button type="submit" :disabled="sending" :aria-busy="sending.toString()" class="inline-flex items-center px-4 py-2.5 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 disabled:opacity-60 disabled:cursor-wait"><i class="ph mr-2" :class="sending ? 'ph-spinner animate-spin' : 'ph-paper-plane-tilt'"></i><span x-text="sending ? 'Enviando...' : 'Enviar resposta'">Enviar resposta</span></button>
                        </form>
                    </div>
                @endunless @endcan
            </div>
            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"><h3 class="text-lg font-semibold text-gray-900"><i class="ph ph-info mr-2 text-brand-600"></i>Informações</h3></div>
                    <div class="p-6 space-y-4 text-sm">
                        <div><span class="block font-medium text-gray-500">Nome</span><span class="text-gray-900">{{ $contato->nome }}</span></div>
                        <div><span class="block font-medium text-gray-500">E-mail</span><a class="text-brand-600 hover:underline break-all" href="mailto:{{ $contato->email }}">{{ $contato->email }}</a></div>
                        <div><span class="block font-medium text-gray-500">Recebido em</span><span class="text-gray-900">{{ $contato->created_at->format('d/m/Y H:i') }}</span></div>
                        <div><span class="block font-medium text-gray-500">Situação</span><span class="text-gray-900">{{ $contato->respondido_em ? 'Respondido em '.$contato->respondido_em->format('d/m/Y H:i').($contato->canal_resposta === 'externo' ? ' por e-mail externo' : ' pelo sistema') : 'Aguardando resposta' }}</span></div>
                    </div>
                </div>
                @can('edit_contatos') @unless ($contato->respondido_em)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 space-y-3">
                        <h3 class="text-lg font-semibold text-gray-900">Resposta externa</h3>
                        <p class="text-sm text-gray-600">Se respondeu pelo e-mail do projeto, registre aqui.</p>
                        <form method="POST" action="{{ route('contatos.answered', $contato) }}">@csrf @method('PATCH')<button class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300"><i class="ph ph-check mr-2"></i>Marcar como já respondido</button></form>
                    </div>
                @endunless @endcan
            </div>
        </div>
    </div></div></div>
</x-app-layout>
