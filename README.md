# Teste Técnico - Form Builder com Laravel + Filament

## Visão geral

Este projeto é uma aplicação de construção e resposta de formulários dinâmica usando **Laravel** no backend, **Filament** como painel administrativo e **PostgreSQL** como banco principal. Este README descreve toda a configuração feita até o momento no ambiente Windows, incluindo PHP, Composer, PostgreSQL, Filament e Node.js.

---

## Pré-requisitos

- PHP 8.1+ (instalado manualmente no Windows)
- Composer
- PostgreSQL (com pgAdmin 4 para administração)
- Node.js ≥ 18 (idealmente 20) — necessário para `vite`/frontend
- Git (opcional)
- SQLite (opcional, para fallback)

---

## 1. Instalação e configuração do PHP no Windows

### 1.1. Download e extração

- Baixe uma versão **Thread Safe** do PHP 8.1+ em https://windows.php.net/download  
- Descompacte em, por exemplo: `C:\php`

### 1.2. Configurar o `php.ini`

Dentro de `C:\php`:

```powershell
Copy-Item php.ini-development php.ini
```

Edite `C:\php\php.ini` e faça os ajustes principais:

```ini
; definir diretório de extensões
extension_dir = "C:\php\ext"

; timezone
date.timezone = "America/Sao_Paulo"

; memória (útil para CLI / Composer)
memory_limit = 512M

; habilitar extensões necessárias
extension=bz2
extension=curl
extension=fileinfo
extension=gd
extension=mbstring
extension=exif           ; deve vir depois de mbstring
extension=mysqli
extension=openssl
extension=pdo_pgsql      ; PostgreSQL
extension=pgsql          ; PostgreSQL
extension=intl           ; internacionalização necessária para Filament
extension=sockets
extension=zip
```

Salve o arquivo.

### 1.3. Adicionar PHP ao PATH

1. Abra **Variáveis de Ambiente** no Windows.  
2. Edite a variável `Path` e adicione: `C:\php`  
3. Feche e reabra o terminal.

---

## 2. Instalando o Composer

1. Baixe e execute o instalador oficial `Composer-Setup.exe`.  
2. Abra novo terminal e confirme:

```sh
composer --version
```

---

## 3. Configuração do PostgreSQL (via pgAdmin 4)

Abra o pgAdmin e rode o script abaixo para criar usuário e banco:

```sql
-- 1. Cria role com login e senha
CREATE ROLE form_user WITH LOGIN PASSWORD 't35t34ct0';

-- 2. Cria o banco de dados com owner = form_user
CREATE DATABASE acto_form_builder
  WITH 
    OWNER = form_user
    ENCODING = 'UTF8'
    TEMPLATE = template0;

-- 3. Garante privilégios (redundante por ser owner, mas seguro)
GRANT ALL PRIVILEGES ON DATABASE acto_form_builder TO form_user;
```

---

## 4. Configuração do projeto Laravel

### 4.1. Exemplo de `.env` para PostgreSQL

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=acto_form_builder
DB_USERNAME=form_user
DB_PASSWORD=t35t34ct0

SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### 4.2. Instalar dependências e preparar

```sh
composer install
php artisan key:generate
php artisan config:clear
php artisan cache:clear
php artisan migrate
```

---

## 5. Instalação do Filament

### 5.1. Compatibilidade Filament x Laravel

- **Laravel 10/11** → instale Filament 3.x:
  ```sh
  composer require filament/filament:^3.3
  ```

### 5.2. Rodar instalador do Filament

```sh
php artisan filament:install --forms
```

### 5.3. Criar usuário admin do Filament

```sh
php artisan make:filament-user
```

---

## 6. Frontend / Node.js

O projeto usa **Vite**, que exige Node moderno.
Recomenda-se usar **Node.js ≥18**, idealmente LTS 20:

---

## 7. Executando a aplicação

```sh
php artisan serve
```

Acesse `http://127.0.0.1:8000`.  
Painel admin do Filament em `/admin`.

---

## 8. Comandos úteis resumidos

```sh
# PHP / ambiente
php --ini
php -v
php -m

# Laravel
composer install
php artisan key:generate
php artisan migrate
php artisan config:clear
php artisan cache:clear

# Filament
composer require filament/filament:^3.3
php artisan filament:install --forms
php artisan make:filament-user

# Frontend
nvm install 20.9.0
nvm use 20.9.0
npm install
npm run dev
```

---

## 9. Troubleshooting

### `php` não é reconhecido
- Adicione `C:\php` ao `PATH` e reabra o terminal.

### `could not find driver`
- Habilite `extension=pdo_pgsql` e `extension=pgsql` no `php.ini`.

### `ext-intl` missing no Composer
- Habilite `extension=intl` no `php.ini` e confirme com `php -m`.

### Conflitos de versão do Filament
- Garanta que está usando a versão de Filament compatível com a versão do Laravel.

### Erro `crypto.getRandomValues is not a function`
- Atualize Node para ≥18.

---

## 10. Observações finais

- `.env` **não deve ser versionado**. Use `.env.example` com placeholders.

---

## 11. Papéis e Permissões

A aplicação distingue dois tipos de usuários com capacidades diferentes:

### Admin
- Pode gerenciar tudo: criar/editar/excluir formulários, perguntas e alternativas (exclusão lógica), ver todas as respostas históricas, gerenciar usuários e roles.
- Atribuído via role `admin`.

### Responder
- Só pode responder formulários ativos e visualizar as respostas (por exemplo, as próprias ou conforme definidas pelas regras de negócio).
- Não tem acesso ao CRUD de formulários, perguntas ou alternativas.
- Atribuído via role `responder`.