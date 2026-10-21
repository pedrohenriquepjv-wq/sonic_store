<?php 
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Buscar Produto</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <h1>Consultar Peça por ID</h1>
    <form action="" method="post">
        <label for="id">ID da Peça: </label>
        <input type="number" name="id" id="id" required>
        <input type="submit" value="Consultar">
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        consultar($conexao, $_POST['id']);
    }
    ?>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>