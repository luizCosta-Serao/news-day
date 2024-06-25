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
            <td><a href="">Excluir</a></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>