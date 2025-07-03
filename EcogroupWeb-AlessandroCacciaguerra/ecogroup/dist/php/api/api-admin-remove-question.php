<?php
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $index = getenv('INDEX');
  $codDomanda = getenv('CODDOMANDA');

  $dbh->eliminateAllScelteByCodDomanda($codDomanda);
  $dbh->eliminateDomandaByCodDomanda($codDomanda);

  if(count($dbh->getDomandaByCodDomanda($codDomanda)) > 0 || count($dbh->getScelteByCodDomanda($codDomanda)) > 0) {
    $result = 1;
  } else {
    $result = 0;
  }
  echo "<script>self.location.replace('http://localhost:8080/AdminQuestionsView.php?start=MQ" . $result . $index . "')</script>";
?>
