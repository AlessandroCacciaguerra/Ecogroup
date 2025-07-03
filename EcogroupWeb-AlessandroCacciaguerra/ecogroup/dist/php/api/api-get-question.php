<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  if(isset($codDomandaQuestionario) && isset($punti)) {
    $domandaQuestionario = $dbh->getDomandaQuestionarioByCodDomandaQuestionario($codDomandaQuestionario)[0];
    $domanda = $dbh->getDomandaByCodDomanda($domandaQuestionario["DOMANDE_codDomanda"])[0];
    $scelta = $dbh->getValoreByCodDomandaPunti($domandaQuestionario["DOMANDE_codDomanda"],$punti)[0];
  }
