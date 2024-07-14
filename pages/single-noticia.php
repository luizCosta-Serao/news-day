<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
    $noticiaSingle = MySql::conectar()->prepare("SELECT * FROM `noticias` WHERE slug = ?");
    $noticiaSingle->execute(array($url));
    $noticiaSingle = $noticiaSingle->fetch();

    $categoriaNoticia = MySql::conectar()->prepare("SELECT * FROM `categorias` WHERE id = ?");
    $categoriaNoticia->execute(array($noticiaSingle['categoria_id']));
    $categoriaNoticia = $categoriaNoticia->fetch();
  ?>
  <img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $noticiaSingle['capa']; ?>" alt="">
  <p>data da postagem: <?php echo date('d/m/Y',strtotime($noticiaSingle['data'])); ?></p>
  <p>Categoria: <?php echo $categoriaNoticia['nome']; ?></p>
  <h1><?php echo $noticiaSingle['titulo']; ?></h1>
  <?php echo $noticiaSingle['conteudo']; ?>
  
  <?php
    $comentariosNoticia = MySql::conectar()->prepare("SELECT * FROM `comentarios` WHERE noticia_id = ?");
    $comentariosNoticia->execute(array($noticiaSingle['id']));
    $comentariosNoticia = $comentariosNoticia->fetchAll();

    if (isset($_POST['comentar'])) {
      $comentario = $_POST['comentario'];
      $noticiaId = $noticiaSingle['id'];
      $usuario_id = $_SESSION['user_id'];

      $sql = MySql::conectar()->prepare("INSERT INTO `comentarios` VALUES (null, ?, ?, ?)");
      $sql->execute(array($usuario_id, $comentario, $noticiaId));

      $comentariosNoticia = MySql::conectar()->prepare("SELECT * FROM `comentarios` WHERE noticia_id = ?");
      $comentariosNoticia->execute(array($noticiaId));
      $comentariosNoticia = $comentariosNoticia->fetchAll();
    }
  ?>
  <section class="comentarios">
    <?php
      if (Painel::userLogado() === false) {
    ?>
      <div class="container-erro-login">
        <p>Você precisa estar logado para comentar, clique <a href="">aqui</a> para efetuar o login</p>
      </div>
    <?php
      } else {
    ?>
      <h2>Deixe um comentário <?php echo $_SESSION['user_nome'] ?></h2>
      <form action="" method="post">
        <textarea name="comentario" id="comentario"></textarea>
        <input type="submit" name="comentar" value="Comentar">
      </form>
    <?php } ?>
    <h2>Comentários</h2>
    <?php
      if (@$comentariosNoticia) {
        foreach ($comentariosNoticia as $key => $value) {
          $nomeUsuario = MySql::conectar()->prepare("SELECT * FROM `site_usuarios` WHERE id = ?");
          $nomeUsuario->execute(array($value['usuario_id']));
          $nomeUsuario = $nomeUsuario->fetch();
    ?>
      <div class="single-comentario">
        <h3><?php echo $nomeUsuario['nome']; ?></h3>
        <p><?php echo $value['comentario']; ?></p>
      </div>
    <?php }} ?>
  </section>
</body>
</html>