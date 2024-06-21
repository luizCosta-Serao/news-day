<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css">
  <title>Document</title>
</head>
<body>
  <section class="box-login">
    <form action="" method="post">
      <?php
        if (isset($_POST['action'])) {
          $user = $_POST['user'];
          $password = $_POST['password'];
          $sql = MySql::conectar()->prepare("SELECT * FROM `usuarios_admin` WHERE user = ? AND password = ?");
          $sql->execute(array($user, $password));
          if ($sql->rowCount() === 1) {
            $usuario = $sql->fetch();
            $_SESSION['user'] = $user;
            $_SESSION['password'] = $password;
            $_SESSION['name'] = $usuario['nome'];
            $_SESSION['cargo'] = $usuario['cargo'];
            $_SESSION['img'] = '';
            $_SESSION['login'] = true;
            header('Location: '.INCLUDE_PATH_PAINEL);
            die();
          } else {
            echo '<div class="box-erro">Usuário ou Senha incorretos</div>';
          }
        }
      ?>

      <label for="user">Usuário</label>
      <input type="text" name="user" id="user" required >
      <label for="password">Senha</label>
      <input type="password" name="password" id="password" required >
      <input type="submit" name="action" value="LOGIN">
    </form>
  </section>
</body>
</html>