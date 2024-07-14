<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
    if(isset($_POST['cadastre-se'])) {
      $email = $_POST['email'];
      $senha = $_POST['password'];
      $nome = $_POST['nome'];

      $sql = MySql::conectar()->prepare("INSERT INTO `site_usuarios` VALUES (null, ?, ?, ?)");
      $sql->execute(array($email, $senha, $nome));
      header('Location: '.INCLUDE_PATH.'login');
      die();
    }
  ?>
  <form class="cadastre-se-form" action="" method="post">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome">
  
    <label for="email">Email</label>
    <input type="email" name="email" id="email">

    <label for="password">Senha</label>
    <input type="password" name="password" id="password">

    <input type="submit" name="cadastre-se" value="Cadastre-se">
  </form>
</body>
</html>