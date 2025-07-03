<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $category = $categoria["nomeCategoria"];

  $message = $dbh->getDomandaAlterableByCategoria($category);
