<x-public-layout>
    <x-slot name="title">Sobre - Plataforma Digital Libras+</x-slot>

    <!-- Seção Sobre o Projeto -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-brand-600 mb-8 text-center">Sobre o Projeto</h1>
        <div class="prose prose-lg max-w-none bg-white rounded-xl p-8 mb-8">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Imagem ilustrativa sobre o projeto"
                class="h-48 mx-auto mb-6 object-cover">
            <p class="text-gray-700 leading-relaxed mb-4">
                A Plataforma Digital Libras + é uma iniciativa dedicada à criação de um Repositório Digital
                em Libras, com o objetivo de promover a inclusão de acadêmicos surdos no ensino superior,
                especialmente nos cursos da Universidade Aberta do Brasil (UAB) e da Unimontes.
            </p>
            <p class="text-gray-700 leading-relaxed mb-4">
                O projeto visa identificar e catalogar sinais específicos para terminologias acadêmicas em áreas como
                Letras, História, Geografia, Pedagogia, Educação Física, Matemática e Biologia, reunindo conteúdos de
                difícil acesso em uma única plataforma digital.
            </p>
            <p class="text-gray-700 leading-relaxed">
                Desenvolvida de forma colaborativa entre professores e pesquisadores surdos e ouvintes, a iniciativa
                busca preencher lacunas no vocabulário técnico da LIBRAS, facilitando a comunicação, fortalecendo a
                acessibilidade e garantindo maior equidade no processo de ensino-aprendizagem no contexto acadêmico.
            </p>
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

    <!-- Seção Equipe -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-brand-600 mb-8 text-center ">Equipe</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <x-team-card nome="Caio Luis" descricao="Desenvolvedor" />
            <x-team-card nome="Matheus Souza" descricao="Desenvolvedor" />
            <x-team-card nome="João Silva" descricao="Pesquisador" />
            <x-team-card nome="Ricardo Macedo" descricao="Designer" />
            <x-team-card nome="Marcos Oliveira" descricao="Analista de Dados" />
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

    <!-- Seção Objetivo -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-brand-600 mb-8 text-center">Objetivo</h1>
        <div class="prose prose-lg max-w-none bg-white rounded-xl p-8 mb-8">
            <p class="text-gray-700 leading-relaxed mb-4">
                Desenvolver e implementar uma plataforma digital destinada à catalogação, organização e disponibilização
                de sinais em Língua Brasileira de Sinais (LIBRAS) de difícil acesso ou pouco difundidos. O projeto visa
                centralizar esses sinais em um repositório único, confiável e de fácil consulta, apoiando atividades de
                ensino, pesquisa e extensão no âmbito da Universidade Aberta do Brasil (UAB). Além disso, busca
                contribuir para a preservação, padronização e valorização da LIBRAS, fortalecendo práticas educacionais
                inclusivas e ampliando o acesso ao conhecimento linguístico no meio acadêmico.
            </p>
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

    <!-- Seção Financiamento -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-brand-600 mb-8 text-center">Financiamento</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-6">
            <x-team-card nome="Fadenor" />
            <x-team-card nome="Unimontes CEAD" />
            <x-team-card nome="UAB" />
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

    <!-- Seção Materiais e Produções -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-brand-600 mb-8 text-center">Materiais e Produções</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        id="materiais">
        @foreach ($materiais as $material)
            <x-material-card titulo="{{ $material->titulo }}" descricao="{{ $material->descricao }}"
                link="{{ $material->arquivo_path }}" />
        @endforeach
    </div>

</x-public-layout>
