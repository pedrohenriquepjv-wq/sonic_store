<?php
require_once __DIR__ . '/../database/connect.php';

$stmt = $conexao->prepare("SELECT * FROM produtos ORDER BY id ASC");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Links das camisetas 100% atualizados!
$camisetas = [
    'sonic'    => 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcSFkLUAymVIznnQFJSLDja9fsVSNo7S1P247fduuT2o7ZTWehV59dQLn91wukluqo_T5BtLSjkkbTHFkJD21xxV0IPar9dPO2Gwd9L-GFKqGz0domxE3JlxCD0',
    'tails'    => 'https://grihvy7kbcoq.compat.objectstorage.sa-saopaulo-1.oraclecloud.com/bembarato/images/bembarato.org-661a7bdd8bfef.jpg',
    'shadow'   => 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-mawzcpp37t738e',
    'amy'      => 'https://down-br.img.susercontent.com/file/6ff439c7032fd1ea0e664fa698aeaf85',
    'eggman'   => 'https://gearhumans.com/cdn/shop/products/dr-eggman-custom-t-shirt-hoodies-apparel-hd-gh20261-3d-custom-fleece-hoodies-hoodie-s-718682.jpg?v=1668836676',
    'knuckles' => 'https://static.riachuelo.com.br/RCHLO/15723259001/portrait/e6858bc427f560f01baad95c2cef14665835e458.jpg'
];

function pegarImagem($nome, $camisetas) {
    $nome = strtolower($nome);
    if (strpos($nome, 'sonic') !== false) return $camisetas['sonic'];
    if (strpos($nome, 'tails') !== false) return $camisetas['tails'];
    if (strpos($nome, 'shadow') !== false) return $camisetas['shadow'];
    if (strpos($nome, 'knuckles') !== false) return $camisetas['knuckles'];
    if (strpos($nome, 'amy') !== false) return $camisetas['amy'];
    if (strpos($nome, 'eggman') !== false) return $camisetas['eggman'];
    return $camisetas['sonic'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo - Sonic Wear</title>
</head>
<body style="margin:0; font-family: sans-serif; background: #f8f9fa;">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h1 style="text-align: center;">Catálogo de Produtos</h1>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach ($produtos as $p): ?>
                <div style="background: #fff; border-radius: 8px; border: 1px solid #ddd; padding: 15px; text-align: center;">
                    <img src="<?= pegarImagem($p['nome'], $camisetas) ?>" style="width: 100%; height: 200px; object-fit: contain;">
                    <h3 style="margin: 10px 0 5px 0;"><?= htmlspecialchars($p['nome']) ?></h3>
                    <p style="color: #666; font-size: 14px; margin: 0;"><?= htmlspecialchars($p['categoria']) ?> - TAM: <?= htmlspecialchars($p['tamanho']) ?></p>
                    <p style="color: #0052FF; font-size: 20px; font-weight: bold; margin: 10px 0;">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>