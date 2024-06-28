<?php include('config.php') ?>
<?php
    // obtendo URL
    $url = explode('/', $_SERVER['REQUEST_URI']);
    // Se url no index 2 existir
    if (isset($url[2])) {
        // puxar uma única categoria
        $categoria = MySql::conectar()->prepare("SELECT * FROM `categorias` WHERE slug = ?");
        $categoria->execute(array($url['2']));
        $categoria = $categoria->fetch();
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/style.css">
  <title>Portal de Notícias</title>
</head>
<body>
  <header class="header">
      <a class="logo" href="<?php echo INCLUDE_PATH; ?>">
          <img src="<?php echo INCLUDE_PATH; ?>assets/logo.svg" alt="">
      </a>
      <nav class="menu">
          <ul>
              <li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
              <li><a href="">Recentes</a></li>
              <li><a href="">Esportes</a></li>
              <li><a href="">Gerais</a></li>
              <li><a href="">Saúde</a></li>
          </ul>
      </nav>
  </header>

  <section class="hero">
      <h1>Acompanhe as últimas notícias</h1>
      <p>Fique por dentro de tudo que acontece no Brasil</p>
  </section>

  <section class="container">
      <aside class="sidebar">
          <div class="box-content-sidebar">
              <h2>
                  Realizar uma busca 
                  <img title="Search" src="<?php echo INCLUDE_PATH; ?>assets/search.svg" alt="Search">
              </h2>
              <form action="" method="post">
                  <input type="text" name="search" id="search">
                  <input class="btn" type="submit" name="searchItem" value="BUSCAR">
              </form>
          </div>

          <div class="box-content-sidebar">
              <h2>Selecione a categoria</h2>
              <form action="">
                  <select name="category" id="category">
                    <option value="" disabled selected>Todas as categorias</option>
                    <?php
                        // puxar todas as categorias e inserir no front end
                        $categorias = MySql::conectar()->prepare("SELECT * FROM `categorias`");
                        $categorias->execute();
                        $categorias = $categorias->fetchAll();
                        foreach ($categorias as $key => $value) {
                    ?>
                            <option <?php if($value['slug'] === $url[2]) echo 'selected' ?> value="<?php echo $value['slug'] ?>"><?php echo $value['nome'] ?></option>
                    <?php
                        }
                    ?>
                 </select>
              </form>
          </div>

          <div class="box-content-sidebar">
                <h2>Conheça o autor</h2>
                <img class="photo-author" title="Autor" src="<?php echo INCLUDE_PATH; ?>assets/photo-autor.jpeg" alt="Autor">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi efficitur turpis mauris, ut volutpat nisl dapibus vitae. Ut sagittis eget nibh sit amet hendrerit. Nam convallis venenatis tellus, at porta lacus mollis ut.</p>
          </div>
      </aside>

      <div class="noticias">
            <?php
                // quantidade de notícias por página
                $porPagina = 2;

                // Título dinâmico de acordo com o valor da $url[2]
                if ($url[2] === '') {
                    echo '<h2>Visualizando todos os posts</h2>';
                } else {
                    echo '<h2>Visualizando posts em <span>'.$categoria['nome'].'</span></h2>';
                }

                // puxando notícias que estão na categoria atual
                $query = "SELECT * FROM `noticias` ";
                if ($url[2] !== '') {
                    $categoria['id'] = (int)$categoria['id'];
                    $query.="WHERE categoria_id = $categoria[id]";
                }
                // se pagina estiver setada
                if (isset($_GET['pagina'])) {
                    $pagina = (int)$_GET['pagina'];
                    $queryPg = ($pagina - 1) * $porPagina;
                    $query.=" LIMIT $queryPg, $porPagina";
                } else {
                    $pagina = 1;
                    $query.=" LIMIT 0, $porPagina";
                }
                $sql = MySql::conectar()->prepare($query);
                $sql->execute();
                $noticias = $sql->fetchAll();

                
            ?>
            <?php
                if (isset($_POST['searchItem'])) {
                    $search = $_POST['search'];
                    $sql = MySql::conectar()->prepare("SELECT * FROM `noticias` WHERE titulo LIKE '%$search%'");
                    $sql->execute();
                    $noticias = $sql->fetchAll();
                }
            ?>
          <ul class="lista-noticias">
                <?php
                    // inserindo no front end as notícias
                    foreach ($noticias as $key => $value) {
                        $sql = MySql::conectar()->prepare("SELECT * FROM `categorias` WHERE id = ?");
                        $sql->execute(array($value['categoria_id']));
                        $categoriaNome = $sql->fetch()['slug'];
                ?>
                    <li class="single-noticia">
                        <h3><?php echo date('d/m/Y',strtotime($value['data'])) ?> - <?php echo $value['titulo'] ?></h3>
                        <p><?php echo substr(strip_tags($value['conteudo']),0, 400); ?></p>
                        <a class="btn" href="<?php echo INCLUDE_PATH; ?><?php echo $categoriaNome; ?>/<?php echo $value['slug']; ?>">LER MAIS</a>
                    </li>
                <?php } ?>

                <?php
                    if (!isset($_POST['searchItem'])) {
                        $query = "SELECT * FROM `noticias` ";
                        if ($url[2] !== '') {
                            $categoria['id'] = (int)$categoria['id'];
                            $query.="WHERE categoria_id = $categoria[id]";
                        }
                        $totalPaginas = MySql::conectar()->prepare($query);
                        $totalPaginas->execute();
                        $totalPaginas = ceil($totalPaginas->rowCount() / $porPagina);
                    }
                ?>
                <div class="paginacao">
                    <?php
                        if (!isset($_POST['searchItem'])) {
                            for ($i=1; $i <= $totalPaginas ; $i++) {
                                @$catStr = ($categoria['nome'] !== '') ? $categoria['slug'] : '';
                                if ($pagina === $i) {
                                    echo '<a class="page-active" href="'.INCLUDE_PATH.$catStr.'/?pagina='.$i.'">'.$i.'</a>';
                                } else {
                                    echo '<a href="'.INCLUDE_PATH.$catStr.'/?pagina='.$i.'">'.$i.'</a>';
                                }
                            }
                        }
                    ?>
                </div>
          </ul>
      </div>
  </section>
  <script src="<?php echo INCLUDE_PATH; ?>js/index.js"></script>
</body>
</html>