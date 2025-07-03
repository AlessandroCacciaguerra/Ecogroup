<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../utils/questionari.php';
  require_once __DIR__ . '/../bootstrap.php';
  require_once __DIR__ . '/../session.php';
  global $dbh;

  $titoliQuestionari = [];
  $punteggiOttenuti = [];
  $dateCompilazione = [];

  $codAzienda = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
  $codQuestionari = $dbh->getAllQuestionarioCompilatoByCodAzienda($codAzienda);

  $risposteQuestionario = [];

  if(count($codQuestionari) > 0) {
    foreach ($codQuestionari as $idQuestionario) {
      $titolo = $dbh->getTitoloByCodQuestionario($idQuestionario['QUESTIONARI_codQuestionario']);
      array_push($titoliQuestionari, $titolo[0]['titolo']);
      array_push($dateCompilazione, $idQuestionario['dataCompilazione']);
      $codQuestionarioCompilato = $dbh->getQuestionarioCompilatoByCodQuestionarioCodAzienda($idQuestionario['QUESTIONARI_codQuestionario'], $codAzienda);
      $rispostePunteggio = $dbh->getRisposteByCodQuestionario($codQuestionarioCompilato[0]['codQuestionarioCompilato']);
      if(isset($codQuestionario) && $codQuestionario == $idQuestionario['QUESTIONARI_codQuestionario']) {
        $risposteQuestionario = $rispostePunteggio;
      }

      $punteggioMax = 0;
      $punteggioOttenuto = 0;
      foreach ($rispostePunteggio as &$rispostaPunteggio) {
        $peso = $dbh->getDomandaQuestionarioByCodDomandaQuestionario($rispostaPunteggio['codDomandaQuestionario']);
        $rispostaPunteggio['peso'] = $peso[0]['peso'];
        $punteggioOttenuto += $rispostaPunteggio['punteggio'];
        $punteggioMax += max($peso[0]['peso'],0);
      }
      $punteggiofinale = calcolaPunteggio($punteggioMax, $punteggioOttenuto);
      array_push($punteggiOttenuti, $punteggiofinale);
    }
  }
  unset($idQuestionario);
