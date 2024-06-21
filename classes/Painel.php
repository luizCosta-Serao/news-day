<?php

  class Painel {
    public static function logado() {
      return isset($_SESSION['login']) ? true : false;
    }

    public static function loggout() {
      session_destroy();
      header('Location: '.INCLUDE_PATH_PAINEL);
    }

    public static function carregarPagina() {
      $url = explode('/', @$_GET['url']);
      if (
        isset($_GET['url']) &&
        file_exists('pages/'.$url[0].'.php')
      ) {
        include('pages/'.$url[0].'.php');
      } else {
        include('pages/home.php');
      }
    }

    public static function alert($type, $message) {
      if ($type === 'sucesso') {
        echo '<p class="sucesso">'.$message.'</p>';
      } else if ($type === 'erro') {
        echo '<p class="erro">'.$message.'</p>';
      }
    }

     // Gerador de slug
     public static function generateSlug($str) {
      $str = mb_strtolower($str);
      $str = preg_replace('/(â|á|ã)/', 'a', $str);
      $str = preg_replace('/(ê|é)/', 'e', $str);
      $str = preg_replace('/(í|Í)/', 'i', $str);
      $str = preg_replace('/(ú)/', 'u', $str);
      $str = preg_replace('/(ó|ô|õ|Ô)/', 'o', $str);
      $str = preg_replace('/(_|\/|!|\?|#)/', '', $str);
      $str = preg_replace('/( )/', '-', $str);
      $str = preg_replace('/ç/', 'c', $str);
      $str = preg_replace('/(-[-]{1,})/', '-', $str);
      $str = preg_replace('/(,)/', '-', $str);
      $str = strtolower($str);
      return $str;
    }

    public static function insertInDatabase($arr) {
      $certo = true;
      // obtendo o nome da tabela através do $_POST de um input:hidden
      $nome_tabela = $arr['nome_tabela'];
      // query para inserção dos dados no banco de dados
      $query = "INSERT INTO `$nome_tabela` VALUES (null";
        foreach ($arr as $key => $value) {
          $nome = $key;
          $valor = $value;
          if ($nome === 'action' || $nome === 'nome_tabela') {
            continue;
          }
          if ($value === '') {
            $certo = false;
            break;
          }
          $query.=",?";
          $parametros[] = $value;
        }
      $query.=")";
      //Fim da query para inserção dos dados no banco de dados
      if ($certo === true) {
        $sql = MySql::conectar()->prepare($query);
        $sql->execute($parametros);
      }
      return $certo;
    }
  }

?>