<x-app-layout>
    @php
        $sections = [
            [
                'title' => 'Sinais',
                'description' => 'Cadastre, edite, restaure e gerencie os sinais do repositório.',
                'icon' => 'ph-hand-waving',
                'color' => 'text-brand-600',
                'bg' => 'bg-brand-100',
                'items' => [
                    ['permissao' => 'create_sinais', 'titulo' => 'Criar Sinal', 'descricao' => 'Acesse Sinais, clique em Novo Sinal, preencha os dados e clique em Criar Sinal.', 'imagem' => 'help/sinais/create_sinal.PNG'],
                    ['permissao' => 'edit_sinais', 'titulo' => 'Editar Sinal', 'descricao' => 'Acesse Sinais, abra o sinal desejado, faça as alterações e clique em Atualizar Sinal.', 'imagem' => 'help/sinais/edit_sinal.PNG'],
                    ['permissao' => 'delete_sinais', 'titulo' => 'Excluir Sinal', 'descricao' => 'Abra o sinal desejado, clique em Excluir Sinal e confirme a ação.', 'imagem' => 'help/sinais/delete_sinal.PNG'],
                    ['permissao' => 'restore_sinais', 'titulo' => 'Acessar Sinais Deletados', 'descricao' => 'Use o filtro de Sinais e selecione Apenas Sinais Deletados.', 'imagem' => 'help/sinais/filtro_sinais.PNG'],
                    ['permissao' => 'restore_sinais', 'titulo' => 'Restaurar Sinais Deletados', 'descricao' => 'Filtre por sinais deletados, encontre o sinal e clique no ícone Restaurar.', 'imagem' => 'help/sinais/restore_sinais.PNG'],
                    ['permissao' => 'force_delete_sinais', 'titulo' => 'Deletar Permanentemente um Sinal', 'descricao' => 'Filtre por sinais deletados, abra o item e confirme a exclusão permanente.', 'imagem' => 'help/sinais/force_delete_sinais.PNG'],
                ],
            ],
            [
                'title' => 'Categorias',
                'description' => 'Organize os sinais por áreas do conhecimento.',
                'icon' => 'ph-folders',
                'color' => 'text-logo-green',
                'bg' => 'bg-green-100',
                'items' => [
                    ['permissao' => 'create_categorias', 'titulo' => 'Criar Categoria', 'descricao' => 'Acesse Categorias, clique em Nova Categoria, preencha os dados e salve.', 'imagem' => 'help/categorias/create_categoria.PNG'],
                    ['permissao' => 'edit_categorias', 'titulo' => 'Editar Categoria', 'descricao' => 'Abra a categoria desejada, faça as alterações e clique em Atualizar Categoria.', 'imagem' => 'help/categorias/edit_categoria.PNG'],
                    ['permissao' => 'delete_categorias', 'titulo' => 'Excluir Categoria', 'descricao' => 'Abra a categoria desejada, clique em Excluir Categoria e confirme.', 'imagem' => 'help/categorias/delete_categoria.PNG'],
                    ['permissao' => 'restore_categorias', 'titulo' => 'Acessar Categorias Deletadas', 'descricao' => 'Use o filtro e selecione Apenas Categorias Deletadas.', 'imagem' => 'help/categorias/filtro_categorias.PNG'],
                    ['permissao' => 'restore_categorias', 'titulo' => 'Restaurar Categorias Deletadas', 'descricao' => 'Filtre por categorias deletadas e clique no ícone Restaurar.', 'imagem' => 'help/categorias/restore_categorias.PNG'],
                    ['permissao' => 'force_delete_categorias', 'titulo' => 'Deletar Permanentemente uma Categoria', 'descricao' => 'Filtre por categorias deletadas, abra a categoria e confirme a exclusão permanente.', 'imagem' => 'help/categorias/force_delete_categorias.PNG'],
                ],
            ],
            [
                'title' => 'Materiais',
                'description' => 'Gerencie arquivos, produções e recursos complementares.',
                'icon' => 'ph-file-text',
                'color' => 'text-logo-orange',
                'bg' => 'bg-orange-100',
                'items' => [
                    ['permissao' => 'create_materiais', 'titulo' => 'Criar Material', 'descricao' => 'Acesse Materiais, clique em Novo Material, preencha os dados e salve.', 'imagem' => 'help/materiais/create_material.PNG'],
                    ['permissao' => 'edit_materiais', 'titulo' => 'Editar Material', 'descricao' => 'Abra o material desejado, faça as alterações e clique em Atualizar Material.', 'imagem' => 'help/materiais/edit_material.PNG'],
                    ['permissao' => 'view_materiais', 'titulo' => 'Baixar Material', 'descricao' => 'Abra o material desejado e clique no ícone de download.', 'imagem' => 'help/materiais/download_material.PNG'],
                    ['permissao' => 'delete_materiais', 'titulo' => 'Excluir Material', 'descricao' => 'Abra o material desejado, clique em Excluir Material e confirme.', 'imagem' => 'help/materiais/delete_material.PNG'],
                    ['permissao' => 'delete_materiais', 'titulo' => 'Acessar Materiais Deletados', 'descricao' => 'Use o filtro e selecione Apenas Materiais Deletados.', 'imagem' => 'help/materiais/filtro_material.PNG'],
                    ['permissao' => 'restore_materiais', 'titulo' => 'Restaurar Materiais Deletados', 'descricao' => 'Filtre por materiais deletados e clique no ícone Restaurar.', 'imagem' => 'help/materiais/restore_material.PNG'],
                    ['permissao' => 'force_delete_materiais', 'titulo' => 'Deletar Permanentemente um Material', 'descricao' => 'Filtre por materiais deletados, abra o item e confirme a exclusão permanente.', 'imagem' => 'help/materiais/force_delete_material.PNG'],
                ],
            ],
            [
                'title' => 'Usuários e Permissões',
                'description' => 'Administre acessos, funções e permissões do sistema.',
                'icon' => 'ph-users',
                'color' => 'text-logo-pink',
                'bg' => 'bg-pink-100',
                'items' => [
                    ['permissao' => 'create_users', 'titulo' => 'Criar Usuários', 'descricao' => 'Acesse Usuários, clique em Novo Usuário, preencha os dados e salve.', 'imagem' => 'help/usuarios/create_usuario.PNG'],
                    ['permissao' => 'edit_users', 'titulo' => 'Editar Usuários', 'descricao' => 'Abra o usuário desejado, faça as alterações e clique em Atualizar Usuário.', 'imagem' => 'help/usuarios/edit_usuario.PNG'],
                    ['permissao' => 'delete_users', 'titulo' => 'Excluir Usuários', 'descricao' => 'Abra o usuário desejado, clique em Excluir Usuário e confirme.', 'imagem' => 'help/usuarios/delete_usuario.PNG'],
                    ['permissao' => 'create_roles', 'titulo' => 'Criar Funções', 'descricao' => 'Acesse Funções, clique em Nova Função, preencha os dados e salve.', 'imagem' => 'help/roles/create_roles.PNG'],
                    ['permissao' => 'edit_roles', 'titulo' => 'Editar Funções', 'descricao' => 'Abra a função desejada, faça as alterações e clique em Atualizar Função.', 'imagem' => 'help/roles/edit_roles.PNG'],
                    ['permissao' => 'delete_roles', 'titulo' => 'Excluir Funções', 'descricao' => 'Abra a função desejada, clique em Excluir Função e confirme.', 'imagem' => 'help/roles/delete_roles.PNG'],
                    ['permissao' => 'view_permissions', 'titulo' => 'Visualizar Permissões', 'descricao' => 'Acesse Permissões para visualizar permissões disponíveis e suas descrições.', 'imagem' => 'help/permissions/view_permissions.PNG'],
                ],
            ],
            [
                'title' => 'Sistema e Perfil',
                'description' => 'Consulte logs e gerencie suas informações pessoais.',
                'icon' => 'ph-gear-six',
                'color' => 'text-logo-sky',
                'bg' => 'bg-brand-100',
                'items' => [
                    ['permissao' => 'view_logs', 'titulo' => 'Visualizar Logs', 'descricao' => 'Acesse Logs para filtrar registros por data, usuário e ação realizada.', 'imagem' => 'help/logs/view_logs.PNG'],
                    ['titulo' => 'Acessar Perfil', 'descricao' => 'Clique no seu nome no canto superior direito e selecione Perfil.', 'imagem' => 'help/profile/access_profile.PNG'],
                    ['titulo' => 'Editar Nome e Email', 'descricao' => 'Acesse Perfil, faça as alterações desejadas e clique em Salvar.', 'imagem' => 'help/profile/edit_name_profile.PNG'],
                    ['titulo' => 'Editar Senha', 'descricao' => 'Acesse Perfil, atualize sua senha e clique em Salvar.', 'imagem' => 'help/profile/edit_password_profile.PNG'],
                ],
            ],
        ];

        $sections = collect($sections)->map(function ($section) {
            $section['items'] = collect($section['items'])
                ->filter(fn ($item) => empty($item['permissao']) || auth()->user()->can($item['permissao']))
                ->values()
                ->all();

            return $section;
        })->filter(fn ($section) => count($section['items']) > 0)->values()->all();
    @endphp

    <div class="p-4 sm:p-6 lg:p-8" x-data="helpSearch(@js($sections))">
        <x-page-header
            title="Central de Ajuda"
            description="Tutoriais rápidos para as principais rotinas administrativas da Plataforma Digital Libras+." />

        <div class="mb-8 bg-white border border-brand-100 rounded-xl shadow-sm p-5">
            <label for="help-search" class="block text-sm font-semibold text-brand-800 mb-2">
                Pesquisar na central de ajuda
            </label>
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-brand-600 text-xl" aria-hidden="true"></i>
                <input id="help-search" x-ref="helpSearch" type="search" x-model.debounce.200ms="query"
                    placeholder="Ex.: criar sinal, restaurar categoria ou editar perfil"
                    class="w-full rounded-xl border-gray-300 bg-white py-3 pl-12 pr-12 text-gray-900 placeholder:text-gray-500 focus:border-logo-sky focus:ring-logo-sky">
                <button x-show="query" x-cloak type="button" @click="query = ''; $refs.helpSearch.focus()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 p-2 rounded-lg text-gray-500 hover:text-brand-700 hover:bg-brand-50"
                    aria-label="Limpar pesquisa">
                    <i class="ph ph-x" aria-hidden="true"></i>
                </button>
            </div>
            <p class="mt-2 text-sm text-gray-600" aria-live="polite">
                <span x-show="query"><strong x-text="resultCount"></strong> <span x-text="resultCount === 1 ? 'tutorial encontrado' : 'tutoriais encontrados'"></span></span>
                <span x-show="!query">Pesquise pelo nome da tarefa, descrição ou área administrativa.</span>
            </p>
        </div>

        <div class="space-y-8">
            @foreach ($sections as $section)
                <section x-show="sectionMatches(@js($section))" x-cloak
                    class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full {{ $section['bg'] }} flex items-center justify-center shrink-0">
                                <i class="ph {{ $section['icon'] }} {{ $section['color'] }} text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $section['title'] }}</h2>
                                <p class="text-sm text-gray-600 mt-1">{{ $section['description'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach ($section['items'] as $item)
                                <div x-show="itemMatches(@js($section), @js($item))" x-cloak>
                                    <x-help-card
                                        :titulo="$item['titulo']"
                                        :descricao="$item['descricao']"
                                        :imagem="$item['imagem']" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach

            <div x-show="query && resultCount === 0" x-cloak
                class="bg-white border border-gray-200 rounded-xl p-10 text-center">
                <span class="mx-auto mb-4 flex w-14 h-14 items-center justify-center rounded-full bg-brand-100">
                    <i class="ph ph-magnifying-glass text-brand-600 text-2xl"></i>
                </span>
                <h2 class="text-lg font-semibold text-gray-900">Nenhum tutorial encontrado</h2>
                <p class="mt-1 text-sm text-gray-600">Tente pesquisar com termos mais gerais.</p>
                <button type="button" @click="query = ''" class="mt-5 px-4 py-2 rounded-lg bg-brand-600 text-white hover:bg-brand-700">
                    Limpar pesquisa
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function helpSearch(sections) {
                return {
                    query: '',
                    sections,
                    normalize(value) {
                        return String(value ?? '')
                            .normalize('NFD')
                            .replace(/[\u0300-\u036f]/g, '')
                            .toLocaleLowerCase('pt-BR');
                    },
                    terms() {
                        return this.normalize(this.query).trim().split(/\s+/).filter(Boolean);
                    },
                    searchableText(section, item) {
                        return this.normalize(`${section.title} ${section.description} ${item.titulo} ${item.descricao}`);
                    },
                    itemMatches(section, item) {
                        const terms = this.terms();
                        return terms.length === 0 || terms.every(term => this.searchableText(section, item).includes(term));
                    },
                    sectionMatches(section) {
                        return section.items.some(item => this.itemMatches(section, item));
                    },
                    get resultCount() {
                        return this.sections.reduce((total, section) => {
                            return total + section.items.filter(item => this.itemMatches(section, item)).length;
                        }, 0);
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
