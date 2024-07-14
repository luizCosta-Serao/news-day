<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
    if(isset($_POST['login'])) {
      $email = $_POST['email'];
      $senha = $_POST['password'];

      $sql = MySql::conectar()->prepare("SELECT * FROM `site_usuarios` WHERE email = ? AND senha = ?");
      $sql->execute(array($email, $senha));
      if($sql->rowCount() === 1) {
        $infoUsuario = $sql->fetch();
        $_SESSION['user_logado'] = true;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_senha'] = $senha;
        $_SESSION['user_nome'] = $infoUsuario['nome'];
        $_SESSION['user_id'] = $infoUsuario['id'];
        header('Location: '.INCLUDE_PATH);
        die();
      }
    }
  ?>
  <form class="login-form" action="" method="post">
    <label for="email">Email</label>
    <input type="email" name="email" id="email">

    <label for="password">Senha</label>
    <input type="password" name="password" id="password">

    <input type="submit" name="login" value="Login">
  </form>
</body>
</html>