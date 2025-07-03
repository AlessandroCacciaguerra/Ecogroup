<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $adminID = getenv('ADMINID');
  $title = getenv('TITOLO');
  $QuestionsNumber = getenv('NUMERODOMANDA');
  $QuestionsPeso = getenv('PESO');
  $QuestionsId = getenv('CODDOMANDA');
  $QuestionsSection = getenv('SEZIONE');

  $totale = substr_count($QuestionsId,' ');
  $sectionToAdd = getenv('SEZIONIDAAGGIUNGERE');

  $questionsSection = array_map('trim', explode('/',$QuestionsSection));
  $sectionToAdd = array_map('trim', explode('/',$sectionToAdd));
  $questionsNumber = array_map('trim', explode(' ',$QuestionsNumber));
  $QuestionsPeso = array_map('trim', explode(' ',$QuestionsPeso));
  $questionsId = array_map('trim', explode(' ',$QuestionsId));

  $Questions = combinaArrayAssociativo($questionsNumber, $QuestionsPeso, $questionsId, $questionsSection);

  $result = '';

  foreach ($questionsSection as $section) {
    if(!in_array($section, $sectionToAdd)) {
      array_push($sectionToAdd, $section);
    }
  }

  if ($adminID == '') {
    $result = 'devi essere un admin per poter creare questionari';
  } elseif ($title == '') {
    $result = 'il questionario non ha titolo';
  } elseif ($QuestionsNumber == '') {
    $result = 'il questionario non ha domande';
  } elseif ($questionsSection == '' && $sectionToAdd == '') {
    $result = 'il questionario non ha sezioni'; 
  } elseif (in_array('Seleziona sezione',$sectionToAdd)) {
    $result = 'una sezione ha valore invalido "Seleziona sezione"'; 
  } else {
    if(count($dbh->getQuestionarioByTitolo($title)) != 0){
      $result = 'il titolo del questionario è già presente';
    } else {
      $dbh->createQuestionario($title);
      $idQuestionario = $dbh->getQuestionarioID($title);
      $dbh->createSezioni($sectionToAdd, $idQuestionario);
      $i=0;
      foreach ($Questions as $question){
        if($question['codDomanda'] != '') {
          $dbh->createDomandaQuestionario($question['numeroDomanda'], $question['peso'], $question['codDomanda'], $question['sezioni_nome'], $idQuestionario);
        }
        $i++;
        if($i==$totale) {break;}
      }
    }
  }

  echo $result;
?>
