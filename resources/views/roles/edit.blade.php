<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Função') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Editar Função" description="Atualize as informações da função">
                    <x-slot name="action">
                        <a href="{{ route('roles.show', $role) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <i class="ph ph-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </x-slot>
                </x-page-header>

                <!-- Form -->
                <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Form Card (2/3) -->
                        <div class="lg:col-span-2">
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Básicas</h3>
                                
                                <div class="space-y-4">
                                    <!-- Nome -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Nome da Função <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-shield-checkered text-gray-400"></i>
                                            </div>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name"
                                                   value="{{ old('name', $role->name) }}"
                                                   required
                                                   class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-logo-sky focus:border-transparent @error('name') border-red-500 @enderror">
                                        </div>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Guard Name -->
                                    <div>
                                        <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Guard
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-shield text-gray-400"></i>
                                            </div>
                                            <input type="text" 
                                                   readonly 
                                                   value="{{ $role->guard_name }}"
                                                   class="pl-10 w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-700 cursor-not-allowed">
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">O guard não pode ser alterado após a criação.</p>
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
                                                <li>O nome da função deve ser único</li>
                                                <li>Selecione as permissões desejadas</li>
                                                <li>Campos marcados com * são obrigatórios</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permissões -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Permissões</h3>
                        
                        @if($permissions->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($permissions as $permission)
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" 
                                                   name="permissions[]" 
                                                   id="permission_{{ $permission->id }}"
                                                   value="{{ $permission->name }}"
                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-brand-600 bg-gray-100 border-gray-300 rounded focus:ring-logo-sky focus:ring-2">
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="permission_{{ $permission->id }}" class="font-medium text-gray-700 cursor-pointer">
                                                {{ $permission->name }}
                                            </label>
                                            @if($permission->description)
                                                <p class="text-gray-500 text-xs">{{ $permission->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-3">
                                    <i class="ph ph-lock-key text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-600">Nenhuma permissão disponível.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('roles.show', $role) }}" 
                           class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-logo-sky transition-colors">
                            <i class="ph ph-floppy-disk mr-2"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
