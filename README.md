<div align="center">
  <img src="public/images/logo.svg" alt="Logo da Plataforma Digital Libras+" width="150">
  <h1>Plataforma Digital Libras+</h1>
  <p>Repositório multidisciplinar de sinais em Libras para consulta e catalogação.</p>
</div>

## Sobre o projeto

A plataforma reúne sinais associados a categorias e oferece busca, catálogo e páginas de detalhe com vídeo, imagens, definição e características do sinal. A área administrativa permite gerenciar sinais, categorias, materiais, usuários, funções e permissões, contatos e registros de atividade.

### Tecnologias e requisitos

| Componente | Requisito |
| --- | --- |
| Backend | PHP 8.2 ou superior, Laravel 12 e Composer |
| Banco de dados | MySQL ou outro banco configurado e suportado pelo Laravel; o exemplo de produção usa MySQL |
| Frontend | Node.js 20.19+ ou 22.12+, npm, Vite 7, Tailwind CSS 3 e Alpine.js 3 |
| Servidor web | Nginx ou Apache com a raiz do site apontando para `public/`; para Nginx, use PHP-FPM |
| Extensões PHP | PDO do banco escolhido, mbstring, OpenSSL, XML, ctype, fileinfo e zip; confira também com `composer check-platform-reqs --no-dev` |
| Serviços | SMTP para convites, respostas a contatos e recuperação de senha; processo de fila quando usar `QUEUE_CONNECTION=database` |

Os arquivos enviados são guardados em `storage/app/public`. A prévia de materiais aceita PDF e extrai conteúdo de TXT, DOCX, XLSX, PPTX e formatos OpenDocument; arquivos Office antigos podem ser baixados. O sistema usa autenticação do Laravel Breeze e permissões do Spatie.

## Instalação para desenvolvimento

1. Clone o repositório e entre na pasta do projeto.
2. Instale as dependências e crie o arquivo de ambiente:

   ```bash
   composer install
   npm ci
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure `APP_URL`, banco de dados e e-mail no `.env`. O `DB_HOST=db` do exemplo pressupõe um serviço chamado `db`; altere-o para o endereço do seu banco. Para desenvolvimento local em HTTP, use `APP_ENV=local`, `APP_DEBUG=true`, `APP_URL=http://localhost:8000` e `SESSION_SECURE_COOKIE=false`.
4. Prepare o banco, os arquivos públicos e os assets:

   ```bash
   php artisan migrate
   php artisan db:seed --class=PermissionSeeder
   php artisan db:seed --class=RoleSeeder
   php artisan db:seed --class=CategoriaSeeder
   php artisan storage:link
   npm run build
   ```

5. Para desenvolvimento, execute `composer run dev`. Esse script inicia o servidor Laravel, a fila e o Vite.

Para gerar 200 sinais **fictícios** em um ambiente de teste, execute `php artisan db:seed --class=SinalSeeder`. Esse seeder não faz parte da carga inicial de produção.

## Publicação em produção

O repositório não inclui configuração de Docker Compose. Os passos abaixo consideram um servidor Linux com Nginx, PHP-FPM e MySQL; adapte caminhos, usuário do serviço web e versão do socket PHP à sua infraestrutura.

1. **Prepare os serviços.** Instale PHP 8.2+, extensões necessárias, Composer, Node.js/npm, MySQL, Nginx e PHP-FPM. Crie um banco e um usuário próprios para a aplicação. Configure HTTPS no servidor web ou proxy reverso.

2. **Envie o código e instale as dependências.** No diretório da aplicação:

   ```bash
   composer install --no-dev --prefer-dist --optimize-autoloader
   composer check-platform-reqs --no-dev
   npm ci
   npm run build
   cp .env.example .env
   ```

   Se o `.env` já existir em uma atualização, preserve-o. O build gera `public/build`; Node.js não precisa permanecer no servidor se os assets forem gerados antes da publicação.

3. **Configure o `.env`.** Defina, no mínimo:

   ```dotenv
   APP_NAME="Plataforma Digital Libras+"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://seu-dominio.example
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nome_do_banco
   DB_USERNAME=usuario_da_aplicacao
   DB_PASSWORD=senha_forte
   SESSION_SECURE_COOKIE=true
   QUEUE_CONNECTION=database
   MAIL_MAILER=smtp
   MAIL_HOST=servidor_smtp
   MAIL_PORT=587
   MAIL_USERNAME=usuario_smtp
   MAIL_PASSWORD=senha_smtp
   MAIL_FROM_ADDRESS=contato@seu-dominio.example
   ```

   Use valores reais e mantenha o `.env` fora do controle de versão. A pasta `storage/app/public` precisa ser persistente entre publicações. Configure `upload_max_filesize` e `post_max_size` no PHP e o limite de upload do Nginx de acordo com os arquivos aceitos pelo sistema.

4. **Inicialize a aplicação e o banco.**

   ```bash
   php artisan key:generate
   php artisan migrate --force
   php artisan db:seed --class=PermissionSeeder --force
   php artisan db:seed --class=RoleSeeder --force
   php artisan db:seed --class=CategoriaSeeder --force
   php artisan db:seed --class=UserSeeder --force
   php artisan storage:link
   php artisan optimize
   ```

   Gere `APP_KEY` somente na primeira implantação. Em atualizações, mantenha a chave existente. Os três seeders acima são para a **carga inicial**; não os execute novamente sem verificar os dados existentes, pois permissões e funções usam criação direta.

5. **Aponte o servidor web para `public/`.** Exemplo mínimo de Nginx; ajuste domínio, caminho e socket PHP:

   ```nginx
   server {
       listen 80;
       server_name seu-dominio.example;
       root /var/www/librasmais/public;
       index index.php;
       client_max_body_size 25M;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           include fastcgi_params;
           fastcgi_pass unix:/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
       }
   }
   ```

   Habilite HTTPS no Nginx ou no proxy reverso. Garanta permissão de escrita ao usuário do PHP-FPM em `storage/` e `bootstrap/cache/`. O diretório `public/storage` deve apontar para `storage/app/public`.

6. **Mantenha a fila ativa.** Com `QUEUE_CONNECTION=database`, execute `php artisan queue:work --sleep=3 --tries=3 --max-time=3600` por um gerenciador de processos, como systemd ou Supervisor, com reinício automático. Após cada publicação, execute `php artisan queue:restart`.

7. **Verifique a instalação.** Acesse a página inicial, `/admin/login`, faça login, teste uma busca, um upload e o envio de e-mail. Confira os logs em `storage/logs`. Faça backup regular do banco e de `storage/app/public`.

### Atualizações posteriores

Faça backup, publique o novo código e rode:

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan optimize
php artisan queue:restart
```

Preserve o `.env`, a chave da aplicação, o banco e os arquivos de `storage/app/public`.

## Desenvolvimento

Projeto desenvolvido por **Matheus de Sousa Barbosa** e **Caio Luis Silva Macedo**.
