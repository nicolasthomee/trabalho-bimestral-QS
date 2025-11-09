# Sistema de Gerenciamento de Tarefas com Testes de Qualidade de Software

## Visão Geral

Este projeto implementa uma **API RESTful para gerenciamento de tarefas** desenvolvida com **Laravel 10** e **PHP 8.1**, com foco em **boas práticas de teste de software**. O sistema utiliza **Laravel Sanctum** para autenticação baseada em tokens e implementa diferentes níveis de teste usando **PHPUnit**.

## Funcionalidades Principais

### API de Tarefas

A API oferece os seguintes endpoints para gerenciamento de tarefas:

| Método | Endpoint | Descrição | Autenticação |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/tarefas` | Listar todas as tarefas do usuário autenticado | Requerida |
| `POST` | `/api/tarefas` | Criar uma nova tarefa | Requerida |
| `POST` | `/api/login` | Autenticar usuário e obter token | Não requerida |

### Autenticação com Laravel Sanctum

O sistema implementa autenticação segura utilizando **Laravel Sanctum**, que fornece:

*   Geração de tokens de API para autenticação stateless
*   Proteção de rotas com middleware `auth:sanctum`
*   Suporte a múltiplos tokens por usuário
*   Revogação de tokens

## Estrutura do Projeto

```
tarefas-project/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LoginController.php
│   │       └── TarefaController.php
│   └── Models/
│       ├── User.php
│       └── Tarefa.php
├── database/
│   ├── migrations/
│   │   └── 2025_11_09_221917_create_tarefas_table.php
│   ├── seeders/
│   │   └── UserSeeder.php
│   └── factories/
│       └── TarefaFactory.php
├── routes/
│   └── api.php
├── tests/
│   ├── Unit/
│   │   └── Unit/
│   │       ├── TarefaModelTest.php
│   │       ├── TarefaModelTest2.php
│   │       ├── UserModelTest.php
│   │       └── UserModelTest2.php
│   └── Feature/
│       ├── LoginTest.php
│       ├── TarefaControllerTest.php
│       ├── TarefaControllerTest2.php
│       └── ProtectedRouteTest.php
└── README.md
```

## Instalação e Configuração

### Pré-requisitos

*   PHP 8.1 ou superior
*   Composer
*   SQLite (ou outro banco de dados suportado)

### Passos de Instalação

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/[seu-usuario]/tarefas-project.git
   cd tarefas-project
   ```

2. **Instale as dependências:**
   ```bash
   composer install
   ```

3. **Configure o arquivo `.env`:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure o banco de dados** (SQLite):
   ```bash
   touch database/database.sqlite
   ```

5. **Execute as migrações:**
   ```bash
   php artisan migrate
   ```

6. **Popule o banco com dados de teste:**
   ```bash
   php artisan db:seed
   ```

## Uso da API

### 1. Autenticação (Login)

**Requisição:**
```bash
POST /api/login
Content-Type: application/json

{
    "email": "teste@exemplo.com",
    "password": "password"
}
```

**Resposta (200 OK):**
```json
{
    "message": "Login bem-sucedido",
    "token": "1|abcdefghijklmnopqrstuvwxyz...",
    "user": {
        "id": 1,
        "name": "Teste User",
        "email": "teste@exemplo.com"
    }
}
```

### 2. Listar Tarefas

**Requisição:**
```bash
GET /api/tarefas
Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz...
```

**Resposta (200 OK):**
```json
[
    {
        "id": 1,
        "user_id": 1,
        "titulo": "Comprar pão",
        "descricao": "Pão francês e integral",
        "concluida": false,
        "created_at": "2025-11-09T10:30:00.000000Z",
        "updated_at": "2025-11-09T10:30:00.000000Z"
    }
]
```

### 3. Criar Tarefa

**Requisição:**
```bash
POST /api/tarefas
Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz...
Content-Type: application/json

{
    "titulo": "Nova Tarefa",
    "descricao": "Descrição da tarefa",
    "concluida": false
}
```

**Resposta (201 Created):**
```json
{
    "id": 2,
    "user_id": 1,
    "titulo": "Nova Tarefa",
    "descricao": "Descrição da tarefa",
    "concluida": false,
    "created_at": "2025-11-09T10:35:00.000000Z",
    "updated_at": "2025-11-09T10:35:00.000000Z"
}
```

## Testes de Qualidade de Software

Este projeto implementa **4 níveis de testes** conforme os requisitos da disciplina de Qualidade de Software:

### 1. Testes Unitários (6 testes)

Os testes unitários focam no isolamento e validação da lógica de negócio das Models.

#### Testes da Model Tarefa:

*   **Teste 1:** Uma tarefa pertence a um usuário (Relacionamento BelongsTo)
*   **Teste 2:** Uma tarefa pode ser criada com sucesso (Persistência de dados)
*   **Teste 3:** Uma tarefa pode ser marcada como concluída (Atualização de dados)
*   **Teste 4:** Uma tarefa pode ser atualizada (Integridade de dados)

#### Testes da Model User:

*   **Teste 5:** Um usuário pode ter várias tarefas (Relacionamento HasMany)
*   **Teste 6:** Um usuário pode ser deletado e suas tarefas também (Deleção em cascata)

**Executar testes unitários:**
```bash
php artisan test tests/Unit
```

### 2. Testes de Integração (6 testes)

Os testes de integração validam a interação entre Controllers, Rotas e Autenticação.

#### Testes de Autenticação:

*   **Teste 1:** Um usuário pode fazer login e receber um token (Status 200)
*   **Teste 2:** Um usuário não pode fazer login com credenciais inválidas (Status 422)

#### Testes de CRUD de Tarefas:

*   **Teste 3:** Um usuário autenticado pode listar suas tarefas (Status 200)
*   **Teste 4:** Um usuário autenticado pode criar uma nova tarefa (Status 201)

#### Testes de Proteção de Rotas:

*   **Teste 5:** Um usuário não autenticado não pode acessar tarefas (Status 401)
*   **Teste 6:** Um usuário não autenticado não pode criar tarefas (Status 401)

**Executar testes de integração:**
```bash
php artisan test tests/Feature
```

### 3. Teste de Sistema

O teste de sistema valida o fluxo completo de autenticação e criação de tarefa, simulando a interação de um cliente de API (Insomnia/Postman).

**Cenário Testado:**
1. Autenticação via `/api/login` (Status 200)
2. Tentativa de acesso não autorizado (Status 401)
3. Criação de tarefa com token válido (Status 201)

**Documentação:** Consulte o arquivo `Teste_de_Sistema.pdf` para detalhes completos.

### 4. Teste de Usuário

O teste de usuário avalia a API pela perspectiva do desenvolvedor cliente, focando em usabilidade e clareza das mensagens de erro.

**Cenários Testados:**
1. Criação de tarefa com dados válidos (Status 201)
2. Criação de tarefa com dados inválidos (Status 422 com mensagens de erro claras)

**Documentação:** Consulte o arquivo `Teste_de_Usuario.pdf` para detalhes completos.

## Executar Todos os Testes

Para executar todos os testes (unitários e de integração):

```bash
php artisan test
```

**Saída esperada:**
```
Tests:    12 passed (XX assertions)
Duration: X.XXs
```

## Modelos de Dados

### Model: User

Representa um usuário do sistema com suporte a autenticação.

**Campos:**
*   `id` - Identificador único
*   `name` - Nome do usuário
*   `email` - Email único
*   `password` - Senha (hash)
*   `created_at` - Data de criação
*   `updated_at` - Data de atualização

**Relacionamentos:**
*   `tarefas()` - Relacionamento HasMany com Tarefa

### Model: Tarefa

Representa uma tarefa no sistema.

**Campos:**
*   `id` - Identificador único
*   `user_id` - Chave estrangeira para User
*   `titulo` - Título da tarefa (obrigatório)
*   `descricao` - Descrição da tarefa (opcional)
*   `concluida` - Status de conclusão (padrão: false)
*   `created_at` - Data de criação
*   `updated_at` - Data de atualização

**Relacionamentos:**
*   `user()` - Relacionamento BelongsTo com User

## Controllers

### LoginController

Responsável pela autenticação de usuários.

**Método:**
*   `login(Request $request)` - Autentica o usuário e retorna um token

### TarefaController

Responsável pelas operações CRUD de tarefas.

**Métodos Implementados:**
*   `index()` - Retorna todas as tarefas do usuário autenticado
*   `store(Request $request)` - Cria uma nova tarefa

## Boas Práticas Implementadas

### 1. Testes Isolados com RefreshDatabase

Todos os testes utilizam o trait `RefreshDatabase` para garantir que cada teste execute em um estado limpo do banco de dados, evitando efeitos colaterais entre testes.

### 2. Factory Pattern para Dados de Teste

O projeto utiliza **Factories** para criar dados de teste consistentes e reutilizáveis:

*   `UserFactory` - Cria usuários de teste com dados aleatórios
*   `TarefaFactory` - Cria tarefas de teste com relacionamento automático

### 3. Validação de Dados

O `TarefaController` implementa validação robusta:

```php
$request->validate([
    'titulo' => 'required|string|max:255',
    'descricao' => 'nullable|string',
    'concluida' => 'boolean',
]);
```

### 4. Proteção de Rotas com Middleware

As rotas de tarefas são protegidas com o middleware `auth:sanctum`:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tarefas', TarefaController::class)->only(['index', 'store']);
});
```

### 5. Relacionamentos com Deleção em Cascata

A migration define a deleção em cascata para manter a integridade referencial:

```php
$table->foreignId('user_id')->constrained()->onDelete('cascade');
```

## Tecnologias Utilizadas

| Tecnologia | Versão | Propósito |
| :--- | :--- | :--- |
| Laravel | 10.x | Framework Web |
| PHP | 8.1+ | Linguagem de Programação |
| PHPUnit | 10.x | Framework de Testes |
| Laravel Sanctum | 4.x | Autenticação de API |
| SQLite | 3.x | Banco de Dados |

## Próximos Passos

Para expandir este projeto, considere:

1. **Implementar CRUD Completo:** Adicionar métodos `show`, `update` e `destroy` no TarefaController
2. **Adicionar Validações:** Implementar validações mais complexas e testes de edge cases
3. **Implementar Paginação:** Adicionar paginação ao endpoint de listagem de tarefas
4. **Adicionar Filtros:** Permitir filtrar tarefas por status de conclusão
5. **Melhorar Documentação:** Utilizar OpenAPI/Swagger para documentação interativa da API
6. **Implementar Testes de Performance:** Adicionar testes de carga e performance

## Contribuindo

Para contribuir com este projeto:

1. Faça um fork do repositório
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Licença

Este projeto está sob a licença MIT. Consulte o arquivo `LICENSE` para mais detalhes.

## Contato

Para dúvidas ou sugestões sobre este projeto, entre em contato através do repositório GitHub ou abra uma issue.

---

**Desenvolvido para a disciplina de Qualidade de Software**  
**Data:** Novembro de 2025  
**Framework:** Laravel 10 com PHPUnit
