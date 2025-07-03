<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  if(isset($categoria)) {
    $questions = $dbh->getDomandaByCategoria($categoria["nomeCategoria"]);
  }
