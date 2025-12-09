<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Função') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Nova Função" description="Crie uma nova função no sistema">
                    <x-slot name="action">
                        <a href="{{ route('roles.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <i class="ph ph-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </x-slot>
                </x-page-header>

                <!-- Form -->
                <form method="POST" action="{{ route('roles.store') }}" class="space-y-6">
                    @csrf

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
                                                   value="{{ old('name') }}"
                                                   required
                                                   placeholder="Ex: Editor, Moderador"
                                                   class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                                        </div>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Guard Name -->
                                    <div>
                                        <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Guard <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-shield text-gray-400"></i>
                                            </div>
                                            <select name="guard_name" 
                                                    id="guard_name"
                                                    required
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('guard_name') border-red-500 @enderror">
                                                <option value="web" {{ old('guard_name') == 'web' ? 'selected' : '' }}>Web</option>
                                            </select>
                                        </div>
                                        @error('guard_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-sm text-gray-500">Selecione o guard para esta função.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Info (1/3) -->
                        <div class="lg:col-span-1">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="ph ph-info text-blue-500 text-2xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Informações</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>O nome da função deve ser único</li>
                                                <li>Selecione o guard apropriado</li>
                                                <li>Atribua permissões à função</li>
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
                        <p class="text-sm text-gray-600 mb-4">Selecione as permissões que esta função terá acesso.</p>
                        
                        @if($permissions->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($permissions as $permission)
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" 
                                                   name="permissions[]" 
                                                   id="permission_{{ $permission->id }}"
                                                   value="{{ $permission->name }}"
                                                   {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
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
                        <a href="{{ route('roles.index') }}" 
                           class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="ph ph-plus mr-2"></i>
                            Criar Função
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
