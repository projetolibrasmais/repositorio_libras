<x-public-layout>
    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-xl text-brand-600 mb-12 font-semibold">
                    {{ __('Encontre facilmente um sinal, palavra, categoria ou configuração de mão.') }}
                </p>

                <!-- Global Search Component -->
                <x-global-search :placeholder="__('O que você procura?')" />
            </div>
        </div>
    </div>

    <!-- Divisor -->
    <div class="flex items-center justify-center py-2 px-10">
        <div class="flex-grow border-t border-gray-300"></div>
        <div class="mx-4">
            <i
                class="ph ph-hand-waving bg-gradient-to-r from-brand-600 via-logo-green to-logo-pink text-transparent bg-clip-text text-3xl"></i>
        </div>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Seção Sobre -->
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="flex flex-col items-center text-center">
                    <h2 class="text-5xl font-bold text-brand-600 mb-6 text-center">
                        {{ __('Sobre o Projeto') }}
                    </h2>
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Sobre o Projeto" class="w-[50%] rounded-3xl border border-brand-700">
                </div>
                <div class="prose prose-lg text-gray-700 space-y-4 bg-white p-5 md:p-10 rounded-lg">
                    <p>
                        {{ __('A Plataforma Digital Libras + é uma iniciativa dedicada à criação de um Repositório Multidisciplinar em Libras, com o objetivo de promover a inclusão de acadêmicos surdos no ensino superior, especialmente nos cursos da Universidade Aberta do Brasil (UAB) e da Unimontes.') }}
                    </p>
                    <p>
                        {{ __('Nosso foco é identificar e catalogar sinais específicos para terminologias acadêmicas em áreas como Letras, História, Geografia, Pedagogia, Educação Física e Matemática. A plataforma, desenvolvida por professores e pesquisadores surdos e ouvintes, busca preencher a lacuna de vocabulário técnico, facilitando assim o acesso e a comunicação dos estudantes surdos no processo de ensino-aprendizagem.') }}
                    </p>
                    <a href="{{ route('public.about') }}"
                        class="inline-flex items-center px-6 py-3 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700 transition-colors mt-4">
                        {{ __('Saber mais') }}
                        <i class="ph ph-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Quick Links -->
    <div class="py-16 ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-brand-600 mb-12">
                Explore a Plataforma
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <a href="{{ route('public.sinais') }}"
                    class="bg-white rounded-xl p-6 transition-shadow border-2 border-transparent hover:border-logo-green">
                    <div class="w-12 h-12 bg-logo-green/10 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-hand-waving text-logo-green text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">Sinais</h3>
                    <p class="text-gray-600 text-sm">
                        Navegue por todos os sinais catalogados na plataforma
                    </p>
                </a>

                <a href="{{ route('public.catalogo') }}"
                    class="bg-white rounded-xl p-6 transition-shadow border-2 border-transparent hover:border-logo-pink">
                    <div class="w-12 h-12 bg-logo-pink/10 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-book-open text-logo-pink text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">Catálogo</h3>
                    <p class="text-gray-600 text-sm">
                        Acesse o catálogo completo de materiais e recursos
                    </p>
                </a>

                <a href="{{ route('public.categorias') }}"
                    class="bg-white rounded-xl p-6 transition-shadow border-2 border-transparent hover:border-logo-orange">
                    <div class="w-12 h-12 bg-logo-orange/10 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-folders text-logo-orange text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">Categorias</h3>
                    <p class="text-gray-600 text-sm">
                        Explore os sinais organizados por áreas do conhecimento
                    </p>
                </a>

                <a href="{{ route('public.about') }}"
                    class="bg-white rounded-xl p-6 transition-shadow border-2 border-transparent hover:border-logo-yellow">
                    <div class="w-12 h-12 bg-logo-yellow/10 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-info text-logo-yellow text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">Sobre</h3>
                    <p class="text-gray-600 text-sm">
                        Conheça mais sobre o projeto e nossa missão
                    </p>
                </a>

                <a href="{{ route('public.about') }}#materiais"
                    class="bg-white rounded-xl p-6 transition-shadow border-2 border-transparent hover:border-logo-sky">
                    <div class="w-12 h-12 bg-logo-sky/10 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-book text-logo-sky text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">Materiais e Produções</h3>
                    <p class="text-gray-600 text-sm">
                        Acesse os materiais e produções relacionados ao projeto
                    </p>
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
