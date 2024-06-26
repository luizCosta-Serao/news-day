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

  <?php
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('/', $url);
    $url = $url[count($url) - 1];

    if ($url === '' || str_contains($url, '?') === true) {
        include('pages/home.php');
    } else {
        include('pages/single-noticia.php');
    }
    
  ?>

  <script src="<?php echo INCLUDE_PATH; ?>js/index.js"></script>
</body>
</html>