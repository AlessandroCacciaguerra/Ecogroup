<?php
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;
  
  $result = 1;
  $nomeCategoria = getenv('NOMECATEGORIA');

  if($nomeCategoria != '') {
    if(count($dbh->getDomandaByCategoria($nomeCategoria)) == 0) {
      $dbh->eliminateCategory($nomeCategoria);
      $result = 0;
    }
  }
  echo "<script>self.location.replace('http://localhost:8080/AdminQuestionsView.php?start=AC" . $result . "')</script>";
