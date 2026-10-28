# Documentação Técnica — Sonic Store

## 1. Visão Geral do Sistema
O **Sonic Wear** é uma aplicação web desenvolvida em PHP e MySQL voltada para o gerenciamento de um catálogo e e-commerce de vestuário streetwear temático. O sistema conta com controle de acesso baseado em perfis (Administrador e Cliente), permitindo a gestão CRUD (Criar, Ler, Atualizar e Deletar) de produtos.

- **Prototipagem do Projeto (Figma):** [Acessar Slides no Figma](https://www.figma.com/slides/baWGMP1dcMhQDLScUGlxxi/Sem-t%C3%ADtulo?node-id=1-42&t=UVPqow54GuvdWCIK-0)

---

## 2. Arquitetura e Estrutura de Pastas

```text
sonic_store/
├── app/
│   ├── CREATE TABLE usuarios.sql     # Script SQL de criação de tabelas
│   ├── create.php                     # Formulário de cadastro de produtos (Admin)
│   ├── delete.php                     # Exclusão de produtos (Admin)
│   ├── select.php                     # Exibição do catálogo de produtos e exibição de IDs
│   ├── select_w.php                   # Consulta individual por ID
│   └── update.php                     # Atualização de dados dos produtos
├── database/
│   └── connect.php                    # Conexão PDO com banco de dados MySQL usando __DIR__
├── includes/
│   ├── footer.php                     # Rodapé global da aplicação
│   ├── functions.php                  # Funções auxiliares CRUD
│   └── header.php                     # Cabeçalho e menu de navegação global
├── login/
│   ├── cadastrar.php                  # Registro de novos usuários
│   ├── login.php                      # Autenticação de usuários/admin
│   ├── logout.php                     # Encerramento de sessão
│   └── verifica_user.php              # Middleware/Trava de sessão
├── Canyon Street.otf                  # Fonte customizada do projeto
├── eggman.png                         # Asset de imagem estática
├── index.php                          # Página inicial (Landing Page/Login)
├── instalar.php                       # Script de instalação do banco de dados
└── popular.php                        # Script para povoamento inicial de dados 
```

---

## 3. Modelo do Banco de Dados (MySQL)

### 3.1. Tabela `usuarios`
Armazena as credenciais de acesso e o nível de permissão de cada usuário.

| Coluna | Tipo | Restrições | Descrição |
| :--- | :--- | :--- | :--- |
| **id** | INT | AUTO_INCREMENT, PRIMARY KEY | Identificador único do usuário |
| **nome** | VARCHAR(100) | NOT NULL | Nome completo do usuário |
| **email** | VARCHAR(150) | UNIQUE, NOT NULL | E-mail para autenticação |
| **senha** | VARCHAR(255) | NOT NULL | Senha de acesso |
| **nivel** | VARCHAR(20) | DEFAULT 'comum' | Perfil de acesso (admin ou comum) |

### 3.2. Tabela `produtos`
Armazena o catálogo de vestuário da loja.

| Coluna | Tipo | Restrições | Descrição |
| :--- | :--- | :--- | :--- |
| **id** | INT | AUTO_INCREMENT, PRIMARY KEY | Identificador único do produto |
| **nome** | VARCHAR(100) | NOT NULL | Nome comercial do produto |
| **categoria** | VARCHAR(50) | NOT NULL | Categoria (ex: Camisetas, Casacos) |
| **tamanho** | VARCHAR(10) | NOT NULL | Tamanho da peça (ex: P, M, G, GG) |
| **preco** | DECIMAL(10,2) | NOT NULL | Valor do produto em Reais (R$) |

---

## 4. Requisitos do Sistema

### 4.1. Requisitos Funcionais (RF)
- **RF-01 (Autenticação de Usuários):** O sistema deve permitir que usuários se cadastrem (`cadastrar.php`), façam login (`login.php`) e encerrem sua sessão (`logout.php`).
- **RF-02 (Controle de Acesso por Nível):** O sistema deve limitar as permissões com base no perfil do usuário (`admin` ou `comum`), permitindo apenas aos administradores o acesso a rotas de criação, alteração e exclusão.
- **RF-03 (Visualização do Catálogo):** O sistema deve permitir a consulta e listagem de produtos cadastrados (`select.php`), exibindo informações detalhadas e seus respectivos IDs.
- **RF-04 (Consulta Individual por ID):** O sistema deve permitir a busca de um produto específico através de seu identificador único (`select_w.php`).
- **RF-05 (Cadastro de Produtos):** O sistema deve permitir que o administrador cadastre novos produtos informando nome, categoria, tamanho e preço (`create.php`).
- **RF-06 (Atualização de Produtos):** O sistema deve permitir a alteração das informações de um produto existente (`update.php`).
- **RF-07 (Exclusão de Produtos):** O sistema deve permitir a remoção permanente de um produto do catálogo (`delete.php`).
- **RF-08 (Instalação e Povoamento do Banco):** O sistema deve disponibilizar rotas para criação automatizada da estrutura de tabelas (`instalar.php`) e inserção de dados de teste (`popular.php`).

### 4.2. Requisitos Não Funcionais (RNF)
- **RNF-01 (Segurança de Sessão e Proteção de Rotas):** O sistema deve validar a sessão ativa via middleware (`verifica_user.php`) antes de permitir a visualização de páginas protegidas.
- **RNF-02 (Resolução de Mapeamento de Arquivos):** Todas as inclusões de arquivos no servidor devem utilizar a constante mágica `__DIR__` para garantir caminhos absolutos e evitar falhas de inclusão independente do ambiente de execução.
- **RNF-03 (Abstração de Banco de Dados via PDO):** A comunicação com o banco MySQL deve ser realizada exclusivamente via extensão PDO (`database/connect.php`).
- **RNF-04 (Compatibilidade de Plataforma):** A aplicação deve ser compatível com o interpretador PHP na versão 8.x e com os SGBDs MySQL/MariaDB.
- **RNF-05 (Portabilidade de Execução):** O sistema deve ser capaz de ser executado através do servidor web embutido do PHP (`php -S 0.0.0.0:8000`) em ambientes locais ou de desenvolvimento.
- **RNF-06 (Interface e Identidade Visual):** O layout deve aplicar elementos visuais temáticos próprios (fonte customizada `Canyon Street.otf` e assets gráficos como `eggman.png`).

---

## 5. Módulos e Fluxo de Autenticação

### 5.1. Resolução de Caminhos de Arquivos (`__DIR__`)
O sistema utiliza a constante mágica `__DIR__` em todas as inclusões de arquivos internos (`require_once __DIR__ . '/../database/connect.php'`), garantindo o mapeamento de caminhos absolutos no servidor e evitando falhas na inclusão de cabeçalhos e conexões independentemente do diretório de execução.

### 5.2. Controle de Sessão e Permissões
- **Login (`login/login.php`):** Autentica o usuário no banco de dados e registra na sessão global `$_SESSION` as chaves:
  - `$_SESSION['usuario_id']`
  - `$_SESSION['usuario_nome']`
  - `$_SESSION['usuario_email']`
  - `$_SESSION['usuario_nivel']`
- **Validação Admin (`app/create.php`):** Valida as permissões de administrador antes de disponibilizar ações restritas do CRUD.

---

## 6. Instruções de Instalação e Execução

### 6.1. Pré-requisitos
- PHP 8.x instalado no ambiente.
- Servidor MySQL/MariaDB em execução.
- Terminal Bash ou MobaXterm com Git configurado.

### 6.2. Como Baixar e Executar o Projeto

1. **Acesse o diretório base do servidor web no terminal:**
   ```bash
   cd /var/www/html
   ```

2. **Clone o repositório do projeto no servidor:**
   ```bash
   git clone https://github.com/teu-usuario/sonic_store.git
   ```

3. **Entre na pasta do projeto:**
   ```bash
   cd sonic_store
   ```

4. **Inicie o servidor embutido do PHP apontando para todas as interfaces de rede:**
   ```bash
   php -S 0.0.0.0:8000
   ```

5. **Acesse a aplicação no seu navegador:**
   - **Localmente:** `http://localhost:8000/sonic_store/`
   - **Pela rede local / MobaXterm:** `http://[SEU_IP]:8000/sonic_store/`

6. **Para abrir o catálogo com exibição de IDs e funcionalidade de restauração de dados padrão, navegue até:**
   - `http://[SEU_IP]:8000/sonic_store/app/select.php`
