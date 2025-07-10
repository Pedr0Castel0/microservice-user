# 👤 User Service - Microserviço de Usuários

Microserviço Laravel 12 dedicado ao gerenciamento de usuários, desenvolvido em PHP 8.2. Parte de uma arquitetura de microserviços para aplicações distribuídas.

## 🚀 Instalação e Configuração

**Instalando as dependências:**

```bash
composer install
```

**Configurando o ambiente:**

```bash
cp .env.example .env
php artisan key:generate
```

**Configurando o banco PostgreSQL no .env:**

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=user_service
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

**Rodando o serviço localmente:**

```bash
php artisan migrate
php artisan serve
```

**Executando os testes:**

```bash
php artisan test
```

**Observação:** Caso deseje importar os requests no seu Insomnia, utilize o arquivo `user-service-requests.json`

---

## 🔐 Autenticação

### `POST /api/register`

Registra um novo usuário na plataforma.

**Requisição:**

```json
{
    "name": "João Silva",
    "email": "joao@example.com",
    "password": "senha123",
    "password_confirmation": "senha123"
}
```

**Resposta:**

```json
{
    "message": "Usuário cadastrado com sucesso",
    "user": {
        "id": 1,
        "name": "João Silva",
        "email": "joao@example.com",
        "email_verified_at": null,
        "created_at": "2025-01-07T10:30:00.000000Z",
        "updated_at": "2025-01-07T10:30:00.000000Z"
    },
    "token": "1|eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "Bearer"
}
```

---

### `POST /api/login`

Autentica o usuário e retorna um token de acesso.

**Requisição:**

```json
{
    "email": "joao@example.com",
    "password": "senha123"
}
```

**Resposta:**

```json
{
    "message": "Login realizado com sucesso",
    "user": {
        "id": 1,
        "name": "João Silva",
        "email": "joao@example.com",
        "email_verified_at": null,
        "created_at": "2025-01-07T10:30:00.000000Z",
        "updated_at": "2025-01-07T10:30:00.000000Z"
    },
    "token": "1|eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "Bearer"
}
```

---

### `POST /api/logout`

Desloga o usuário e invalida o token atual.

**Headers:**

```
Authorization: Bearer {token}
```

**Resposta:**

```json
{
    "message": "Logout realizado com sucesso"
}
```

---

### `GET /api/user`

Retorna os dados do usuário autenticado.

**Headers:**

```
Authorization: Bearer {token}
```

**Resposta:**

```json
{
    "user": {
        "id": 1,
        "name": "João Silva",
        "email": "joao@example.com",
        "email_verified_at": null,
        "created_at": "2025-01-07T10:30:00.000000Z",
        "updated_at": "2025-01-07T10:30:00.000000Z"
    }
}
```

---

## 🛠️ Comandos de Desenvolvimento

**Servidor de desenvolvimento:**

```bash
php artisan serve
```

**Executar migrações:**

```bash
php artisan migrate
```

**Executar testes:**

```bash
php artisan test
```

**Desenvolvimento completo:**

```bash
composer run dev
```

**Verificar código:**

```bash
./vendor/bin/pint
```

---

## 🏗️ Tecnologias

-   **Framework**: Laravel 12.x
-   **PHP**: ^8.2
-   **Banco de dados**: PostgreSQL
-   **Autenticação**: Laravel Sanctum
-   **Testes**: PHPUnit 11.x
-   **Ferramentas**: Laravel Pint, Pail, Sail

## 📝 Licença

Este projeto está licenciado sob a licença MIT.
