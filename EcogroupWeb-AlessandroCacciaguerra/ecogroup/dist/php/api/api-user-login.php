<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $email = getenv('EMAIL');
  $password = getenv('PWD');
  $userId = -1;
  $userType = 'unknown';

  $company = $dbh->isMailCompanyPresent($email);
  $moderator = $dbh->isMailModeratorPresent($email);
  if (count($company) > 0) {
    if (password_verify($password, $company['0']['password'])) {
      $userId = $dbh->getAziendaID($email);
      $userType = 'company';

      $response = './QuestionnairesView.php?user_id=' . $userId . '&user_type=' . $userType;
    } else {
      $response = "La password digitata non corrisponde all'indirzzo e-mail inserito";
      $userId = 'invalid';
      $userType = 'company';
    }
  } elseif(count($moderator) > 0) {
    if (password_verify($password, $moderator['0']['password'])) {
      $userId = $dbh->getModeratorID($email);
      $userType = 'moderator';

      $response = './AdminLoggedView.php?user_id=' . $userId . '&user_type=' . $userType;
    } else {
      $response = "La password digitata non corrisponde all'indirzzo e-mail inserito";
      $userId = 'invalid';
      $userType = 'moderator';
    }
  } else {
     $response = "L'indirizzo e-mail digitato non è registrato nel sito";
     $userId = 'invalid';
  }
  echo $response;
?>
