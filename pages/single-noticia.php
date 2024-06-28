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
  
</body>
</html>