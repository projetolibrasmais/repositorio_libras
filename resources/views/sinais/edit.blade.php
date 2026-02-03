<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Sinal') }}
        </h2>
    </x-slot>

    <div class="p-2 w-full h-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Page Header -->
                <x-page-header title="Editar Sinal" description="Atualize as informações do sinal no sistema">
                    <x-slot name="action">
                        <a href="{{ route('sinais.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <i class="ph ph-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </x-slot>
                </x-page-header>

                <!-- Form -->
                <form method="POST" action="{{ route('sinais.update', $sinal) }}" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                                value="{{ old('palavra_portugues', $sinal->palavra_portugues) }}"
                                                required placeholder=""
                                                class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('palavra_portugues') border-red-500 @enderror">
                                        </div>
                                        @error('palavra_portugues')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Definição -->
                                    <div>
                                        <label for="definicao" class="block text-sm font-medium text-gray-700 mb-1">
                                            Definição <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="definicao" id="definicao" rows="3" placeholder="Digite a definição do sinal..."
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('definicao') border-red-500 @enderror">{{ old('definicao', $sinal->definicao) }}</textarea>
                                        @error('definicao')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Parâmetros -->
                                    <div>
                                        <label for="parametros" class="block text-sm font-medium text-gray-700 mb-1">
                                            Parâmetros <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="parametros" id="parametros" rows="3" placeholder="Digite as instruções de execução do sinal..."
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('parametros') border-red-500 @enderror">{{ old('parametros', $sinal->parametros) }}</textarea>
                                        @error('parametros')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Contexto de Utilização -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contexto de Utilização</h3>
                                        <label for="contexto_utilizacao"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Contexto de Utilização <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="contexto_utilizacao" id="contexto_utilizacao" rows="3"
                                            placeholder="Descreva o contexto de utilização do sinal..."
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contexto_utilizacao') border-red-500 @enderror">{{ old('contexto_utilizacao', $sinal->contexto_utilizacao) }}</textarea>
                                        @error('contexto_utilizacao')
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
                                                    {{ old('status', $sinal->status) == 'catalogado' ? 'selected' : '' }}>
                                                    Catalogado
                                                </option>

                                                <option value="em_validacao"
                                                    {{ old('status', $sinal->status) == 'em_validacao' ? 'selected' : '' }}>
                                                    Em Validação
                                                </option>

                                                <option value="publicado"
                                                    {{ old('status', $sinal->status) == 'publicado' ? 'selected' : '' }}>
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
                                <h3 class="block text-sm font-medium text-gray-700 mb-1">Categorias <span
                                        class="text-red-500">*</span></h3>
                                <p class="text-sm text-gray-600 mb-4">Selecione a ou as categorias relacionadas a
                                    este sinal.</p>
                                @if ($categorias->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($categorias as $categoria)
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="categorias[]"
                                                        id="categoria_{{ $categoria->id }}"
                                                        value="{{ $categoria->id }}"
                                                        {{ in_array($categoria->id, old('categorias', $sinal->categorias->pluck('id')->toArray())) ? 'checked' : '' }}
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                </div>

                                                <div class="ml-2 text-sm">
                                                    <label for="categoria_{{ $categoria->id }}"
                                                        class="font-medium text-gray-700 cursor-pointer">
                                                        {{ $categoria->nome }}
                                                    </label>
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

                            <!-- Video -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                @if ($sinal->video && $sinal->video->url_video)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-2">Vídeo atual:</p>
                                        <div class="flex justify-center">
                                            <video controls class="w-full max-w-md rounded-lg border"
                                                preload="metadata">
                                                <source src="{{ Storage::url($sinal->video->url_video) }}"
                                                    type="video/mp4">
                                                Seu navegador não suporta vídeo.
                                            </video>
                                        </div>
                                    </div>
                                @endif

                                <x-file-input name="video" label="Vídeo do Sinal" accept="video/mp4"
                                    :maxSize="51200" :showPreview="true" previewType="video"
                                    description="Arraste e solte o vídeo ou clique para selecionar apenas caso queira trocar o vídeo atual" />
                                @error('video')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagens -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagens</h3>
                                @if ($sinal->imagens->count() > 0)
                                    <div
                                        class="mb-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach ($sinal->imagens as $imagem)
                                            <div class="relative border rounded-lg overflow-hidden">
                                                <img src="{{ Storage::url($imagem->url_imagem) }}"
                                                    alt="Imagem do Sinal" class="w-full h-48 object-cover">
                                                <form method="POST"
                                                    action="{{ route('sinais.imagens.destroy', [$sinal, $imagem]) }}"
                                                    class="absolute top-2 right-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-600 text-white rounded-full p-1 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                        onclick="return confirm('Tem certeza que deseja remover esta imagem?');">
                                                        <i class="ph ph-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                    </div>
                                @endif
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <x-file-input name="imagens[]" label="Adicionar Novas Imagens do Sinal"
                                        accept="image/*" :maxSize="10240" :showPreview="true" previewType="image"
                                        multiple description="Arraste e solte as imagens ou clique para selecionar" />
                                    @error('imagens')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('sinais.show', $sinal) }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="ph ph-plus mr-2"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
