<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$emailLogado = $_SESSION['usuario_email'] ?? $_SESSION['email'] ?? $_SESSION['usuario'] ?? '';

// Bloqueio duplo: Se não estiver logado OU se o e-mail não for sonic@email.com
if (empty($emailLogado) || strtolower(trim($emailLogado)) !== 'sonic@email.com') {
    echo "<script>alert('Acesso negado! Apenas o administrador (sonic@email.com) pode acessar a página de cadastro.'); window.location.href='/sonic_store/login/login.php';</script>";
    exit();
}

require_once dirname(__DIR__) . '/database/connect.php';

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome             = $_POST['nome'] ?? '';
    $categoria        = $_POST['categoria'] ?? '';
    $tamanho          = $_POST['tamanho'] ?? '';
    $preco            = $_POST['preco'] ?? 0;
    $em_estoque       = ($_POST['em_estoque'] ?? 'true') === 'true';
    $email_fornecedor = $_POST['email_fornecedor'] ?? '';

    try {
        $sql = "INSERT INTO produtos (nome, categoria, tamanho, preco, em_estoque, email_fornecedor) 
                VALUES (:nome, :categoria, :tamanho, :preco, :em_estoque, :email_fornecedor)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':categoria', $categoria);
        $stmt->bindValue(':tamanho', $tamanho);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':em_estoque', $em_estoque, PDO::PARAM_BOOL);
        $stmt->bindValue(':email_fornecedor', $email_fornecedor);
        $stmt->execute();

        $mensagem = "<p style='color: #2ed573; font-weight: bold;'>✅ Produto cadastrado com sucesso!</p>";
    } catch (Exception $e) {
        $mensagem = "<p style='color: #ff4d4d; font-weight: bold;'>Erro: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto - Sonic Wear</title>
</head>
<body style="margin:0; font-family: 'Segoe UI', sans-serif; background: #0b0c10; color: #fff;">
    <?php include dirname(__DIR__) . '/includes/header.php'; ?>

    <main style="max-width: 500px; margin: 40px auto; padding: 20px; background: #161a23; border: 1px solid #2ed573; border-radius: 8px;">
        <h2 style="color: #2ed573; text-align: center;">Cadastrar Novo Produto</h2>
        <?= $mensagem ?>
        
        <form method="post" style="display: flex; flex-direction: column; gap: 10px;">
            <label>Nome do Produto: <input type="text" name="nome" required style="width: 100%; padding: 8px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 4px;"></label>
            <label>Categoria: <input type="text" name="categoria" required style="width: 100%; padding: 8px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 4px;"></label>
            <label>Tamanho: <input type="text" name="tamanho" required style="width: 100%; padding: 8px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 4px;"></label>
            <label>Preço (R$): <input type="number" step="0.01" name="preco" required style="width: 100%; padding: 8px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 4px;"></label>
            <label>Email Fornecedor: <input type="email" name="email_fornecedor" required style="width: 100%; padding: 8px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 4px;"></label>
            <label>Em Estoque: 
                <select name="em_estoque" style="width: 100%; padding: 8px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 4px;">
                    <option value="true">Sim</option>
                    <option value="false">Não</option>
                </select>
            </label>
            <button type="submit" style="background: #2ed573; color: black; padding: 10px; border: none; font-weight: bold; cursor: pointer; border-radius: 4px; margin-top: 10px;">Cadastrar Produto</button>
        </form>
    </main>

    <?php include dirname(__DIR__) . '/includes/footer.php'; ?>
</body>
</html>