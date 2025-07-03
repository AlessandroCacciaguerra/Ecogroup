<?php

  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../utils/questionari.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $AllQuestionari = $dbh->getAllQuestionariCompilati();
  $QuestionarioSingolo = estraiCodiciETitoli($AllQuestionari);
  $rispostePunteggio = [];

  $i=0;
  foreach ($AllQuestionari as &$questionario) {
    $codQuestionarioCompilato = $questionario['codQuestionarioCompilato'];
    $codAzienda = $questionario['aziende_codAzienda'];
    $rispostePunteggio[$i] = $dbh->getRisposteByCodQuestionario($codQuestionarioCompilato);
    $punteggioMax = 0;
    $punteggioOttenuto = 0;
    if(isset($rispostePunteggio[$i])) {
      foreach ($rispostePunteggio[$i] as &$rispostaPunteggio) {
        $peso = $dbh->getDomandaQuestionarioByCodDomandaQuestionario($rispostaPunteggio['codDomandaQuestionario']);
        $rispostaPunteggio['peso'] = $peso[0]['peso'];
        $punteggioOttenuto = $punteggioOttenuto + $rispostaPunteggio['peso'] * $rispostaPunteggio['punteggio'];
        $punteggioMax = $punteggioMax + $peso[0]['peso'];
      }
    }
    $nomeAzienda = $dbh->getNomeAziendaByCodAzienda($codAzienda);
    $punteggiofinale = calcolaPunteggio($punteggioMax, $punteggioOttenuto);
    $questionario['nomeAzienda'] = $nomeAzienda[0]['username'];
    $questionario['punteggio'] = $punteggiofinale;
    $i++;
  }

  rimuoviColonna($AllQuestionari, 'titolo');
  rimuoviColonna($AllQuestionari, 'QUESTIONARI_codQuestionario');
?>
