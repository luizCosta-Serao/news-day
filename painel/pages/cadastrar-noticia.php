<section>
  <h2>Cadastrar Notícia</h2>

  <form action="" method="post" enctype="multipart/form-data">
    <?php
      if (isset($_POST['action'])) {
        $categoria_id = $_POST['categoria_id'];
        $titulo = $_POST['title'];
        $conteudo = $_POST['conteudo'];
        $capa = $_FILES['capa'];
        if ($titulo === '' || $conteudo === '') {
          Painel::alert('erro', 'O campo devem ser preenchidos');
        } else {
          // Verificar se já existe uma notícia com esse título
          $verifica = MySql::conectar()->prepare("SELECT * FROM `noticias` WHERE titulo = ?");
          $verifica->execute(array($titulo));
          if($verifica->rowCount() === 0) {
            if ($capa['tmp_name'] !== '' && Painel::validadorImagem($capa)) {
              $capaName = Painel::uploadImagem($capa);
              $arr = [
                'categoria_id' => $categoria_id,
                'titulo' => $titulo,
                'conteudo' => $conteudo,
                'capa' => $capaName,
                'slug' => Painel::generateSlug($titulo),
                'nome_tabela' => 'noticias'
              ];
              Painel::insertInDatabase($arr);
              Painel::alert('sucesso', 'Categoria cadastrada com sucesso');
            } else {
              Painel::alert('erro', 'É necessário inserir uma capa');
            }
          } else {
            Painel::alert('erro', 'Já existe uma notícia com esse título');
          }
        }
      }
    ?>

    <div class="form-group">
      <label for="title">Título</label>
      <input type="text" name="title" id="title" value="<?php echo recoverPost('title') ?>">
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
            <option <?php if($value['id'] == @$_POST['categoria_id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label for="capa">Capa</label>
      <input type="file" name="capa" id="capa">
    </div>

    <div class="form-group">
      <label for="conteudo">Conteúdo</label>
      <textarea class="tinymce" name="conteudo" id="conteudo"><?php echo recoverPost('conteudo') ?></textarea>
    </div>

    <input type="submit" name="action" value="Publicar">
  </form>
</section>