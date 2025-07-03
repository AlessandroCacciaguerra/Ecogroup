<?php
  require_once __DIR__ . '/../utils/validators.php';
  require_once __DIR__ . '/../bootstrap.php';
  global $dbh;

  $email = getenv('EMAIL');

  $response = $dbh->getClueByEmail($email);
  if($response["indizio"] != "") {
    echo 'mailto:' . $email . '?subject=Ecogroup password reminder&body=' . $response["indizio"];
  } else {
    echo '';
  }
?>
