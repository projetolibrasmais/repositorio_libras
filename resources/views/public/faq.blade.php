<x-public-layout>
    <x-slot name="title">FAQ - Plataforma Digital Libras+</x-slot>
    <!-- Seção FAQ -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-[#4A83FF] mb-8 text-center">FAQ</h1>
    </div>

    <!-- Divisor -->
    <div class="flex items-center justify-center py-2 px-10">
        <div class="flex-grow border-t border-gray-300"></div>
        <div class="mx-4">
            <i class="ph ph-hand-waving text-[#4A83FF] text-3xl"></i>
        </div>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Seção Sobre o Projeto -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-[#4A83FF] mb-8 text-center">Perguntas Frequentes</h1>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div>
                <x-faq-card
                    nome="O que é a Plataforma Digital Libras+?"
                    descricao="A Plataforma Digital Libras+ é um recurso online projetado para facilitar o aprendizado e a prática da Língua Brasileira de Sinais (Libras) por meio de vídeos, exercícios interativos e materiais didáticos."            
                />

                <x-faq-card
                    nome="Quem pode usar a Plataforma Digital Libras+?"
                    descricao="A plataforma é aberta a todos os interessados em aprender Libras, incluindo estudantes, profissionais da área de educação, intérpretes e qualquer pessoa que deseje se comunicar com a comunidade surda."/>
                <x-faq-card
                    nome="Quais são os recursos disponíveis na plataforma?"
                    descricao="Os recursos disponíveis incluem vídeos explicativos, materiais didáticos e um repositório de sinais em Libras."/>

                <x-faq-card
                    nome="Como posso acessar a plataforma?"
                    descricao="A plataforma pode ser acessada através do nosso site oficial, onde você pode criar uma conta gratuita para começar a explorar os recursos disponíveis."/>
        </div>
    </div>

    </div>

</x-public-layout>