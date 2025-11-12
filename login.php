<?php

session_start();
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
    $error = 'Por favor, preencha o usuário e a senha.';
  } else {
    // 1. Encontra o usuário no banco
    $stmt = $pdo->prepare("SELECT id, password_hash FROM usuarios WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    // 2. Verifica o usuário e a senha (criptografada)
    if ($user && password_verify($password, $user['password_hash'])) {
      // 3. Sucesso! Salva o ID do usuário na sessão
      $_SESSION['user_id'] = $user['id'];
      
      // 4. Redireciona para a página principal
      header('Location: index.php');
      exit;
    } else {
      // 5. Falha
      $error = 'Usuário ou senha inválidos.';
    }
  }
}
?><!doctype html><html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container" style="max-width: 400px;"> <h1>Login do Sistema</h1>

  <?php if ($error): ?>
    <div class='danger' style="padding: 10px; border-radius: 6px;"><?php echo h($error); ?></div>
  <?php endif; ?>

  <form method="post">
    <label>Usuário</label>
    <input type="text" name="username" required>
    
    <label>Senha</label>
    <input type="password" name="password" required>
    
    <input type="submit" value="Entrar">
  </form>
</div>

</body>
</html>