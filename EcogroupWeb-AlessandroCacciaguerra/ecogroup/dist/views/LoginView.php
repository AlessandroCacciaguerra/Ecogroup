<?php
  require_once("/www/ecogroup/dist/php/session.php");
?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="./../assets/tailwind.css">
    <link rel="icon" href="./../assets/ecogroup-icon.png">
    <title>ecogroup-login</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <?php if(!isset($_SESSION["user_id"])) { ?>
      <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-1/3 mx-auto ">
        <form action="/api/api-user-login.php" method="POST" id="LoginForm" class="flex flex-col justify-between gap-2">
          <label for="email">Email:</label>
          <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" type="email" name="email" id="email" required>
          <label for="password">Password:</label>
          <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" type="password" name="pwd" id="password" required>

          <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary" type="submit" value="invia">
          <div>
            <p id="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl"></p>
          </div>
        </form>
        <form action="/api/api-user-login-get-password-reminder.php" method="POST" id="ClueForm">
          <input type="submit" class="bg-site-error bg-opacity-60 border border-site-error text-s p-3 rounded-xl" value="Hai dimenticato la password?">
        </form>
      </div>
      <script src="/javascript/LogIn.js"></script>
    <?php } else { ?>
      <div><a href="index.php" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">L'utente ha già effettuato l'accesso al sito</a></div>
    <?php } ?>
  </body>
</html>
