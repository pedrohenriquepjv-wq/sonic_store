<?php
require_once __DIR__ . '/../database/connect.php';

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    $nome = $_POST['nome'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $tamanho = $_POST['tamanho'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $em_estoque = ($_POST['em_estoque'] ?? 'true') === 'true';
    $email_fornecedor = $_POST['email_fornecedor'] ?? '';

    try {
        $sql = "UPDATE produtos SET nome = :nome, categoria = :categoria, tamanho = :tamanho, preco = :preco, em_estoque = :em_estoque, email_fornecedor = :email_fornecedor WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':categoria', $categoria);
        $stmt->bindValue(':tamanho', $tamanho);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':em_estoque', $em_estoque, PDO::PARAM_BOOL);
        $stmt->bindValue(':email_fornecedor', $email_fornecedor);
        $stmt->execute();

        $mensagem = "<p style='color: green;'>✅ Produto atualizado com sucesso!</p>";
    } catch (Exception $e) {
        $mensagem = "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Produto</title>
</head>
<body style="margin:0; font-family: sans-serif;">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main style="max-width: 500px; margin: 40px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
        <h2>Atualizar Produto</h2>
        <?= $mensagem ?>
        <form method="post" style="display: flex; flex-direction: column; gap: 10px;">
            <label>ID do Produto: <input type="number" name="id" required style="width: 100%;"></label>
            <label>Novo Nome: <input type="text" name="nome" required style="width: 100%;"></label>
            <label>Nova Categoria: <input type="text" name="categoria" required style="width: 100%;"></label>
            <label>Novo Tamanho: <input type="text" name="tamanho" required style="width: 100%;"></label>
            <label>Novo Preço: <input type="number" step="0.01" name="preco" required style="width: 100%;"></label>
            <label>Novo Email Fornecedor: <input type="email" name="email_fornecedor" required style="width: 100%;"></label>
            <label>Em Estoque: 
                <select name="em_estoque" style="width: 100%;">
                    <option value="true">Sim</option>
                    <option value="false">Não</option>
                </select>
            </label>
            <button type="submit" style="background: orange; color: white; padding: 10px; border: none; font-weight: bold; cursor: pointer;">Atualizar</button>
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>