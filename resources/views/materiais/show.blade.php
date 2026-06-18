<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Material') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Visualizar Material"
                    description="Detalhes completos do material {{ $material->titulo }}">
                    <x-slot name="action">
                        <div class="flex gap-2">
                            <a href="{{ route('materiais.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
                                <i class="ph ph-arrow-left mr-2"></i>
                                Voltar
                            </a>
                            <a href="{{ route('materiais.download', $material) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <i class="ph ph-download mr-2"></i>
                                Baixar
                            </a>
                            @can('edit_materiais')
                                <a href="{{ route('materiais.edit', $material) }}"
                                    class="inline-flex items-center px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                                    <i class="ph ph-pencil mr-2"></i>
                                    Editar
                                </a>
                            @endcan
                        </div>
                    </x-slot>
                </x-page-header>

                <!-- Material Details -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Info Card -->
                    <div class="lg:col-span-2">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="ph ph-info mr-2 text-brand-600"></i>
                                    Informações Gerais
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Título -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        Título do Material
                                    </label>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3">
                                        {{ $material->titulo }}
                                    </p>
                                </div>

                                <!-- ID -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">
                                        ID
                                    </label>
                                    <p class="text-sm text-gray-900 font-mono bg-gray-50 rounded-lg p-3">
                                        #{{ $material->id }}
                                    </p>
                                </div>

                                <!-- Descrição -->
                                @if($material->descricao)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">
                                            Descrição
                                        </label>
                                        <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3">
                                            {{ $material->descricao }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="lg:col-span-1 space-y-6">
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
                                        {{ $material->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $material->created_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Updated At -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Atualizado em
                                    </label>
                                    <p class="text-sm text-gray-900 flex items-center">
                                        <i class="ph ph-calendar-check mr-2 text-gray-400"></i>
                                        {{ $material->updated_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">
                                        {{ $material->updated_at->format('H:i:s') }}
                                    </p>
                                </div>

                                <!-- Difference -->
                                <div class="pt-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-500">
                                        <i class="ph ph-timer mr-1"></i>
                                        Criado {{ $material->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- User Card -->
                        @if($material->user)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="ph ph-user mr-2 text-brand-600"></i>
                                        Enviado por
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-3">
                                        {{ $material->user->name }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Preview Card (if applicable) -->
                @if(in_array($material->tipo, ['pdf', 'txt']))
                    <div class="mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="ph ph-file-text mr-2 text-brand-600"></i>
                                Visualização do Arquivo
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($material->tipo === 'pdf')
                                <iframe src="{{ \App\Helpers\StorageHelper::getMaterialUrl($material->arquivo_path) }}" 
                                    class="w-full h-[600px] border border-gray-300 rounded-lg"
                                    frameborder="0">
                                    Seu navegador não suporta visualização de PDF.
                                </iframe>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
