<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $codQuestionario = getenv('CODQUESTIONARIO');
  $dbh->eliminateAllDomandaQuestionarioByQuestionarioId($codQuestionario);
  $dbh->eliminateSezioniByQuestionarioId($codQuestionario);
  $dbh->eliminateQuestionarioByQuestionarioId($codQuestionario);
