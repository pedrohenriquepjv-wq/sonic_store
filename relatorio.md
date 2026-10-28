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
│   ├── create.php                    # Formulário de cadastro de produtos (Admin)
│   ├── delete.php                    # Exclusão de produtos (Admin)
│   ├── select.php                    # Exibição do catálogo de produtos e exibição de IDs
│   ├── select_w.php                  # Consulta individual por ID
│   └── update.php                    # Atualização de dados dos produtos
├── database/
│   └── connect.php                   # Conexão PDO com banco de dados MySQL usando __DIR__
├── includes/
│   ├── footer.php                    # Rodapé global da aplicação
│   ├── functions.php                 # Funções auxiliares CRUD
│   └── header.php                    # Cabeçalho e menu de navegação global
├── login/
│   ├── cadastrar.php                 # Registro de novos usuários
│   ├── login.php                     # Autenticação de usuários/admin
│   ├── logout.php                    # Encerramento de sessão
│   └── verifica_user.php             # Middleware/Trava de sessão
├── Canyon Street.otf                 # Fonte customizada do projeto
├── eggman.png                        # Asset de imagem estática
├── index.php                         # Página inicial (Landing Page/Login)
├── instalar.php                      # Script de instalação do banco de dados
└── popular.php                       # Script para povoamento inicial de dados 
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

## 4. Módulos e Fluxo de Autenticação

### 4.1. Resolução de Caminhos de Arquivos (`__DIR__`)
O sistema utiliza a constante mágica `__DIR__` em todas as inclusões de arquivos internos (`require_once __DIR__ . '/../database/connect.php'`), garantindo o mapeamento de caminhos absolutos no servidor e evitando falhas na inclusão de cabeçalhos e conexões independentemente do diretório de execução.

### 4.2. Controle de Sessão e Permissões
- **Login (`login/login.php`):** Autentica o usuário no banco de dados e registra na sessão global `$_SESSION` as chaves:
  - `$_SESSION['usuario_id']`
  - `$_SESSION['usuario_nome']`
  - `$_SESSION['usuario_email']`
  - `$_SESSION['usuario_nivel']`
- **Validação Admin (`app/create.php`):** Valida as permissões de administrador antes de disponibilizar ações restritas do CRUD.

---

## 5. Instruções de Instalação e Execução

### 5.1. Pré-requisitos
- PHP 8.x instalado no ambiente.
- Servidor MySQL/MariaDB em execução.
- Terminal Bash ou MobaXterm com Git configurado.

### 5.2. Como Baixar e Executar o Projeto

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
