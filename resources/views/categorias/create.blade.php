<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Categoria') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Nova Categoria" description="Crie uma nova categoria no sistema">
                    <x-slot name="action">
                        <a href="{{ route('categorias.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <i class="ph ph-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </x-slot>
                </x-page-header>

                <!-- Form -->
                <form method="POST" action="{{ route('categorias.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Form Card (2/3) -->
                        <div class="lg:col-span-2">
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Básicas</h3>
                                
                                <div class="space-y-4">
                                    <!-- Nome -->
                                    <div>
                                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">
                                            Nome <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-shield-checkered text-gray-400"></i>
                                            </div>
                                            <input type="text" 
                                                   name="nome" 
                                                   id="nome"
                                                   value="{{ old('nome') }}"
                                                   required
                                                   placeholder="Ex: Letras Português, Pedagogia"
                                                   class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-transparent @error('nome') border-red-500 @enderror">
                                        </div>
                                        @error('nome')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Info (1/3) -->
                        <div class="lg:col-span-1">
                            <div class="bg-brand-50 border border-brand-100 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="ph ph-info text-logo-sky text-2xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-brand-800">Informações</h3>
                                        <div class="mt-2 text-sm text-brand-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>O nome da categoria deve ser única</li>                                                
                                                <li>Campos marcados com * são obrigatórios</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                   

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('categorias.index') }}" 
                           class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                            <i class="ph ph-plus mr-2"></i>
                            Criar Categoria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
