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
        <?php
          if (isset($_GET['sair'])) {
            session_destroy();
            header('Location: '.INCLUDE_PATH);
            die();
          }
        ?>
          <ul>
              <li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
              <li><a href="">Recentes</a></li>
              <li><a href="">Esportes</a></li>
              <li><a href="">Gerais</a></li>
              <li><a href="">Saúde</a></li>
              <?php
                if (@$_SESSION['user_logado']) {
              ?>
                <p><?php echo $_SESSION['user_nome']; ?></p>
                <a href="<?php echo INCLUDE_PATH; ?>?sair">Sair</a>
              <?php } else { ?>
                <li><a href="<?php echo INCLUDE_PATH; ?>/login">Login</a></li>
                <li><a href="<?php echo INCLUDE_PATH; ?>cadastre-se">Cadastre-se</a></li>
              <?php } ?>
          </ul>
      </nav>
  </header>

  <?php
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('/', $url);
    $url = $url[count($url) - 1];

    if ($url === '' || str_contains($url, '?') === true) {
        include('pages/home.php');
    } else if($url === 'login') {
      include('pages/login.php');
    } else if ($url === 'cadastre-se') {
      include('pages/cadastre-se.php');
    } else {
        include('pages/single-noticia.php');
    }
    
  ?>

  <script src="<?php echo INCLUDE_PATH; ?>js/index.js"></script>
</body>
</html>