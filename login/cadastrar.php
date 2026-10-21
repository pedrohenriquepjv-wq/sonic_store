<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registar Admin - Sonic Wear</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Registar Administrador</h1>
        <form action="" method="post">
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" required><br>
            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required><br>
            <input type="submit" value="Cadastrar">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            cadastrar_user($conexao, $_POST['email'], $_POST['senha']);
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>