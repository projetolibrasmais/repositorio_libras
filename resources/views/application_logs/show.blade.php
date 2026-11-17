<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalhes do log da aplicação</h2></x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <x-page-header title="Visualizar log" description="Entrada iniciada na linha {{ $log['id'] }} do laravel.log">
                    <x-slot name="action">
                        <a href="{{ route('application-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300"><i class="ph ph-arrow-left mr-2"></i>Voltar</a>
                    </x-slot>
                </x-page-header>

                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"><h3 class="text-lg font-semibold text-gray-900"><i class="ph ph-info mr-2 text-brand-600"></i>Informações gerais</h3></div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                            <div><p class="font-medium text-gray-500 mb-1">Data</p><p class="text-gray-900">{{ $log['date'] }}</p></div>
                            <div><p class="font-medium text-gray-500 mb-1">Nível</p><p class="text-gray-900">{{ $log['level'] }}</p></div>
                            <div><p class="font-medium text-gray-500 mb-1">Canal</p><p class="text-gray-900">{{ $log['channel'] }}</p></div>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"><h3 class="text-lg font-semibold text-gray-900"><i class="ph ph-note mr-2 text-brand-600"></i>Mensagem</h3></div>
                        <div class="p-6 text-sm text-gray-900 whitespace-pre-wrap break-words">{{ $log['message'] }}</div>
                    </div>
                    @if (trim($log['details']) !== '')
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50"><h3 class="text-lg font-semibold text-gray-900"><i class="ph ph-code mr-2 text-brand-600"></i>Detalhes e rastreamento</h3></div>
                            <div class="p-6"><pre class="bg-gray-900 text-green-400 rounded-lg p-4 overflow-x-auto text-xs font-mono whitespace-pre-wrap break-words">{{ $log['details'] }}</pre></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
