<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Material') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Editar Material" description="Atualize as informações do material">
                    <x-slot name="action">
                        <a href="{{ route('materiais.show', $material) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <i class="ph ph-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </x-slot>
                </x-page-header>

                <!-- Form -->
                <form method="POST" action="{{ route('materiais.update', $material) }}" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Form Card (2/3) -->
                        <div class="lg:col-span-2">
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Básicas</h3>

                                <div class="space-y-4">
                                    <!-- Título -->
                                    <div>
                                        <label for="titulo"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Título <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-file-text text-gray-400"></i>
                                            </div>
                                            <input type="text" name="titulo" id="titulo"
                                                value="{{ old('titulo', $material->titulo) }}" required 
                                                placeholder="Digite o título do material"
                                                class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('titulo') border-red-500 @enderror">
                                        </div>
                                        @error('titulo')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Descrição -->
                                    <div>
                                        <label for="descricao"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Descrição
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                                <i class="ph ph-text-align-left text-gray-400"></i>
                                            </div>
                                            <textarea name="descricao" id="descricao" rows="4"
                                                placeholder="Descreva o material (opcional)"
                                                class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('descricao') border-red-500 @enderror">{{ old('descricao', $material->descricao) }}</textarea>
                                        </div>
                                        @error('descricao')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Arquivo Atual -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Arquivo Atual
                                        </label>
                                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                            <i class="ph ph-file text-3xl text-gray-400"></i>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $material->titulo }}.{{ $material->tipo }}</p>
                                                <p class="text-xs text-gray-500">Tamanho: {{ $material->tamanho }}</p>
                                            </div>
                                            <a href="{{ route('materiais.download', $material) }}"
                                                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                <i class="ph ph-download mr-1"></i>
                                                Baixar
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Novo Arquivo (opcional) -->
                                    <div>
                                        <label for="arquivo"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Substituir Arquivo <span class="text-xs text-gray-500">(opcional)</span>
                                        </label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors @error('arquivo') border-red-500 @enderror">
                                            <div class="space-y-1 text-center">
                                                <i class="ph ph-upload-simple text-5xl text-gray-400 mb-3"></i>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="arquivo"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Selecione um novo arquivo</span>
                                                        <input id="arquivo" name="arquivo" type="file"
                                                            class="sr-only"
                                                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.odt,.ods,.odp"
                                                            onchange="updateFileName(this)">
                                                    </label>
                                                    <p class="pl-1">ou arraste e solte</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PDF, Word, Excel, PowerPoint até 20MB
                                                </p>
                                                <p id="file-name" class="text-sm font-medium text-gray-900 mt-2"></p>
                                            </div>
                                        </div>
                                        @error('arquivo')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
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
                                                <li>Arquivos aceitos: PDF, Word, Excel, PowerPoint</li>
                                                <li>Tamanho máximo: 20MB</li>
                                                <li>Deixe o campo arquivo vazio para manter o atual</li>
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
                        <a href="{{ route('materiais.show', $material) }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="ph ph-floppy-disk mr-2"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            const fileNameElement = document.getElementById('file-name');
            if (fileName) {
                fileNameElement.textContent = `Novo arquivo selecionado: ${fileName}`;
            }
        }
    </script>
</x-app-layout>
