<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;
  
  $result = '';
  //questionario
  $titolo = getenv('TITOLO');
  $codQuestionario = getenv('CODQUESTIONARIO');
  //modifiche
  $codModeratore = getenv('CODMODERATORE');
  $commento = getenv('COMMENTO');
  //domande_Questionari
  $numeroDomande = getenv('NUMERODOMANDA');
  $pesoDomande = getenv('PESO');
  $codDomande = getenv('CODDOMANDA');
  $sezioneDomande = getenv('SEZIONE');

  if($codModeratore == '') {
    $result = 'nome utente non ottenuto, autenticarsi nuovamente';
  } elseif($titolo == '') {
    $result = 'inserire il titolo';
  } elseif(count($dbh->getQuestionarioByTitoloDiverso($titolo, $codQuestionario)) > 0) {
    $result = 'il titolo è già presente nel database';
  } elseif($commento == '') {
    $result = 'inserire un commento';
  } elseif($codDomande == '' || $numeroDomande == '' || $pesoDomande == '' || $sezioneDomande == '') {
    $result = 'il questionario non può rimanere senza domande';
  } else {
    $sezioneDomande = array_map('trim', explode('/',$sezioneDomande));
    $numeroDomande = array_map('trim', explode(' ',$numeroDomande));
    $pesoDomande = array_map('trim', explode(' ',$pesoDomande));
    $codDomande = array_map('trim', explode(' ',$codDomande));

    $domande = combinaArrayAssociativo($numeroDomande, $pesoDomande, $codDomande, $sezioneDomande);

    $dbh->modificaTitoloQuestionario($titolo, $codQuestionario);
    $dbh->createModifica($codModeratore, $commento, $codQuestionario);
    $dbh->eliminateAllDomandaQuestionarioByQuestionarioId($codQuestionario);
    $dbh->eliminateSezioniByQuestionarioId($codQuestionario);
    $dbh->createSezioni(array_unique($sezioneDomande), $codQuestionario);
    foreach ($domande as $question){
      if($question['codDomanda'] != '') {
        $dbh->createDomandaQuestionario($question['numeroDomanda'], $question['peso'], $question['codDomanda'], $question['sezioni_nome'], $codQuestionario);
      }
    }
  }
  echo $result;
?>
