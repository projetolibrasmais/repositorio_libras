<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Contatos e sugestões</h2></x-slot>
    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"><div class="p-6">
            <x-page-header title="Contatos e sugestões" description="Acompanhe as mensagens recebidas pelo formulário do projeto" />
            <x-search-bar placeholder="Pesquisar contatos..." :filterKeys="['status']">
                <x-slot name="filters">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"><div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1"><i class="ph ph-funnel mr-1"></i>Situação</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
                            <option value="">Todos</option>
                            <option value="nao_lidos" @selected(request('status') === 'nao_lidos')>Não lidos</option>
                            <option value="pendentes" @selected(request('status') === 'pendentes')>Pendentes</option>
                            <option value="respondidos" @selected(request('status') === 'respondidos')>Respondidos</option>
                        </select>
                    </div></div>
                </x-slot>
            </x-search-bar>
            @if ($contatos->count())
                <x-table>
                    <x-table-header :sortable="false">Contato</x-table-header>
                    <x-table-header :sortable="false">Assunto</x-table-header>
                    <x-table-header :sortable="false">Recebido em</x-table-header>
                    <x-table-header :sortable="false">Situação</x-table-header>
                    <x-table-header :sortable="false">Ações</x-table-header>
                    <x-slot name="body">
                        @foreach ($contatos as $contato)
                            <tr class="hover:bg-gray-50 transition-colors {{ $contato->lido ? '' : 'bg-brand-50' }}">
                                <td class="px-6 py-4 text-sm"><div class="font-medium text-gray-900">{{ $contato->nome }}</div><div class="text-gray-500">{{ $contato->email }}</div></td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $contato->assunto }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $contato->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($contato->respondido_em)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-medium">Respondido{{ $contato->canal_resposta === 'externo' ? ' por e-mail externo' : ' pelo sistema' }}</span>
                                    @elseif ($contato->lido)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-medium">Lido, pendente</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-brand-100 text-brand-800 font-medium">Não lido</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><div class="flex items-center gap-2">
                                    <a href="{{ route('contatos.show', $contato) }}" class="bg-brand-100 text-brand-600 px-3 py-1 rounded-lg hover:bg-brand-200 transition-colors" title="Visualizar" aria-label="Visualizar contato de {{ $contato->nome }}"><i class="ph ph-eye text-lg"></i></a>
                                    @can('edit_contatos') @unless ($contato->lido)
                                        <form method="POST" action="{{ route('contatos.read', $contato) }}">@csrf @method('PATCH')<button class="bg-green-100 text-green-700 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors" title="Marcar como lido" aria-label="Marcar contato de {{ $contato->nome }} como lido"><i class="ph ph-check text-lg"></i></button></form>
                                    @endunless @endcan
                                </div></td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
                <div class="mt-4">{{ $contatos->links() }}</div>
            @else
                <div class="py-12 text-center text-gray-500"><i class="ph ph-envelope-simple text-4xl text-gray-300"></i><p class="mt-2">Nenhum contato encontrado.</p></div>
            @endif
        </div></div>
    </div>
</x-app-layout>
