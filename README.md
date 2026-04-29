# Sistema de Ponto - Laravel Monolito com Docker

Projeto de sistema de ponto desenvolvido em **Laravel**, utilizando uma arquitetura monolítica moderna e ambiente Docker para facilitar a instalação e execução em qualquer máquina.

---

## Tecnologias utilizadas

- PHP 8.4
- Laravel
- PostgreSQL 16
- Redis
- Nginx
- Docker
- Docker Compose
- Mailpit
- Composer
- Vite
- Blade
- Tailwind CSS
- Alpine.js

---

## Estrutura inicial do projeto

```bash
sistema-ponto-laravel/
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   └── php/
│       └── Dockerfile
├── src/
├── docker-compose.yml
└── README.md
```

A pasta `src/` é onde fica o projeto Laravel.

---

## Pré-requisitos

Antes de iniciar, instale:

- Docker
- Docker Compose
- Git

Para verificar se está tudo instalado:

```bash
docker --version
docker compose version
git --version
```

---

## 1. Clonar o projeto

```bash
git clone <url-do-repositorio>
cd sistema-ponto-laravel
```

Caso ainda esteja criando o projeto localmente, basta entrar na pasta:

```bash
cd sistema-ponto-laravel
```

---

## 2. Subir os containers

Na raiz do projeto, execute:

```bash
docker compose up -d --build
```

Esse comando irá criar e iniciar os containers:

- `ponto_app`: aplicação PHP/Laravel
- `ponto_nginx`: servidor web Nginx
- `ponto_postgres`: banco PostgreSQL
- `ponto_redis`: cache/fila
- `ponto_mailpit`: servidor de e-mail local para testes

---

## 3. Criar o projeto Laravel

Se a pasta `src/` ainda estiver vazia, rode:

```bash
docker compose exec app composer create-project laravel/laravel .
```

Esse comando deve ser executado dentro do container `app`, já apontando para `/var/www/html`.

---

## 4. Configurar o arquivo `.env`

Entre na pasta `src/`:

```bash
cd src
```

Se o arquivo `.env` ainda não existir, copie o exemplo:

```bash
cp .env.example .env
```

Agora ajuste as configurações principais:

```env
APP_NAME="Sistema de Ponto"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=ponto_db
DB_USERNAME=ponto_user
DB_PASSWORD=ponto_password

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="sistema@ponto.local"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 5. Gerar a chave da aplicação

Volte para a raiz do projeto, se estiver dentro da pasta `src`:

```bash
cd ..
```

Execute:

```bash
docker compose exec app php artisan key:generate
```

---

## 6. Limpar cache de configuração

Sempre que alterar o `.env`, rode:

```bash
docker compose exec app php artisan optimize:clear
```

ou:

```bash
docker compose exec app php artisan config:clear
```

---

## 7. Rodar as migrations

Para criar as tabelas no banco:

```bash
docker compose exec app php artisan migrate
```

Se quiser recriar o banco do zero:

```bash
docker compose exec app php artisan migrate:fresh
```

---

## 8. Acessar o sistema

Após subir os containers, acesse no navegador:

```txt
http://localhost:8080
```

Se tudo estiver correto, a tela inicial do Laravel será exibida.

---

## 9. Acessar o Mailpit

O Mailpit é usado para visualizar e-mails enviados localmente pela aplicação.

Acesse:

```txt
http://localhost:8025
```

---

## Comandos úteis

### Subir containers

```bash
docker compose up -d
```

### Subir containers recriando imagens

```bash
docker compose up -d --build
```

### Parar containers

```bash
docker compose down
```

### Ver containers rodando

```bash
docker compose ps
```

### Ver logs

```bash
docker compose logs -f
```

### Ver logs apenas do app

```bash
docker compose logs -f app
```

### Acessar o container da aplicação

```bash
docker compose exec app bash
```

### Rodar comandos Artisan

```bash
docker compose exec app php artisan nome:do-comando
```

Exemplo:

```bash
docker compose exec app php artisan route:list
```

### Rodar Composer

```bash
docker compose exec app composer install
```

### Rodar NPM

```bash
docker compose exec app npm install
```

```bash
docker compose exec app npm run dev
```

---

## Banco de dados

Dados de conexão local:

```txt
Host: localhost
Porta: 5432
Banco: ponto_db
Usuário: ponto_user
Senha: ponto_password
```

Dentro do Laravel, o host deve ser:

```txt
postgres
```

Isso acontece porque o Laravel acessa o banco de dentro da rede Docker.

---

## Problemas comuns

### Erro de conexão com banco

Verifique se o container do PostgreSQL está rodando:

```bash
docker compose ps
```

Verifique também se o `.env` está assim:

```env
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=ponto_db
DB_USERNAME=ponto_user
DB_PASSWORD=ponto_password
```

Depois rode:

```bash
docker compose exec app php artisan optimize:clear
```

---

### Erro de permissão em storage ou cache

Execute:

```bash
docker compose exec app chmod -R 775 storage bootstrap/cache
```

---

### Alterei o `.env`, mas não funcionou

Rode:

```bash
docker compose exec app php artisan optimize:clear
```

---

### A porta 8080 já está em uso

Altere no `docker-compose.yml`:

```yaml
ports:
  - "8081:80"
```

Depois acesse:

```txt
http://localhost:8081
```

---

## Próximos passos do projeto

Após a base Docker estar funcionando, os próximos passos são:

1. Instalar Laravel Breeze
2. Configurar autenticação
3. Traduzir telas e validações para português
4. Criar estrutura de usuários e permissões
5. Criar módulo de registro de ponto
6. Criar tabela de batidas de ponto
7. Criar cálculo de jornada diária
8. Criar relatórios por período
9. Criar área administrativa
10. Criar exportação em PDF ou Excel

---

## Padrão recomendado para desenvolvimento

Este projeto seguirá uma organização simples e limpa:

```txt
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
├── Services/
└── Policies/
```

Exemplo:

- Controllers recebem a requisição
- Form Requests validam os dados
- Services concentram regras de negócio
- Models representam as tabelas
- Policies controlam permissões

---

## Observação

Este projeto está sendo migrado de um sistema antigo em PHP puro com JavaScript para um monólito Laravel moderno, mantendo o foco em simplicidade, organização e facilidade de manutenção.
