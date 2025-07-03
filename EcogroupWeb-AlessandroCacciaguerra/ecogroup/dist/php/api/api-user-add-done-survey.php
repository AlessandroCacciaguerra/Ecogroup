<?php

  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../utils/questionari.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $result = '';

  $codQuestionario = getenv('CODQUESTIONARIO');
  $codAzienda = getenv('CODAZIENDA');
  $codDomande = getenv('CODDOMANDE');
  $valoreRisposte = getenv('RISPOSTE');

  if($codQuestionario != '' && $codAzienda != '' && $codDomande != '' && $valoreRisposte != '') {
    $codQuestionarioCompilato = $dbh->getQuestionarioCompilatoByCodQuestionarioCodAzienda($codQuestionario, $codAzienda);
    if($codQuestionarioCompilato != null) {
      if(count($dbh->getRisposteByCodQuestionario($codQuestionarioCompilato[0]["codQuestionarioCompilato"])) == count($dbh->getDomandaQuestionarioByQuestionarioID($codQuestionario))) {
        $result = 'Il questionario è già stato interamente compilato in precedenza';
        echo $result;
        exit; 
      }
    } else {
      $dbh->createQuestionarioCompilato($codQuestionario, $codAzienda);
    }
    $codQuestionarioCompilato = $dbh->getQuestionarioCompilatoByCodQuestionarioCodAzienda($codQuestionario, $codAzienda);
    $domande_questionari = array_map('trim', explode(' ', $codDomande));
    $risposte = array_map('trim', explode(' ', $valoreRisposte));

    $array = creaScelteAssociativo($risposte, $domande_questionari);
    foreach ($array as $row) {
      if($row['valore'] != null && $row['codDomanda'] != null) {
        $dbh->createRisposta($row['valore'], $codQuestionarioCompilato[0]['codQuestionarioCompilato'], $row['codDomanda']);
      }
    }
  }
  echo $result;
?>
