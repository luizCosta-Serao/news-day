<?php
  session_start();

  $autoload = function($class) {
    include('classes/'.$class.'.php');
  };
  spl_autoload_register($autoload);

  // diretório base do site
  define('INCLUDE_PATH', 'http://localhost/portal-de-noticias/');

  define('INCLUDE_PATH_PAINEL', INCLUDE_PATH.'painel/');

  define('HOST', 'localhost');
  define('USER', 'root');
  define('PASSWORD', '');
  define('DATABASE', 'portal_noticias');
?>