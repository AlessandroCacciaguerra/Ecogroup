<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $codDomanda = $domanda["codDomanda"];

  $scelte = $dbh->getScelteByCodDomanda($codDomanda);
