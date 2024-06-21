<section>
  <h2>Cadastrar Categoria</h2>

  <form action="" method="post">
    <?php
      if (isset($_POST['action'])) {
        $nome = $_POST['name'];
        $slug = Painel::generateSlug($nome);
        if ($nome === '') {
          Painel::alert('erro', 'Preencha o campo nome');
        }
        $arr = [
          'nome' => $nome,
          'slug' => $slug,
          'nome_tabela' => 'categorias'
        ];
        Painel::insertInDatabase($arr);
        Painel::alert('sucesso', 'Categoria cadastrada com sucesso');
      }
    ?>

    <div class="form-group">
      <label for="name">Nome da categoria</label>
      <input type="text" name="name" id="name">
    </div>

    <input type="submit" name="action" value="Cadastrar">
  </form>
</section>