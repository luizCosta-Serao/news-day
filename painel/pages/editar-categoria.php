<?php
  $id = $_GET['id'];
  $sql = MySql::conectar()->prepare("SELECT * FROM `categorias` WHERE id = ?");
  $sql->execute(array($id));
  $singleCategoria = $sql->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Editar Categoria</h1>
  <form action="" method="post">
    <?php
      if (isset($_POST['action'])) {
        $nomeCategoria = $_POST['nome'];
        $slug = Painel::generateSlug($nomeCategoria);
        if ($nomeCategoria === '') {
          Painel::alert('erro', 'Preencha o campo nome');
        } else {
          $sql = MySql::conectar()->prepare("UPDATE `categorias` SET nome = ?, slug = ? WHERE id = ?");
          $sql->execute(array($nomeCategoria, $slug, $id));
          Painel::alert('sucesso', 'Categoria atualizada com sucesso');
        }
      }
    ?>

    <label for="nome">Nome da Categoria</label>
    <input type="text" name="nome" value="<?php echo $singleCategoria['nome'] ?>">

    <input type="submit" name="action" value="Atualizar">
  </form>
</body>
</html>