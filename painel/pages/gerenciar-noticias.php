<?php

  if(isset($_GET['deletar'])) {
    // Deletar img da pasta uploads e deletar noticia no banco de dados
    $idDeletar = $_GET['deletar'];

    $img = MySql::conectar()->prepare("SELECT * FROM `noticias` WHERE id = ?");
    $img->execute(array($idDeletar));
    $imgName = $img->fetch();
    @unlink(BASE_DIR_PAINEL.'/uploads/'.$imgName['capa']);
    
    $sql = MySql::conectar()->prepare("DELETE FROM `noticias` WHERE id = ?");
    $sql->execute(array($idDeletar));
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
      <th>Título</th>
      <th>Conteúdo</th>
      <th>Capa</th>
      <th>##</th>
      <th>##</th>
    </thead>
    <tbody>
      <?php
        // puxando notícias do banco de dados
        $sql = MySql::conectar()->prepare("SELECT * FROM `noticias`");
        $sql->execute();
        $noticias = $sql->fetchAll();

        foreach ($noticias as $key => $value) {
      ?>
          <tr>
            <td><?php echo $value['titulo'] ?></td>
            <td><?php echo $value['conteudo'] ?></td>
            <td><img style="width: 100px" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['capa']; ?>" alt=""></td>
            <td><a href="<?php echo INCLUDE_PATH_PAINEL ?>/editar-noticia/?id=<?php echo $value['id'] ?>">Editar</a></td>
            <td><a href="<?php echo INCLUDE_PATH_PAINEL ?>/gerenciar-noticias?deletar=<?php echo $value['id'] ?>">Excluir</a></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>