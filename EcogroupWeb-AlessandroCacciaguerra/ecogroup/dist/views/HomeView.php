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
    <title>ecogroup-guide</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <div class="grid grid-cols-1 gap-3 px-16 py-3 text-center lg:grid-cols-3">
      <div class="lg:col-span-3 col-span-1 bg-site-primary bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
        <p>L'obiettivo di questo sito è valutare l'adozione da parte delle aziende di principi Green, Lean, Agile e Resilient (LARG) e le potenzialità aziendali di far parte di una ISN (Industrial Symbiosis Network). Le reti di simbiosi industriale (ISN) stanno emergendo come opzioni sostenibili per consentire la cooperazione tra più catene di approvvigionamento e per ottimizzare l'uso di risorse materiali ed energetiche all'interno di un'area geografica. La Checklist proposta al primo sign-in analizza diverse aree tematiche (Green, Lean, Agile, Resilient, Maturità aziendale, Risorse Input-Output) tramite domande in forma qualitativa e a risposta guidata. Il risultato è un punteggio che dà una visione d'insieme dell'azienda riguardo questi principi, considerandoli sia singolarmente che adeguatamente integrati. 
        I dati vengono raccolti per scopo di ricerca e saranno trattati mantenendo la riservatezza di essi tramite analisi aggregate.</p>
      </div>
      <div class="bg-site-primary bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600  p-4 rounded-lg">
        <p>Dopo aver cliccato il tasto in basso "INIZIO", comparirà un nuova pagina dove vi sarà richiesto di compilare i dati anagrafici della vostra azienda.</p>
      </div>
      <div class="bg-site-primary bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
        <p>Una volta effettuata la compilazione, cliccate sul bottone "invia". ATTENZIONE: non è possibile modificare i dati una volta cliccato il bottone. Comparirà un questionario suddiviso nelle cinque macro-aree sopra descritte. Per ogni domanda c'è una serie di risposte possibili.</p>
      </div>
      <div class="bg-site-primary bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
        <p>Per ogni sezione, compilate TUTTI i campi per poter procedere all'invio dei dati e all'elaborazione del risultato. Cliccate sul bottone "Invia" per procedere. Dopo il click i vostri risultati saranno salvati nel database dell'applicazione, dove gli organizzatori del sito potranno visionare i vostri risultati ed elaborarli.</p>
      </div>
      <?php if(!isset($_SESSION['user_id'])) { ?>
      	<a href="./SignInView.php" class="lg:col-start-2 bg-green-600 bg-opacity-60 backdrop-blur-md drop-shadow-lg p-4 rounded-lg hover:bg-green-800 transition ease-out hover:delay-100 ">INIZIO</a>
      <?php } ?>
      <div class="flex"><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Menù principale</a></div>
    </div>
  </body>
</html>
