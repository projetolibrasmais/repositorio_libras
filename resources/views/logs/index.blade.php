<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Logs') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Logs" description="Verifique o registro de atividades do sistema" />

                <!-- Search Bar -->
                <x-search-bar placeholder="Pesquisar logs..." />

                <!-- Table -->
                @if ($logs->count() > 0)
                    <x-table :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                        <x-table-header column="log_name" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Nome
                        </x-table-header>
                        <x-table-header column="description" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Descrição
                        </x-table-header>
                        <x-table-header column="event" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Evento
                        </x-table-header>
                        <x-table-header column="subject_id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            ID do Objeto
                        </x-table-header>
                        <x-table-header column="causer_id" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Usuário
                        </x-table-header>
                        <x-table-header column="created_at" :currentSort="request('sort')" :currentDirection="request('direction', 'asc')">
                            Data de Criação
                        </x-table-header>
                        <x-table-header :sortable="false">
                            Ações
                        </x-table-header>

                        <x-slot name="body">
                            @foreach ($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-clock-countdown text-orange-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $log->log_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <span
                                            class="inline-flex items-center rounded-full text-xs font-medium">
                                            {{ $log->description }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $log->event }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->subject_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->user->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('logs.show', $log) }}"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                                                <i class="ph ph-eye text-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table>

                    <!-- Pagination -->
                    <x-pagination :paginator="$logs" />
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <i class="ph ph-shield-checkered text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum log encontrado</h3>
                        <p class="text-gray-600">
                            @if (request('search'))
                                Não foram encontrados logs com o termo "{{ request('search') }}".
                            @else
                                Não há logs cadastrados no sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
