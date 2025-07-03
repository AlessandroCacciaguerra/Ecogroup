<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  if(isset($codQuestionario)) {
    $sezioniQuestionario = $dbh->getSezioniByCodQuestionario($codQuestionario);
  } else {
    $sezioni = $dbh->getNomiSezioni();
  }
  
