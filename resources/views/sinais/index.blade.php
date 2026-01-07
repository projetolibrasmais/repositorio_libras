<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sinais') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Sinais" description="Gerencie todas os sinais do sistema">
                    <x-slot name="action">
                        @can('create_sinais')
                            <a href="{{ route('sinais.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="ph ph-plus mr-2"></i>
                                Novo Sinal
                            </a>
                        @endcan
                    </x-slot>
                </x-page-header>

                <!-- Search Bar -->
                <x-search-bar placeholder="Pesquisar sinais..." />

                <!-- Table -->
                @if ($sinais->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            #
                        </x-table-header>
                        <x-table-header column="palavra_portugues" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Palavra em Português
                        </x-table-header>
                        <x-table-header column="definicao" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Definição
                        </x-table-header>
                        <x-table-header column="instrucao_execucao" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Instrução de Execução
                        </x-table-header>
                        <x-table-header column="status" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Status
                        </x-table-header>
                        <x-table-header column="video_principal_id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Id do Vídeo Principal
                        </x-table-header>
                        <x-table-header column="categorias" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Categorias
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                        @foreach ($sinais as $sinal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $sinal->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-bookmark text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $sinal->palavra_portugues }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-bookmark text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $sinal->definicao }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-bookmark text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $sinal->instrucao_execucao }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-bookmark text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $sinal->status }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-bookmark text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $sinal->video_principal_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($sinal->categorias->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($sinal->categorias as $categoria)
                                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                                                    {{ $categoria->nome }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>


                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $sinal->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('sinais.show', $sinal) }}"
                                            class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                                            <i class="ph ph-eye text-lg"></i>
                                        </a>
                                        @can('edit_sinais')
                                            <a href="{{ route('sinais.edit', $sinal) }}"
                                                class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">
                                                <i class="ph ph-pencil text-lg"></i>
                                            </a>
                                        @endcan
                                        @can('delete_sinais')
                                            <form action="{{ route('sinais.destroy', $sinal) }}" method="POST"
                                                class="delete-form-{{ $sinal->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="deleteForm = document.querySelector('.delete-form-{{ $sinal->id }}'); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-sinal' }));"
                                                    class="bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors">
                                                    <i class="ph ph-trash text-lg"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </x-slot>
                    </x-table>

                    <!-- Pagination -->
                    <x-pagination :paginator="$sinais" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-shield-checkered text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhuma sinal encontrada</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontradas sinais com o termo "{{ request('search') }}".
                            @else
                                Não há sinais cadastradas no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <x-delete-modal name="delete-sinal" title="Confirmar Exclusão da sinal"
        message="Tem certeza que deseja excluir esta sinal? Todos os sinais associados a esta sinal perderão suas definições. Esta ação não pode ser desfeita." />

    @push('scripts')
        <script>
            let deleteForm = null;

            function confirmDelete() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            }
        </script>
    @endpush
</x-app-layout>
