<?php include('config.php') ?>
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
              <form action="">
                  <input type="text" name="search" id="search">
                  <input type="submit" name="action" value="BUSCAR">
              </form>
          </div>

          <div class="box-content-sidebar">
              <h2>Selecione a categoria</h2>
              <form action="">
                  <select name="category" id="category">
                      <option value="">Gerais</option>
                      <option value="">Esportes</option>
                      <option value="">Saúde</option>
                  </select>
              </form>
          </div>

          <div class="box-content-sidebar">
              <h2>Conheça o autor</h2>
              <img class="photo-author" title="Autor" src="<?php echo INCLUDE_PATH; ?>assets/photo-autor.jpeg" alt="Autor">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi efficitur turpis mauris, ut volutpat nisl dapibus vitae. Ut sagittis eget nibh sit amet hendrerit. Nam convallis venenatis tellus, at porta lacus mollis ut.</p>
          </div>
      </aside>
  </section>
</body>
</html>