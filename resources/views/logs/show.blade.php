<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Log') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Visualizar Log"
                    description="Detalhes completos do log {{ $log->id }}">
                    <x-slot name="action">
                        <div class="flex gap-2">
                            <a href="{{ route('logs.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
                                <i class="ph ph-arrow-left mr-2"></i>
                                Voltar
                            </a>
                        </div>
                    </x-slot>
                </x-page-header>

                <!-- Log Details -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Info Card -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Informações Gerais -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-info mr-2 text-brand-600"></i>
                                    Informações Gerais
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- ID -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        ID
                                    </label>
                                    <p class="text-sm text-gray-900 font-mono bg-gray-50 rounded-lg p-3">
                                        #{{ $log->id }}
                                    </p>
                                </div>

                                <!-- Log Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Tipo de Log
                                    </label>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3">
                                        {{ $log->log_name }}
                                    </p>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Descrição
                                    </label>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-brand-100 text-brand-800">
                                        <i class="ph ph-note mr-1"></i>
                                        {{ $log->description }}
                                    </span>
                                </div>

                                <!-- Event -->
                                @if($log->event)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Evento
                                    </label>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $log->event === 'created' ? 'bg-brand-100 text-brand-800' : '' }}
                                        {{ $log->event === 'updated' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $log->event === 'restored' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $log->event === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $log->event === 'force_deleted' ? 'bg-gray-800 text-white' : '' }}">
                                        <i class="ph ph-lightning mr-1"></i>
                                        {{ ucfirst($log->event) }}
                                    </span>
                                </div>
                                @endif

                                <!-- Subject -->
                                @if($log->subject_type && $log->subject_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Modelo Afetado
                                    </label>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-900 font-medium">{{ class_basename($log->subject_type) }}</p>
                                        <p class="text-xs text-gray-500 mt-1">ID: {{ $log->subject_id }}</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Batch UUID -->
                                @if($log->batch_uuid)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Batch UUID
                                    </label>
                                    <p class="text-xs text-gray-900 font-mono bg-gray-50 rounded-lg p-3">
                                        {{ $log->batch_uuid }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Properties -->
                        @if($log->properties && count($log->properties) > 0)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-code mr-2 text-brand-600"></i>
                                    Propriedades
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                    <pre class="text-xs text-green-400 font-mono">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar Info -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- User Info -->
                        @if($log->causer)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-user mr-2 text-brand-600"></i>
                                    Usuário Responsável
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 h-12 w-12 bg-brand-100 rounded-full flex items-center justify-center">
                                        <i class="ph ph-user text-brand-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $log->causer->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $log->causer->email }}</p>
                                        <p class="text-xs text-gray-500 mt-1">ID: {{ $log->causer->id }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-user mr-2 text-brand-600"></i>
                                    Usuário Responsável
                                </h3>
                            </div>
                            <div class="p-6 text-center">
                                <i class="ph ph-user-circle text-gray-300 text-4xl"></i>
                                <p class="text-sm text-gray-500 mt-2">Sistema</p>
                            </div>
                        </div>
                        @endif

                        <!-- Timestamps Card -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-clock mr-2 text-brand-600"></i>
                                    Registro
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Created At -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Criado em
                                    </label>
                                    <p class="text-sm text-gray-900 flex items-center">
                                        <i class="ph ph-calendar-plus mr-2 text-gray-400"></i>
                                        {{ $log->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $log->created_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Updated At -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Atualizado em
                                    </label>
                                    <p class="text-sm text-gray-900 flex items-center">
                                        <i class="ph ph-calendar-check mr-2 text-gray-400"></i>
                                        {{ $log->updated_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $log->updated_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Difference -->
                                <div class="pt-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-500">
                                        <i class="ph ph-timer mr-1"></i>
                                        Criado {{ $log->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
