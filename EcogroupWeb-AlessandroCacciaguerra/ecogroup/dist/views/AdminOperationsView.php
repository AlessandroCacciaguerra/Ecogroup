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
    <title>ecogroup-adminadd</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <?php if(isset($_SESSION["user_id"]) && isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "moderator")) { ?>
      <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-1/3 mx-auto">
        <h1 class="text-2xl font-Inter font-bold text-center mb-2">Aggiungi Admin</h1>
        <form action="/api/api-admin-signup.php" method="POST" id="addAdminForm" class="flex flex-col justify-between gap-2">
          <label for="username">Username:</label>
          <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-gray-200" type="text" name="username" required>
          <label for="email">Email:</label>
          <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-gray-200" type="email" name="email" required>
          <label for="passwd_input">Password:</label>
          <div class="bg-site-error bg-opacity-60 text-xs">
            <p>(si richiede una lunghezza minima di 8 caratteri, tra i quali deve esserci almeno un numero)</p>
          </div>
          <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-gray-200" id="passwd_input" type="password" name="passwd_input" minlength="8" pattern='/^\S*\[0-9]\S*$/' required>
          <label for="passwd_repeat">Ripeti Password:</label>
          <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-gray-200" id="passwd_repeat" type="password" name="passwd_repeat" minlength="8" pattern='/^\S*\[0-9]\S*$/' required>
          <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1" type="submit" value="invia">
        </form>
        <div>
          <p id="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl"></p>
        </div>
        <div class="flex"><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Menù principale</a></div>
      </div>
      <script src="javascript/AdminOperations.js"></script>
    <?php } else { ?>
      <div><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Solo un moderatore può aggiungere un altro moderatore al sito</a></div>
    <?php } ?>
  </body>
</html>
