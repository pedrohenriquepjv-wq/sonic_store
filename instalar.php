<?php
require_once __DIR__ . '/database/connect.php';

// ATENÇÃO: Se no seu connect.php a variável for $conn, mude abaixo de $pdo para $conn!
$conexao = $pdo ?? $conn ?? $conexao ?? $db;

try {
    // Executa o seu próprio script SQL sem alterar a estrutura do seu projeto
    $sql = file_get_contents(__DIR__ . '/app/CREATE TABLE usuarios (.sql');
    
    $conexao->exec($sql);

    echo "<h2 style='color: green;'>✅ TABELAS CRIADAS NA BASE DE DADOS COM SUCESSO!</h2>";
    echo "<p><a href='/login/cadastrar.php'>Clique aqui para Registar o Admin</a></p>";

} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Erro ao criar tabelas:</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
?>