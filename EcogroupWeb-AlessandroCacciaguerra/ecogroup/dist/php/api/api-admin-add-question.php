<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $result = '';

  $id_admin = getenv('CODMODERATORE');
  $text = getenv('TESTO');
  $category = getenv('CATEGORIA');
  $isPositive = getenv('ISPOSITIVE');
  $risposte = getenv('RISPOSTE');

  if($isPositive) {
    $isPositive = 1;
  } else {
    $isPositive = 0;
  }

  $rispostepulite = array_map('trim', explode('/', $risposte));

  if ($text == '' || $isPositive == '' || $category == '' || $id_admin == '' || count($rispostepulite) < 2 ) {
    $result = 'tutti i campi devono essere compilati';
  } else if (count($rispostepulite) < 2 ) {
    $result = 'una domanda deve avere almeno due risposte';
  } else if (!is_valid_text($text, null)) {
    $result = 'esiste già una domanda col medesimo testo';
  } else {
    for($i=1; $i<count($rispostepulite); $i++) {
      for($j=0; $j<$i; $j++) {
        if($rispostepulite[$j] == $rispostepulite[$i]) {
          $result = 'due o più risposte hanno valore identico "' . $rispostepulite[$j] . '"';
          echo $result;
          return;
        }
      }
    }
    $dbh->addDomanda($isPositive, $text, $category, $id_admin);
    $sceltePeso = calcolaPesi($rispostepulite);
    $codDomanda = $dbh->getDomandaID($text);
    foreach ($sceltePeso as $scelta) {
      $dbh->addScelte($scelta['scelta'], $scelta['peso'], $codDomanda);
    }
  }

  echo $result;
