<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $codQuestionario = isset($codQuestionario) ? $codQuestionario : '';
  
  if($codQuestionario != '') {
    $domande = $dbh->getAllDomandeForQuestionario($codQuestionario);
    foreach ($domande as $domanda) {
      if($domanda['numero'] == null) {
        if($domanda['positiva'] == '1') {
          $domanda['peso'] = '1';
        } else {
          $domanda['peso'] = '-1';
        }
        $domanda['sezione'] = '';
        $domanda['numero'] = '';
      }
    }
  } else {
    $domande = $dbh->getAllDomandeForNuovoQuestionario();
  }
