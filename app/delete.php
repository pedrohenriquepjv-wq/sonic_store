<?php
require_once __DIR__ . '/../database/connect.php';
$db = $pdo ?? $conn ?? $conexao ?? null;
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $stmt = $db->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    $msg = $stmt->rowCount() ? "Produto excluído com sucesso!" : "Produto não encontrado.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Produto - Sonic Wear</title>
    <style>
        @font-face { font-family: 'CanyonStreet'; src: url('/sonic_store/Canyon%20Street.otf'); }
        body { background: #0b0c10; color: #fff; font-family: sans-serif; margin: 0; }
        .box { max-width: 500px; margin: 60px auto; background: #161a23; padding: 40px; border-radius: 12px; text-align: center; border: 1px solid #ff4d4d; }
        h1 { font-family: 'CanyonStreet', sans-serif; color: #ff4d4d; font-size: 36px; margin-bottom: 20px; }
        input { padding: 10px; width: 60%; border-radius: 6px; border: 1px solid #333; background: #0b0c10; color: #fff; text-align: center; }
        button { padding: 10px 20px; background: #ff4d4d; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        a { color: #aaa; text-decoration: none; display: block; margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sonic_store/includes/header.php'; ?>

    <div class="box">
        <h1>EXCLUIR PRODUTO</h1>
        
        <?php if ($msg): ?><p style="color:#2ed573; font-weight:bold;"><?= $msg ?></p><?php endif; ?>

        <form method="POST">
            <input type="number" name="id" placeholder="ID do Produto" required>
            <button type="submit">Excluir</button>
        </form>

        <a href="/sonic_store/app/select.php">← Voltar ao Catálogo</a>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/sonic_store/includes/footer.php'; ?>
</body>
</html>