<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $result = '';

  $category = getenv('CATEGORIA');

  if (count($dbh->isCategoryPresent($category)) > 0) {
    $result = 'Categoria già presente';
  } elseif ($category == '') {
    $result = 'Il campo non può essere nullo';
  } elseif($category == 'Seleziona categoria') {
    $result = 'Il campo ha valore invalido "Seleziona categoria"';
  } else {
    $dbh->createCategory($category);
  }

  echo $result;
?>
