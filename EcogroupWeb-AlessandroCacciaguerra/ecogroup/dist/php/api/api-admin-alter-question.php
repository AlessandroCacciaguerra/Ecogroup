<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $result = '';

  $text = getenv('TESTO');
  $category = getenv('CATEGORIA');
  $isPositive = getenv('ISPOSITIVE');
  $codDomanda = getenv('COD');
  $risposte = getenv('TESTORISPOSTE');

  if ($text == '' || $category == '' || $risposte == '') {
    $result = 'tutti i campi devono essere compilati';
  } else {
    $rispostepulite = array_map('trim', explode('/', $risposte));
    if (count($rispostepulite) < 2 ) {
      $result = 'una domanda deve avere almeno due risposte';
    } else if (!is_valid_text($text, $codDomanda)) {
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
      if($isPositive) {
        $isPositive = 1;
      } else {
        $isPositive = 0;
      }
      $dbh->updateDomanda($codDomanda, $text, $isPositive, $category);
      $dbh->eliminateAllScelteByCodDomanda($codDomanda);
      $sceltePeso = calcolaPesi($rispostepulite);
      $codDomanda = $dbh->getDomandaID($text);
      foreach ($sceltePeso as $scelta) {
        $dbh->addScelte($scelta['scelta'], $scelta['peso'], $codDomanda);
      }
    }
  }
  echo $result;
?>
