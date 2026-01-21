<x-app-layout>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    

{{-- SINAIS --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="bg-gray-100 p-4 border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-900">Ajuda - Sinais</h1>
        <div class="p-6 space-y-4">
            {{-- CRIAR SINAL --}}
            <x-help-card
                permissao="create_sinais"
                titulo="Criar Sinal"
                descricao="Para criar um sinal, acesse o menu Sinais, clique em Novo Sinal, preencha os dados e clique em Criar Sinal."
                imagem="help\sinais\create_sinal.PNG"
            />

            {{-- EDITAR SINAL --}}
            <x-help-card
                permissao="edit_sinais"
                titulo="Editar Sinal"
                descricao="Para editar um sinal, acesse o menu Sinais, clique no sinal desejado, faça as alterações e clique em Atualizar Sinal."
                imagem="help\sinais\edit_sinal.PNG"
            />

            {{-- EXCLUIR SINAL --}}
            <x-help-card
                permissao="delete_sinais"
                titulo="Excluir Sinal"
                descricao="Para excluir um sinal, acesse o menu Sinais, clique no sinal desejado, clique em Excluir Sinal e confirme."
                imagem="help\sinais\delete_sinal.PNG"
            />
            
            {{-- ACESSAR SINAIS DELETADOS --}}
            <x-help-card
                permissao="restore_sinais"
                titulo="Acessar Sinais Deletados"
                descricao="Para acessar sinais deletados, acesse o menu Sinais, acesse o filtro e selecione 'Apenas Sinais Deletados'."
                imagem="help\sinais\filtro_sinais.PNG"
            />
            
            {{-- RESTAURAR SINAIS DELETADOS --}}
            <x-help-card
                permissao="restore_sinais"
                titulo="Restaurar Sinais Deletados"
                descricao="Para restaurar um sinal deletado, acesse o menu Sinais, acesse o filtro e selecione 'Apenas Sinais Deletados'. Busque no sinal desejado e clique no ícone Restaurar."
                imagem="help\sinais\restore_sinais.PNG"
            />

            {{-- DELETAR PERMANENTEMENTE SINAIS DELETADOS--}}
            <x-help-card
                permissao="force_delete_sinais"
                titulo="Deletar Permanentemente um Sinal"
                descricao="Para deletar permanentemente um sinal, acesse o menu Sinais, acesse o filtro e selecione 'Apenas Sinais Deletados'. Clique no sinal desejado, clique no ícone Deletar Permanentemente e confirme."
                imagem="help\sinais\force_delete_sinais.PNG"
            />
        </div>
    </div>

    <div class="bg-gray-100 p-4 border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-900">Ajuda - Categoria</h1>
        <div class="p-6 space-y-4">
            <!-- CRIAR CATEGORIA -->
            <x-help-card
                permissao="create_categorias"
                titulo="Criar Categoria"
                descricao="Para criar uma categoria, acesse o menu Categorias, clique em Nova Categoria, preencha os dados e clique em Criar Categoria."
                imagem="help\categorias\create_categoria.PNG"
            />
            <!-- EDITAR CATEGORIA -->
            <x-help-card
                permissao="edit_categorias"
                titulo="Editar Categoria"
                descricao="Para editar uma categoria, acesse o menu Categorias, clique na categoria desejada, faça as alterações e clique em Atualizar Categoria."
                imagem="help\categorias\edit_categoria.PNG"
            />

            <!-- EXCLUIR CATEGORIA -->
            <x-help-card
                permissao="delete_categorias"
                titulo="Excluir Categoria"
                descricao="Para excluir uma categoria, acesse o menu Categorias, clique na categoria desejada, clique em Excluir Categoria e confirme."
                imagem="help\categorias\delete_categoria.PNG"
            />

            <!-- ACESSAR CATEGORIAS DELETADAS -->
            <x-help-card
                permissao="restore_categorias"
                titulo="Acessar Categorias Deletadas"
                descricao="Para acessar categorias deletadas, acesse o menu Categorias, acesse o filtro e selecione 'Apenas Categorias Deletadas'."
                imagem="help\categorias\filtro_categorias.PNG"
            />

            <!-- RESTAURAR CATEGORIAS DELETADAS -->
            <x-help-card
                permissao="restore_categorias"
                titulo="Restaurar Categorias Deletadas"
                descricao="Para restaurar uma categoria deletada, acesse o menu Categorias, acesse o filtro e selecione 'Apenas Categorias Deletadas'. Busque na categoria desejada e clique no ícone Restaurar."
                imagem="help\categorias\restore_categorias.PNG"
            />

            <!-- DELETAR PERMANENTEMENTE CATEGORIAS DELETADAS-->
            <x-help-card
                permissao="force_delete_categorias"
                titulo="Deletar Permanentemente uma Categoria"
                descricao="Para deletar permanentemente uma categoria, acesse o menu Categorias, acesse o filtro e selecione 'Apenas Categorias Deletadas'. Clique na categoria desejada, clique no ícone Deletar Permanentemente e confirme."
                imagem="help\categorias\force_delete_categorias.PNG"
            />

        </div>
    </div>
    
    <!-- USUÁRIOS -->
    <div class="bg-gray-100 p-4 border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-900">Ajuda - Usuários</h1>
        <div class="p-6 space-y-4">
            <!-- CRIAR USUÁRIOS -->
            <x-help-card
                permissao="create_users"
                titulo="Criar Usuários"
                descricao="Para criar usuários, acesse o menu Usuários, clique em Novo Usuário, preencha os dados e clique em Criar Usuário."
                imagem="help\usuarios\create_usuario.PNG"
            />

            <!-- EDITAR USUÁRIOS -->
            <x-help-card
                permissao="edit_users"
                titulo="Editar Usuários"
                descricao="Para editar um usuário, acesse o menu Usuários, clique no usuário desejado, faça as alterações e clique em Atualizar Usuário."
                imagem="help\usuarios\edit_usuario.PNG"
            />

            <!-- EXCLUIR USUÁRIOS -->
            <x-help-card
                permissao="delete_users"
                titulo="Excluir Usuários"
                descricao="Para excluir um usuário, acesse o menu Usuários, clique no usuário desejado, clique em Excluir Usuário e confirme."
                imagem="help\usuarios\delete_usuario.PNG"
            />

        </div>

    <!-- Funções -->
    <div class="bg-gray-100 p-4 border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-900">Ajuda - Funções</h1>
        <div class="p-6 space-y-4">
            <!-- CRIAR FUNÇÕES -->
            <x-help-card
                permissao="create_roles"
                titulo="Criar Funções"
                descricao="Para criar funções, acesse o menu Funções, clique em Nova Função, preencha os dados e clique em Criar Função."
                imagem="help\roles\create_roles.PNG"
            />

            <!-- EDITAR FUNÇÕES -->
            <x-help-card
                permissao="edit_roles"
                titulo="Editar Funções"
                descricao="Para editar uma função, acesse o menu Funções, clique na função desejada, faça as alterações e clique em Atualizar Função."
                imagem="help\roles\edit_roles.PNG"
            />

            <!-- EXCLUIR FUNÇÕES -->
            <x-help-card
                permissao="delete_roles"
                titulo="Excluir Funções"
                descricao="Para excluir uma função, acesse o menu Funções, clique na função desejada, clique em Excluir Função e confirme."
                imagem="help\roles\delete_roles.PNG"
            />
        </div>
    </div>

</x-app-layout>
