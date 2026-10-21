<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    /* 1. Declaração da fonte especial Canyon Street */
    @font-face {
        font-family: 'CanyonStreet';
        src: url('/sonic_store/Canyon Street.otf') format('opentype');
        font-weight: normal;
        font-style: normal;
    }

    /* 2. Fonte padrão e limpa para todas as páginas e elementos */
    html, body, button, input, select, textarea, header, nav, a {
        font-family: 'Segoe UI', Arial, Helvetica, sans-serif !important;
    }

    /* 3. Aplica a fonte Canyon Street APENAS onde for usada a classe .titulo-especial */
    .titulo-especial, .titulo-gotico {
        font-family: 'CanyonStreet', Arial, sans-serif !important;
    }
</style>

<header style="background: #161a23; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ff4d4d;">
    <h1 style="margin: 0; color: #fff; font-size: 24px;">
        <a href="/sonic_store/index.php" style="color: #fff; text-decoration: none; font-weight: bold;">Sonic Wear</a>
    </h1>
    <nav style="display: flex; gap: 20px; align-items: center;">
        <a href="/sonic_store/index.php" style="color: #fff; text-decoration: none;">Início</a>
        <a href="/sonic_store/app/select.php" style="color: #fff; text-decoration: none;">Catálogo</a>
        <a href="/sonic_store/app/create.php" style="color: #2ed573; text-decoration: none; font-weight: bold;">Cadastrar</a>
        <a href="/sonic_store/app/update.php" style="color: #eccc68; text-decoration: none;">Atualizar</a>
        <a href="/sonic_store/app/delete.php" style="color: #ff4d4d; text-decoration: none;">Excluir</a>
        <a href="/sonic_store/login/login.php" style="color: #fff; border: 1px solid #fff; padding: 5px 15px; border-radius: 4px; text-decoration: none;">Login</a>
    </nav>
</header>