<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/database/connect.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        try {
            // Admin estático
            if ($email === 'sonic@email.com' && $senha === 'aluno123') {
                $_SESSION['usuario_id']    = 1;
                $_SESSION['usuario_nome']  = 'Sonic Admin';
                $_SESSION['usuario_email'] = 'sonic@email.com';
                $_SESSION['usuario_nivel'] = 'admin';

                header("Location: /sonic_store/app/select.php");
                exit();
            }

            // Usuário do banco
            $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha'])) {
                $_SESSION['usuario_id']    = $usuario['id'];
                $_SESSION['usuario_nome']  = $usuario['nome'] ?? 'Usuário';
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_nivel'] = ($usuario['email'] === 'sonic@email.com') ? 'admin' : 'comum';

                header("Location: /sonic_store/app/select.php");
                exit();
            } else {
                $erro = "E-mail ou senha incorretos!";
            }
        } catch (Exception $e) {
            $erro = "Erro ao conectar com o banco de dados.";
        }
    } else {
        $erro = "Preencha todos os campos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sonic Wear</title>
</head>
<body style="margin:0; font-family: 'Segoe UI', sans-serif; background: #0b0c10; color: #fff;">
    <?php include dirname(__DIR__) . '/includes/header.php'; ?>

    <main style="max-width: 400px; margin: 60px auto; padding: 30px; background: #161a23; border: 1px solid #333; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
        <h2 style="color: #fff; text-align: center; margin-top: 0; font-size: 28px;">Login</h2>
        
        <?php if (!empty($erro)): ?>
            <p style="color: #ff4d4d; text-align: center; font-weight: bold;"><?= $erro ?></p>
        <?php endif; ?>

        <form method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <label style="display: flex; flex-direction: column; gap: 5px; color: #a0a5b5;">
                Email:
                <input type="email" name="email" required style="padding: 10px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 6px; outline: none;">
            </label>

            <label style="display: flex; flex-direction: column; gap: 5px; color: #a0a5b5;">
                Senha:
                <input type="password" name="senha" required style="padding: 10px; background: #0b0c10; color: #fff; border: 1px solid #333; border-radius: 6px; outline: none;">
            </label>

            <button type="submit" style="background: #0056ff; color: #fff; padding: 12px; border: none; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px;">Entrar</button>
        </form>

        <div style="text-align: center; margin-top: 20px; border-top: 1px solid #222; padding-top: 15px;">
            <p style="color: #a0a5b5; margin: 0 0 8px 0; font-size: 14px;">Não tem uma conta?</p>
            <a href="/sonic_store/login/cadastrar.php" style="color: #2ed573; font-weight: bold; text-decoration: none; font-size: 15px;">Cadastre-se</a>
        </div>
    </main>

    <?php include dirname(__DIR__) . '/includes/footer.php'; ?>
</body>
</html>