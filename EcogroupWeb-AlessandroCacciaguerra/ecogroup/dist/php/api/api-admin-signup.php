<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;
  
  // Accedi direttamente ai dati 
  $username = getenv('USERNAME');
  $email = getenv('EMAIL');
  $password = getenv('PASSWD_INPUT');
  $passwordRepeat = getenv('PASSWD_REPEAT');
  $userId = 0;


  // Controllo mail
  if (!is_valid_email($email)) {
    $result = "E-mail non inserita o già presente nel database del sito";
  }
  // Controllo nome utente
  if (!is_valid_username($username)) {
    $result = "Nome utente non inserito o già presente nel database del sito";
  }
  // Controllo password
  if (!is_valid_password($password)) {
    $result = "Password non valida";
  }

  if ($password != $passwordRepeat) {
    $result = "Le password ripetuta non coincide con l'inserimento";
  }

  if(!isset($result)){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $dbh->createMod($username, $email, $password_hash);
    $result = 'Admin ' . $username . ' created';
  }

  echo $result;
?>
