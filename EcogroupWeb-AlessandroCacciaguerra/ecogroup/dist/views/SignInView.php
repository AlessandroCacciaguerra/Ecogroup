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

    <title>ecogroup-signin</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <?php if(!isset($_SESSION["user_id"])) { ?>
      <div class="flex flex-col mx-auto md:flex-row justify-center gap-4 my-2 w-3/4">
        <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg" id="firstPage">
          <p class="w-auto md:w-96">
            La pagina a cui si accede dal pulsante "Questionari svolti" è strutturata in modo da offrire un riassunto dei risultati dei qustionari accessibile agli utenti.</br></br>
            I punteggi ottenuti sono calcolati sulla base delle risposte fornite nella checklist e di pesi ad esse associate stabiliti in precedenza.</br>
            I punteggi possono variare da 0 a 100, dove 0 sta per una scarsa propensione ad adottare pratiche LARG e di simbiosi industriale, mentre 100 sta per un'estrema propensione</br></br>
            ATTENZIONE: i punteggi danno un'indicazione su potenziali aree di miglioramento e si devono considerare come uno spunto per azioni future.
          </p>
        </div>
        <button id="changePage" class="border-green-700 bg-green-700 shadow-md border rounded-xl p-2 mt-2 hover:bg-green-800 cursor-pointer">Ho letto</button>
        <div id="secondPage" class="w-auto md:w-96" hidden>
          <div class="bg-site-primary  bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg">
            <form action="/api/api-user-signup.php" method="POST" id="SignInForm" class="flex flex-col justify-between gap-2">
              <label for="nomeAzienda">Nome azienda:</label>
              <input type="text" name="nomeAzienda" id="nomeAzienda" class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" required>

              <label for="email">Email:</label>
              <input type="email" name="email" id="email" class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" required>

              <label for="pwd">Password:</label>
              <input type="password" name="pwd" id="pwd" pattern="(?=.*\d).{8,}" class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" required>
              <p class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">(si richiede una lunghezza minima 8 caratteri, tra i quali deve esserci almeno un numero)</p>
              <label for="passwordClue">Indizio per il recupero della password (opzionale):</label>
              <p class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">(non deve coincidere con la password in chiaro)</p>
              <input type="text" name="passwordClue" id="passwordClue">

              <label for="dimensioneAzienda">Dimensione azienda:</label>
              <select id="dimensioneAzienda" name="dimensioni" size=3 class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700 text-white" required>
                <option value="piccola">piccola</option>
                <option value="media">media</option>
                <option value="grande">grande</option>
              </select>

              <label for="cap">CAP:</label>
              <p class="text-xs pb-2">(codice numerico a cinque cifre)</p>
              <input type="text" name="cap" id="cap" pattern='\d{5}' class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" required>

              <label for="citta">Città:</label>
              <input type="text" name="citta" id="citta" class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" required>

              <label for="ateco">Codice ATECO:</label>
              <p class="text-xs pb-2">(codice numerico da due a sei cifre - omettere la lettera iniziale)</p>
              <input type="text" name="ateco" id="ateco" pattern='\d{2,6}' class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md text-white" required>

              <div>
                <label for="codiciCER">Principali codici CER</label>
                <p class="text-xs pb-2">(codici numerici da due a sei cifre - separare con uno spazio)</p>
                <textarea id="codiciCER" name="codiciCER" pattern='(\d{2,6} ){1,}' class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md w-full text-white" required></textarea>
              </div>

              <input type="submit" value="invia" class="border-green-700 bg-green-700 shadow-md border rounded-xl p-2 mt-2 hover:bg-green-800 cursor-pointer">
            </form>
          </div>
          <div>
            <p id="erroreForm" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl"></p>
          </div>
        </div>
      </div>
      <script src="/javascript/SignIn.js"></script>
    <?php } else { ?>
      <div><a href="index.php" class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white">L'utente ha già effettuato l'accesso al sito</a></div>
    <?php } ?>
  </body>
</html>
