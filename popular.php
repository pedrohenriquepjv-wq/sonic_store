<?php
require_once __DIR__ . '/database/connect.php';

try {
    // Reinstala as tabelas com a coluna 'nivel'
    $conexao->exec("
        DROP TABLE IF EXISTS produtos;
        DROP TABLE IF EXISTS usuarios;

        CREATE TABLE usuarios (
            id SERIAL PRIMARY KEY,
            nome VARCHAR(100) NOT NULL DEFAULT 'Admin',
            email VARCHAR(150) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL,
            nivel VARCHAR(20) DEFAULT 'admin'
        );

        CREATE TABLE produtos (
            id SERIAL PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            categoria VARCHAR(50) NOT NULL,
            tamanho VARCHAR(10) NOT NULL,
            preco NUMERIC(10, 2) NOT NULL,
            em_estoque BOOLEAN DEFAULT true,
            email_fornecedor VARCHAR(150)
        );
    ");

    // Cadastra o usuário Admin com senha hash
    $email = 'sonic@email.com';
    $senhaHash = password_hash('aluno123', PASSWORD_DEFAULT);

    $stmtAdmin = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, nivel) VALUES ('Sonic Admin', :email, :senha, 'admin')");
    $stmtAdmin->execute([':email' => $email, ':senha' => $senhaHash]);

    // Popula a tabela produtos
    $conexao->exec("
        INSERT INTO produtos (nome, categoria, tamanho, preco, em_estoque, email_fornecedor) VALUES
        ('T-Shirt Sonic Classic Blue', 'Camiseta', 'G', 79.90, true, 'sega@sonic.com'),
        ('T-Shirt Tails Miles Prower', 'Camiseta', 'M', 74.90, true, 'sega@sonic.com'),
        ('T-Shirt Shadow Dark Ultimate', 'Camiseta', 'GG', 89.90, true, 'sega@sonic.com'),
        ('T-Shirt Knuckles Red Power', 'Camiseta', 'P', 74.90, true, 'sega@sonic.com'),
        ('T-Shirt Amy Rose Sweet Pink', 'Camiseta', 'M', 79.90, true, 'sega@sonic.com'),
        ('Casaco Dr. Eggman Empire', 'Moletom', 'G', 179.90, true, 'sega@sonic.com');
    ");

    echo "<h2 style='color: green;'>✅ BANCO E USUÁRIO ADMIN ATUALIZADOS!</h2>";
    echo "<p>E-mail: <b>sonic@email.com</b> | Senha: <b>aluno123</b></p>";
    echo "<p><a href='/login/login.php'>Ir para a tela de Login</a></p>";

} catch (Exception $e) {
    echo "<h2 style='color: red;'>Erro: " . $e->getMessage() . "</h2>";
}
?>