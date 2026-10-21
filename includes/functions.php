<?php
require_once __DIR__ . '/../database/connect.php';

// Cadastrar Roupa/Produto
function cadastrar($conexao, $nome, $categoria, $tamanho, $preco, $em_estoque, $email) {
    $sql = "INSERT INTO produtos (nome, categoria, tamanho, preco, em_estoque, email) 
            VALUES (:nome, :categoria, :tamanho, :preco, :em_estoque, :email)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":categoria", $categoria);
        $stmt->bindValue(":tamanho", $tamanho);
        $stmt->bindValue(":preco", $preco);
        $stmt->bindValue(":em_estoque", $em_estoque, PDO::PARAM_BOOL);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        echo "Peça cadastrada com sucesso na Sonic Wear!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Apagar Produto
function apagar($conexao, $id) {
    $sql = "DELETE FROM produtos WHERE id = :id";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "Produto ID $id removido do catálogo!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Relatório / Lista de Produtos
function relatorio($conexao) {
    $sql = "SELECT * FROM produtos ORDER BY id ASC";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($produtos as $p) {
            $estoque = $p['em_estoque'] ? 'Sim' : 'Não';
            echo "ID: {$p['id']}<br>";
            echo "Produto: {$p['nome']}<br>";
            echo "Categoria: {$p['categoria']}<br>";
            echo "Tamanho: {$p['tamanho']}<br>";
            echo "Preço: R$ {$p['preco']}<br>";
            echo "Em Estoque: {$estoque}<br>";
            echo "Contato Fornecedor: {$p['email']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Atualizar Produto
function atualizar($conexao, $id, $nome, $categoria, $tamanho, $preco, $em_estoque, $email) {
    $sql = "UPDATE produtos 
            SET nome = :nome, categoria = :categoria, tamanho = :tamanho, preco = :preco, em_estoque = :em_estoque, email = :email 
            WHERE id = :id";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":categoria", $categoria);
        $stmt->bindValue(":tamanho", $tamanho);
        $stmt->bindValue(":preco", $preco);
        $stmt->bindValue(":em_estoque", $em_estoque, PDO::PARAM_BOOL);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        echo "Produto atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Consultar Produto por ID
function consultar($conexao, $id) {
    $sql = "SELECT * FROM produtos WHERE id = :id";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $p = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($p) {
            $estoque = $p['em_estoque'] ? 'Sim' : 'Não';
            echo "Produto: {$p['nome']}<br>";
            echo "Categoria: {$p['categoria']}<br>";
            echo "Tamanho: {$p['tamanho']}<br>";
            echo "Preço: R$ {$p['preco']}<br>";
            echo "Disponível: {$estoque}<br>";
            echo "E-mail: {$p['email']}<br>";
        } else {
            echo "Nenhum produto encontrado com esse ID.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Cadastrar Utilizador/Admin
function cadastrar_user($conexao, $email, $senha) {
    $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();
        echo "Utilizador registado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Consultar Utilizador para Login
function consulta_user($conexao, $email) {
    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>