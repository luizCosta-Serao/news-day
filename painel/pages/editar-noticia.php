<?php
  $id = $_GET['id'];
  $sql = MySql::conectar()->prepare("SELECT * FROM `noticias` WHERE id = ?");
  $sql->execute(array($id));
  $singleNoticia = $sql->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Editar Notícia</h1>
  
  <form action="" method="post" enctype="multipart/form-data">
    <?php
      if (isset($_POST['action'])) {
        // salvando em variáveis os valores dos inputs
        $categoria_id = $_POST['categoria_id'];
        $titulo = $_POST['title'];
        $conteudo = $_POST['conteudo'];
        $capa = $_FILES['capa'];
        $capa_atual = $_POST['capa_atual'];
        // alerta de erro caso titulo ou conteúdo esteja vazio
        if ($titulo === '' || $conteudo === '') {
          Painel::alert('erro', 'O campo devem ser preenchidos');
        } else {
          // Verificar se já existe uma notícia com esse título
          $verifica = MySql::conectar()->prepare("SELECT * FROM `noticias` WHERE titulo = ?");
          $verifica->execute(array($titulo));
          if($verifica->rowCount() === 0) {
            // se tiver selecionado uma nova imagem
            if ($capa['tmp_name'] !== '' && Painel::validadorImagem($capa)) {
              // deletando img antiga da pasta uploads
              @unlink(BASE_DIR_PAINEL.'/uploads/'.$capa_atual);
              // salvando nova img na pasta uploads
              $capaName = Painel::uploadImagem($capa);
              // criando slug
              $slug = Painel::generateSlug($titulo);
              // atualizando notícia
              $sql = MySql::conectar()->prepare("UPDATE `noticias` SET categoria_id = ?, data = ?, titulo = ?, conteudo = ?, capa = ?, slug = ? WHERE id = ?");
              $sql->execute(array($categoria_id, date('Y-m-d'), $titulo, $conteudo, $capaName, $slug, $id));
              Painel::alert('sucesso', 'Categoria cadastrada com sucesso');
            } else if ($capa['size'] === 0) {
              //se não tiver selecinado uma nova img

              // criando slug
              $slug = Painel::generateSlug($titulo);
              // atualizando notícia
              $sql = MySql::conectar()->prepare("UPDATE `noticias` SET categoria_id = ?, data = ?, titulo = ?, conteudo = ?, capa = ?, slug = ? WHERE id = ?");
              $sql->execute(array($categoria_id, date('Y-m-d'), $titulo, $conteudo, $capa_atual, $slug, $id));
              Painel::alert('sucesso', 'Notícia atualizada com sucesso sem alteração da capa');
            } else {
              echo print_r($capa);
            }
          } else {
            Painel::alert('erro', 'Já existe uma notícia com esse título');
          }
        }
      }
    ?>

    <div class="form-group">
      <label for="title">Título</label>
      <input type="text" name="title" id="title" value="<?php echo $singleNoticia['titulo']; ?>">
    </div>

    <div class="form-group">
      <label for="categoria_id">Categoria:</label>
      <select name="categoria_id" id="categoria_id">
        <?php
          $sql = MySql::conectar()->prepare("SELECT * FROM `categorias`");
          $sql->execute();
          $categorias = $sql->fetchAll();
          foreach ($categorias as $key => $value) {
        ?>
            <option <?php if($value['id'] == $singleNoticia['categoria_id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label for="capa">Capa</label>
      <input type="file" name="capa" id="capa">
      <input type="hidden" name="capa_atual" value="<?php echo $singleNoticia['capa'] ?>">
    </div>

    <div class="form-group">
      <label for="conteudo">Conteúdo</label>
      <textarea class="tinymce" name="conteudo" id="conteudo"><?php echo $singleNoticia['conteudo']; ?></textarea>
    </div>

    <input type="submit" name="action" value="Publicar">
  </form>
</body>
</html>