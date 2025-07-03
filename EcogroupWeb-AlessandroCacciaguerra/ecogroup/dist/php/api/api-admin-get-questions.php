<?php

  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $category = getenv('CATEGORIA');

  $message = $dbh->getDomandaByCategoria($category);
