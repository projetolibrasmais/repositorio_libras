<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Logs da aplicação</h2></x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <x-page-header title="Logs da aplicação" description="Registros do arquivo laravel.log" />

                <x-search-bar placeholder="Pesquisar mensagens e detalhes..." :filterKeys="['level']">
                    <x-slot name="filters">
                        <div class="max-w-xs">
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Nível</label>
                            <select name="level" id="level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-logo-sky text-sm">
                                <option value="">Todos os níveis</option>
                                @foreach (['EMERGENCY', 'ALERT', 'CRITICAL', 'ERROR', 'WARNING', 'NOTICE', 'INFO', 'DEBUG'] as $level)
                                    <option value="{{ $level }}" @selected(request('level') === $level)>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </x-slot>
                </x-search-bar>

                @if ($logs->count())
                    <x-table>
                        <x-table-header :sortable="false">Data</x-table-header>
                        <x-table-header :sortable="false">Nível</x-table-header>
                        <x-table-header :sortable="false">Canal</x-table-header>
                        <x-table-header :sortable="false">Mensagem</x-table-header>
                        <x-table-header :sortable="false">Ações</x-table-header>
                        <x-slot name="body">
                            @foreach ($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log['date'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded-md text-xs font-semibold {{ in_array($log['level'], ['ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY']) ? 'bg-red-100 text-red-800' : ($log['level'] === 'WARNING' ? 'bg-yellow-100 text-yellow-800' : 'bg-brand-100 text-brand-800') }}">{{ $log['level'] }}</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log['channel'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xl"><span class="block truncate" title="{{ $log['message'] }}">{{ $log['message'] }}</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('application-logs.show', $log['id']) }}" aria-label="Visualizar log" class="bg-brand-100 text-brand-600 px-3 py-1 rounded-lg hover:bg-brand-200 transition-colors"><i class="ph ph-eye text-lg"></i></a></td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table>
                    <x-pagination :paginator="$logs" />
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-md mb-4"><i class="ph ph-file-text text-gray-400 text-3xl"></i></div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum log encontrado</h3>
                        <p class="text-gray-600">O arquivo está vazio ou não há registros para os filtros selecionados.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
