<?php
  // deletar categoria
  if(isset($_GET['deletar'])) {
    $idDeletar = $_GET['deletar'];
    $sql = MySql::conectar()->prepare("DELETE FROM `categorias` WHERE id = ?");
    $sql->execute(array($idDeletar));
    // deletar imgs das notícias quando as mesmas forem deletadas
    $deleteImgNoticias = MySql::conectar()->prepare("SELECT * FROM `noticias` WHERE categoria_id = ?");
    $deleteImgNoticias->execute(array($idDeletar));
    $deleteImgNoticias = $deleteImgNoticias->fetchAll();
    foreach ($deleteImgNoticias as $key => $value) {
      unlink(BASE_DIR_PAINEL.'/uploads/'.$value['capa']);
    }
    
    // quando deletar a categoria, delete todas as notícias que estão nessa categoria também
    $deleteNoticias = MySql::conectar()->prepare("DELETE FROM `noticias` WHERE categoria_id = ?");
    $deleteNoticias->execute(array($idDeletar));

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Gerenciar Categorias</h1>
  <table>
    <thead>
      <th>Nome da Categoria</th>
      <th>Slug</th>
      <th>##</th>
      <th>##</th>
    </thead>
    <tbody>
      <?php
        $sql = MySql::conectar()->prepare("SELECT * FROM `categorias`");
        $sql->execute();
        $categorias = $sql->fetchAll();

        foreach ($categorias as $key => $value) {
      ?>
          <tr>
            <td><?php echo $value['nome'] ?></td>
            <td><?php echo $value['slug'] ?></td>
            <td><a href="<?php echo INCLUDE_PATH_PAINEL ?>/editar-categoria/?id=<?php echo $value['id'] ?>">Editar</a></td>
            <td><a href="<?php echo INCLUDE_PATH_PAINEL ?>/gerenciar-categorias?deletar=<?php echo $value['id'] ?>">Excluir</a></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>