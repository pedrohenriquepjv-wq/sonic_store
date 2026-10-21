<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Força a sessão de administrador para testes locais
$_SESSION['usuario_id']    = 1;
$_SESSION['usuario_nome']  = 'Sonic Admin';
$_SESSION['usuario_email'] = 'sonic@email.com';
$_SESSION['usuario_nivel'] = 'admin';
?>