# Documentação Técnica — Sonic Wear 

## 1. Visão Geral do Sistema — Sonic Wear

O **Sonic Wear** é uma plataforma web criada pra rodar um e-commerce de *streetwear* com temática geek/gaming (focado no universo Sonic). A ideia do projeto é ser leve, rápido e sem complicações de frameworks pesados: foi construído usando **PHP 8.x nativo** na raça e banco de dados **PostgreSQL**, garantindo segurança no acesso a dados via PDO e separação clara do que cada tipo de usuário pode fazer.

---

### 1.1. Recursos Principais

####  Autenticação & Gestão de Usuários
- **Controle de Acesso por Perfil (RBAC):** Separação total de privilégios entre **Clientes** (compradores) e **Administradores** (gestores da loja).
- **Sessões Seguras:** Controle de login e logout com validação contínua de permissões em páginas restritas (`verifica_user.php`).
- **Registro de Contas:** Auto-cadastro de novos clientes diretamente pela interface pública.

####  Gestão Completa de Produtos (CRUD)
- **Painel Administrativo:** Interface restrita para cadastrar, editar e excluir produtos do catálogo.
- **Controle de Estoque e Grade:** Suporte a diferentes tamanhos (P, M, G, GG) e controle de disponibilidade (`em_estoque`).
- **Gestão de Fornecedores:** Vinculação opcional de e-mail de fornecedores a cada item para facilitar reabastecimentos.
- **Visualização do Catálogo:** Vitrine geral com navegação rápida e consulta detalhada por produto individual (`select_w.php?id=X`).

####  Utilitários e Automação
- **Instalação em Um Clique:** Script `instalar.php` que cria automaticamente todas as tabelas no PostgreSQL sem precisar rodar scripts manuais no banco.
- **Povoamento de Testes (Seeder):** Script `popular.php` para preencher o catálogo e os usuários de teste com um único clique.
- **Identidade Visual Personalizada:** Suporte a fontes customizadas da marca (`Canyon Street.otf`) e assets estáticos integrados.

## 2. Arquitetura e Mapeamento de Arquivos

### 2.1. Estrutura de Diretórios

```
sonic_store/
├── app/
│   ├── CREATE TABLE usuarios (.sql   # Script SQL bruto de fallback
│   ├── create.php                    # Formulário e action de cadastro de produtos
│   ├── delete.php                    # Controller de exclusão lógica/física de produtos
│   ├── select.php                    # View/Controller do catálogo público/admin
│   ├── select_w.php                  # Consulta parametrizada por ID (detalhes do produto)
│   └── update.php                    # Formulário e action de edição de produtos
├── database/
│   └── connect.php                   # Singleton/Script de conexão PDO PostgreSQL
├── includes/
│   ├── footer.php                    # Componente global: Rodapé HTML/JS
│   ├── functions.php                 # Funções auxiliares (sanitização, helpers CRUD)
│   └── header.php                    # Componente global: Barra de navegação e CSS
├── login/
│   ├── cadastrar.php                 # Controller/View de registro de clientes
│   ├── login.php                     # Controller/View de autenticação
│   ├── logout.php                    # Destruição de sessão
│   └── verifica_user.php             # Middleware de proteção de rotas restritas
├── Canyon Street.otf                 # Tipografia customizada da marca
├── eggman.png                        # Asset visual estático (mascote/banner)
├── index.php                         # Landing Page e vitrine principal
├── instalar.php                      # Bootstrap do banco de dados (DDL)
└── popular.php                       # Seeder de dados iniciais (DML)
```

### 2.2. Mapeamento de Endpoints e Funcionalidades

| Rota / Arquivo | Métodos HTTP | Nível de Acesso | Descrição | 
| ----- | ----- | ----- | ----- | 
| `index.php` | `GET` | Público | Página inicial com destaque para lançamentos | 
| `login/cadastrar.php` | `GET`, `POST` | Público | Formulário de criação de conta de cliente | 
| `login/login.php` | `GET`, `POST` | Público | Autenticação e inicialização da sessão (`$_SESSION`) | 
| `login/logout.php` | `GET` | Autenticado | Encerramento da sessão e destruição de tokens localizados | 
| `app/select.php` | `GET` | Público | Listagem completa de produtos em estoque | 
| `app/select_w.php` | `GET` | Público | Consulta detalhada do produto via ID (`?id=X`) | 
| `app/create.php` | `GET`, `POST` | Admin | Formulário e processamento do cadastro de novos produtos | 
| `app/update.php` | `GET`, `POST` | Admin | Alteração de preços, estoque e metadados do produto | 
| `app/delete.php` | `POST`, `GET` | Admin | Remoção de produto do catálogo | 
| `instalar.php` | `GET` | Admin / Dev | Criação automática das tabelas no PostgreSQL | 
| `popular.php` | `GET` | Admin / Dev | Inserção de dados fictícios para testes | 

## 3. Modelo e Dicionário de Banco de Dados (PostgreSQL)

### 3.1. Dicionário de Dados: Tabela `usuarios`

| Coluna | Tipo SQL | Chave | Restrições | Padrão | Descrição | 
| ----- | ----- | ----- | ----- | ----- | ----- | 
| `id` | `SERIAL` | PK | `NOT NULL` | Auto-incremento | Identificador único do usuário | 
| `nome` | `VARCHAR(100)` | — | `NOT NULL` | — | Nome completo do usuário | 
| `email` | `VARCHAR(150)` | UNIQUE | `NOT NULL` | — | E-mail de login e notificações | 
| `senha` | `VARCHAR(255)` | — | `NOT NULL` | — | Hash de senha (utilizar `password_hash`) | 
| `nivel` | `VARCHAR(20)` | — | `NOT NULL` | `'cliente'` | Perfil de acesso (`'admin'` ou `'cliente'`) | 

### 3.2. Dicionário de Dados: Tabela `produtos`

| Coluna | Tipo SQL | Chave | Restrições | Padrão | Descrição | 
| ----- | ----- | ----- | ----- | ----- | ----- | 
| `id` | `SERIAL` | PK | `NOT NULL` | Auto-incremento | Identificador único do produto | 
| `nome` | `VARCHAR(100)` | — | `NOT NULL` | — | Nome comercial do produto | 
| `categoria` | `VARCHAR(50)` | — | `NOT NULL` | — | Categoria (ex: Camiseta, Moletom, Acessório) | 
| `tamanho` | `VARCHAR(10)` | — | `NOT NULL` | — | Tamanho da peça (P, M, G, GG, XG) | 
| `preco` | `NUMERIC(10,2)` | — | `NOT NULL` | `0.00` | Preço unitário em Reais (R\$) | 
| `em_estoque` | `BOOLEAN` | — | `NOT NULL` | `true` | Flag indicando se há unidades disponíveis | 
| `email_fornecedor` | `VARCHAR(150)` | — | `NULLABLE` | `NULL` | Contato do fornecedor para reposição | 

## 4. Segurança e Matriz de Permissões (RBAC)

### 4.1. Matriz de Acesso

| Ação / Módulo | Visitante (Anônimo) | Cliente | Administrador | 
| ----- | ----- | ----- | ----- | 
| Visualizar Home e Catálogo | Visualiza | Visualiza | Visualiza | 
| Consultar Detalhes do Produto | Visualiza | Visualiza | Visualiza | 
| Criar Conta (Self-register) | Executa | Indisponível | Indisponível | 
| Efetuar Login / Logout | Executa | Executa | Executa | 
| Cadastrar / Editar Produtos | Acesso Negado | Acesso Negado | Executa | 
| Excluir Produtos | Acesso Negado | Acesso Negado | Executa | 
| Executar Scripts de Instalação (`instalar.php`) | Acesso Negado | Acesso Negado | Executa | 

### 4.2. Diretrizes de Segurança Implementadas e Recomendadas

1. **Proteção Contra SQL Injection:** Toda a comunicação com o banco via `database/connect.php` utiliza **PDO com Prepared Statements** (`PDO::prepare()`).

2. **Proteção de Rotas:** O arquivo `login/verifica_user.php` atua como middleware interceptando as requisições em páginas administrativas (`create.php`, `update.php`, `delete.php`):

   ```php
   session_start();
   if (!isset($_SESSION['usuario_nivel']) || $_SESSION['usuario_nivel'] !== 'admin') {
       header('Location: /app/select.php?erro=acesso_negado');
       exit();
   }
   ```

3. **Criptografia de Senhas:** Senhas armazenadas na tabela `usuarios` devem obrigatoriamente utilizar a função `password_hash($senha, PASSWORD_DEFAULT)` e serem validadas com `password_verify()`.

## 5. Procedimentos de Instalação e Execução

### 5.1. Pré-requisitos

* **Servidor Web / Runtime:** PHP 8.1 ou superior.
* **Driver PHP:** Extensão `pdo_pgsql` ativada no `php.ini`.
* **Banco de Dados:** Servidor PostgreSQL 13+ ativo.
* **Terminal:** Terminal Bash, PowerShell ou MobaXterm.

### 5.2. Passo a Passo para Implantação Local

#### Passo 1: Configurar Banco de Dados

Crie o banco de dados no PostgreSQL e configure as credenciais no arquivo `database/connect.php`:

```php
$host = 'localhost';
$db   = 'sonic_wear_db';
$user = 'postgres';
$pass = 'sua_senha';
```

#### Passo 2: Executar Instalação das Tabelas

Acesse a rota de instalação pelo navegador ou CLI para disparar a criação automática da estrutura DDL:

```text
http://192.168.10.74:8000/instalar.php
```

#### Passo 3: Povoar Dados de Teste

Dispare o script seeder para cadastrar produtos e o usuário administrador inicial:

```text
http://192.168.10.74:8000/popular.php
```

#### Passo 4: Subir o Servidor em Rede Local

Navegue até o diretório raiz do projeto no servidor `/var/www/html` e inicie o servidor embutido do PHP apontando para o IP de rede:

```bash
cd /var/www/html/sonic_store
php -S 192.168.10.74:8000
```