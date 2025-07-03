<?php
session_name('sid');
session_start();
header('Access-Control-Allow-Origin: *');

  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;
  
  // Accedi direttamente ai dati 
  $nome = getenv('NOMEAZIENDA');
  $email = getenv('EMAIL');
  $password = getenv('PWD');
  $indizio = getenv('PASSWORDCLUE');
  $dimensioni = getenv('DIMENSIONI');
  $cap = getenv('CAP');
  $citta = getenv('CITTA');
  $ateco = getenv('ATECO');
  $codiciCER = getenv('CODICICER');
  $userId = 0;

  // Controllo mail
  if (!is_valid_email($email)) {
    $response = "E-mail non inserita o già presente nel database del sito";
  }
  // Controllo nome azienda
  if (!is_valid_name($nome)) {
    $response = "Nome non inserito o già presente nel database del sito";
  }
  // Controllo password
  if (!is_valid_password($password)) {
    $response = "Password non valida";
  }
  if ($password == $indizio) {
    $response = "L'indizio non può coincidere con la password";
  }
  // Controllo dimensioni
  if (empty($dimensioni)) {
    $response = "Nessuna dimensione selezionata";
  }
  if (empty($cap) || !is_only_numbers($cap)) {
    $response = "Il CAP deve essere composto solo da numeri";
  }
  // Controllo città
  if (empty($citta)) {
    $response = "Nessuna città inserita";
  }
  // Controllo codice ATECO
  if (empty($ateco) || !is_only_numbers($ateco)) {
    $response = "Il codice ATECO deve essere composto solo da numeri";
  }
  // Controllo codici CER
  if (!empty($codiciCER)) {
    $codiciCERPuliti = clear_CER($codiciCER);
    if (!validate_CER($codiciCERPuliti)) {
      $response = "Il codice CER deve essere composto solo da numeri";
    }
  } else {
    $response = "Nessun codice CER inserito";
  }
  if(!isset($response)){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $dbh->createAzienda($nome, $email, $password_hash, $indizio, $dimensioni, $cap, $citta, $ateco, $codiciCER);
    $userId=$dbh->getAziendaID($email);
    $dbh->createCodiciAzienda($userId, $codiciCER);

    
    $response='./QuestionnairesFillView.php?user_id=' . $userId . '&user_type=company';
  }

  echo $response;
?>
