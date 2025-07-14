# 🌮 El Sombrero - Microserviço de Restaurante Mexicano

Microserviço Laravel 12 completo para gestão de restaurante mexicano, desenvolvido em PHP 8.2. Sistema integrado para gerenciamento de usuários, catálogo de pratos tradicionais e processamento de pedidos com pagamento na entrega.

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
DB_DATABASE=el_sombrero_restaurant
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

**Observação:** Caso deseje importar os requests no seu Insomnia, utilize o arquivo `el-sombrero-requests.json`

---

## 🔐 Autenticação de Usuários

### `POST /api/register`

Registra um novo cliente no restaurante.

**Requisição:**

```json
{
    "name": "Maria García",
    "email": "maria@example.com",
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
        "name": "Maria García",
        "email": "maria@example.com",
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

Autentica o cliente e retorna um token de acesso.

**Requisição:**

```json
{
    "email": "maria@example.com",
    "password": "senha123"
}
```

**Resposta:**

```json
{
    "message": "Login realizado com sucesso",
    "user": {
        "id": 1,
        "name": "Maria García",
        "email": "maria@example.com",
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

Desloga o cliente e invalida o token atual.

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

Retorna os dados do cliente autenticado.

**Headers:**

```
Authorization: Bearer {token}
```

**Resposta:**

```json
{
    "user": {
        "id": 1,
        "name": "Maria García",
        "email": "maria@example.com",
        "email_verified_at": null,
        "created_at": "2025-01-07T10:30:00.000000Z",
        "updated_at": "2025-01-07T10:30:00.000000Z"
    }
}
```

---

## 🍽️ Catálogo de Pratos

### `GET /api/categories`

Lista todas as categorias de pratos mexicanos disponíveis.

**Resposta:**

```json
{
    "categories": [
        {
            "id": 1,
            "name": "Tacos",
            "description": "Tortillas com diversos recheios tradicionais",
            "image_url": "/images/categories/tacos.jpg",
            "created_at": "2025-01-07T10:30:00.000000Z"
        },
        {
            "id": 2,
            "name": "Burritos",
            "description": "Tortillas grandes recheadas e enroladas",
            "image_url": "/images/categories/burritos.jpg",
            "created_at": "2025-01-07T10:30:00.000000Z"
        }
    ]
}
```

---

### `GET /api/categories/{id}/dishes`

Lista todos os pratos de uma categoria específica.

**Resposta:**

```json
{
    "category": {
        "id": 1,
        "name": "Tacos",
        "description": "Tortillas com diversos recheios tradicionais"
    },
    "dishes": [
        {
            "id": 1,
            "name": "Taco al Pastor",
            "description": "Carne de porco marinada com abacaxi e especiarias",
            "price": 15.90,
            "image_url": "/images/dishes/taco-al-pastor.jpg",
            "is_available": true,
            "ingredients": ["Carne de porco", "Abacaxi", "Cebola", "Coentro"],
            "spice_level": "Médio"
        }
    ]
}
```

---

### `GET /api/dishes`

Lista todos os pratos disponíveis no cardápio.

**Query Parameters:**
- `category_id` (opcional): Filtrar por categoria
- `search` (opcional): Buscar por nome ou ingredientes
- `available` (opcional): Filtrar apenas pratos disponíveis

**Resposta:**

```json
{
    "dishes": [
        {
            "id": 1,
            "name": "Taco al Pastor",
            "description": "Carne de porco marinada com abacaxi e especiarias",
            "price": 15.90,
            "category": "Tacos",
            "image_url": "/images/dishes/taco-al-pastor.jpg",
            "is_available": true,
            "ingredients": ["Carne de porco", "Abacaxi", "Cebola", "Coentro"],
            "spice_level": "Médio"
        }
    ]
}
```

---

### `GET /api/dishes/{id}`

Retorna detalhes completos de um prato específico.

**Resposta:**

```json
{
    "dish": {
        "id": 1,
        "name": "Taco al Pastor",
        "description": "Carne de porco marinada com abacaxi e especiarias mexicanas, servida em tortilla de milho fresca com cebola roxa e coentro",
        "price": 15.90,
        "category": {
            "id": 1,
            "name": "Tacos"
        },
        "image_url": "/images/dishes/taco-al-pastor.jpg",
        "is_available": true,
        "ingredients": ["Carne de porco", "Abacaxi", "Cebola roxa", "Coentro", "Tortilla de milho"],
        "allergens": ["Glúten"],
        "spice_level": "Médio",
        "preparation_time": "15 minutos",
        "nutritional_info": {
            "calories": 280,
            "protein": "18g",
            "carbs": "22g",
            "fat": "12g"
        }
    }
}
```

---

## 🛒 Sistema de Pedidos

### `POST /api/orders`

Cria um novo pedido com pagamento na entrega.

**Headers:**

```
Authorization: Bearer {token}
```

**Requisição:**

```json
{
    "items": [
        {
            "dish_id": 1,
            "quantity": 2,
            "special_instructions": "Sem cebola, por favor"
        },
        {
            "dish_id": 3,
            "quantity": 1
        }
    ],
    "delivery_address": {
        "street": "Rua das Flores, 123",
        "neighborhood": "Centro",
        "city": "São Paulo",
        "zipcode": "01234-567",
        "reference": "Próximo ao mercado"
    },
    "payment_method": "dinheiro",
    "observations": "Entregar no portão azul"
}
```

**Resposta:**

```json
{
    "message": "Pedido criado com sucesso",
    "order": {
        "id": 1,
        "order_number": "ELS-2025-001",
        "status": "confirmado",
        "total_amount": 47.70,
        "payment_method": "dinheiro",
        "estimated_delivery_time": "45 minutos",
        "delivery_address": {
            "street": "Rua das Flores, 123",
            "neighborhood": "Centro",
            "city": "São Paulo",
            "zipcode": "01234-567"
        },
        "items": [
            {
                "dish_name": "Taco al Pastor",
                "quantity": 2,
                "unit_price": 15.90,
                "subtotal": 31.80,
                "special_instructions": "Sem cebola, por favor"
            }
        ],
        "created_at": "2025-01-07T10:30:00.000000Z"
    }
}
```

---

### `GET /api/orders`

Lista todos os pedidos do cliente autenticado.

**Headers:**

```
Authorization: Bearer {token}
```

**Resposta:**

```json
{
    "orders": [
        {
            "id": 1,
            "order_number": "ELS-2025-001",
            "status": "entregue",
            "total_amount": 47.70,
            "created_at": "2025-01-07T10:30:00.000000Z",
            "estimated_delivery_time": "45 minutos"
        }
    ]
}
```

---

### `GET /api/orders/{id}`

Retorna detalhes completos de um pedido específico.

**Headers:**

```
Authorization: Bearer {token}
```

**Resposta:**

```json
{
    "order": {
        "id": 1,
        "order_number": "ELS-2025-001",
        "status": "em_preparo",
        "total_amount": 47.70,
        "payment_method": "dinheiro",
        "payment_status": "pendente",
        "estimated_delivery_time": "45 minutos",
        "delivery_address": {
            "street": "Rua das Flores, 123",
            "neighborhood": "Centro",
            "city": "São Paulo",
            "zipcode": "01234-567",
            "reference": "Próximo ao mercado"
        },
        "items": [
            {
                "dish_name": "Taco al Pastor",
                "quantity": 2,
                "unit_price": 15.90,
                "subtotal": 31.80,
                "special_instructions": "Sem cebola, por favor"
            }
        ],
        "tracking": [
            {
                "status": "confirmado",
                "timestamp": "2025-01-07T10:30:00.000000Z"
            },
            {
                "status": "em_preparo",
                "timestamp": "2025-01-07T10:35:00.000000Z"
            }
        ]
    }
}
```

---

## 💰 Sistema de Pagamento

### Métodos de Pagamento Aceitos

- **Dinheiro**: Pagamento realizado na entrega
- **PIX**: Chave PIX fornecida no momento da entrega
- **Cartão de Débito**: Maquininha na entrega
- **Cartão de Crédito**: Maquininha na entrega

### `GET /api/payment-methods`

Lista os métodos de pagamento disponíveis.

**Resposta:**

```json
{
    "payment_methods": [
        {
            "id": "dinheiro",
            "name": "Dinheiro",
            "description": "Pagamento em espécie na entrega",
            "requires_change": true
        },
        {
            "id": "pix",
            "name": "PIX",
            "description": "Transferência instantânea via PIX",
            "requires_change": false
        },
        {
            "id": "cartao_debito",
            "name": "Cartão de Débito",
            "description": "Pagamento com cartão de débito",
            "requires_change": false
        },
        {
            "id": "cartao_credito",
            "name": "Cartão de Crédito",
            "description": "Pagamento com cartão de crédito",
            "requires_change": false
        }
    ]
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

**Popular banco com dados de exemplo:**

```bash
php artisan db:seed
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

## 🌮 Funcionalidades

### ✅ Implementações
- Sistema completo de autenticação de usuários
- Gestão de categorias de pratos mexicanos
- Catálogo completo de pratos tradicionais
- Sistema de pedidos com entrega
- Múltiplos métodos de pagamento na entrega
- API RESTful completa


## 📝 Licença

Este projeto está licenciado sob a licença MIT.
