<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Sinal') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Novo Sinal" description="Crie uma novo sinal no sistema">
                    <x-slot name="action">
                        <a href="{{ route('sinais.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <i class="ph ph-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </x-slot>
                </x-page-header>

                <!-- Form -->
                <form method="POST" action="{{ route('sinais.store') }}" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Form Card (2/3) -->
                        <div class="lg:col-span-3">
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Básicas</h3>

                                <div class="space-y-4">
                                    <!-- Palavra_Portugues -->
                                    <div>
                                        <label for="palavra_portugues"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Palavra em Português <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-hand-waving text-gray-400"></i>
                                            </div>
                                            <input type="text" name="palavra_portugues" id="palavra_portugues"
                                                value="{{ old('palavra_portugues') }}" required placeholder=""
                                                class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('palavra_portugues') border-red-500 @enderror">
                                        </div>
                                        @error('palavra_portugues')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Definicao-->
                                    <div>
                                        <label for="definicao" class="block text-sm font-medium text-gray-700 mb-1">
                                            Definição
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-book-open-text text-gray-400"></i>
                                            </div>
                                            <input type="text" name="definicao" id="definicao"
                                                value="{{ old('definicao') }}" placeholder=""
                                                class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('definicao') border-red-500 @enderror">
                                        </div>
                                        @error('definicao')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Instrução de Execução -->
                                    <div>
                                        <label for="instrucao_execucao"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Instrução de Execução
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-hand-waving text-gray-400"></i>
                                            </div>
                                            <input type="text" name="instrucao_execucao" id="instrucao_execucao"
                                                value="{{ old('instrucao_execucao') }}" placeholder=""
                                                class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('instrucao_execucao') border-red-500 @enderror">
                                        </div>
                                        @error('instrucao_execucao')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                            Status <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="ph ph-shield-checkered text-gray-400"></i>
                                            </div>
                                            <select name="status" id="status" required
                                                class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg  bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">

                                                <option value="">Selecione o status</option>

                                                <option value="catalogado"
                                                    {{ old('status') == 'catalogado' ? 'selected' : '' }}>
                                                    Catalogado
                                                </option>

                                                <option value="em_validacao"
                                                    {{ old('status') == 'em_validacao' ? 'selected' : '' }}>
                                                    Em Validação
                                                </option>

                                                <option value="publicado"
                                                    {{ old('status') == 'publicado' ? 'selected' : '' }}>
                                                    Publicado
                                                </option>
                                            </select>

                                        </div>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Info (1/3) -->
                        <div class="lg:col-span-3 flex flex-col gap-6">
                            <!-- Categorias -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="block text-sm font-medium text-gray-700 mb-1">Categorias</h3>
                                <p class="text-sm text-gray-600 mb-4">Selecione as categorias relacionadas a
                                    este sinal.</p>

                                @if ($categorias->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($categorias as $categoria)
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="categorias[]"
                                                        id="categoria_{{ $categoria->id }}"
                                                        value="{{ $categoria->id }}"
                                                        {{ in_array($categoria->id, old('categorias', [])) ? 'checked' : '' }}
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                </div>

                                                <div class="ml-2 text-sm">
                                                    <label for="categoria_{{ $categoria->id }}"
                                                        class="font-medium text-gray-700 cursor-pointer">
                                                        {{ $categoria->nome }}
                                                    </label>

                                                    @if (!empty($categoria->descricao))
                                                        <p class="text-gray-500 text-xs">
                                                            {{ $categoria->descricao }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <div
                                            class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-3">
                                            <i class="ph ph-tag text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-600">Nenhuma categoria disponível.</p>
                                    </div>
                                @endif
                                @error('categorias')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Video Principal Id -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <x-file-input name="video" label="Vídeo do Sinal" accept="video/mp4" :maxSize="51200"
                                    :showPreview="true" previewType="video"
                                    description="Arraste e solte o vídeo ou clique para selecionar" required />
                                @error('video')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('sinais.index') }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="ph ph-plus mr-2"></i>
                            Criar Sinal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
