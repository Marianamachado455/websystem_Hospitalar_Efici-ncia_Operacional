<?php
// Inicia a sessão.
session_start();

// Verifica se a sessão 'user_id' NÃO existe
if (!isset($_SESSION['user_id'])) {
  // Se não existir, redireciona para o login
  header('Location: login.php');
  exit;
}
