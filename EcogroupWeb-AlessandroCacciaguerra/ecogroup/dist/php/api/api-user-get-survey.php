<?php

  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $questionario = $dbh->getQuestionarioByTitolo($titoloQuestionario);
  if (count($questionario) > 0){
    $codQuestionario = $questionario[0]['codQuestionario'];
    $domandeQuestionario = $dbh->getDomandaQuestionarioByQuestionarioID($codQuestionario);
    foreach ($domandeQuestionario as &$domanda) {
      $infoDomanda = $dbh->getDomandaByCodDomanda($domanda['DOMANDE_codDomanda']);
      $domanda['testo'] = $infoDomanda[0]['testo'];
      $scelte = $dbh->getScelteByCodDomanda($domanda['DOMANDE_codDomanda']);
      $domanda['scelteValori'] = array_column($scelte, 'valore');
      $domanda['sceltePesi'] = array_column($scelte, 'peso');
    }
  } else {
    $error = 'questionario non presente';
  }
