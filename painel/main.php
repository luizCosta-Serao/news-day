<?php
  if (isset($_GET['loggout'])) {
    Painel::loggout();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css">
  <title>Document</title>
</head>
<body>
  <header class="header">
    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>?loggout">Sair</a>
  </header>
  <section class="submenu">
    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-categoria">Cadastrar Categoria |</a>
    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>gerenciar-categorias">Gerenciar Categorias |</a>
    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-noticia">Cadastrar Notícia |</a>
    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>gerenciar-noticias">Gerenciar Noticías |</a>
  </section>

  <?php Painel::carregarPagina(); ?>
  <script src="https://cdn.tiny.cloud/1/cvnfahyqwz8cs4s7qw7xq9acww5e6d0q91mxr3tejosprng4/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '.tinymce',
    });
  </script>
</body>
</html>