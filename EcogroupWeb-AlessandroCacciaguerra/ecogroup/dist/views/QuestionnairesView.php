<?php
  require_once __DIR__ . '/../php/session.php';
?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="./../assets/tailwind.css">
    <link rel="icon" href="./../assets/ecogroup-icon.png">
    <title>ecogroup-history</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <div class="mx-auto bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-3/4 text-gray-200">
      <?php if(isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])) { ?>
        <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-30 p-2 rounded-xl shadow-md justify-start">Questionari compilati</h1>
        <?php
          include __DIR__ . '/../php/api/api-user-get-survey-score.php';
          include __DIR__ . '/../php/api/api-get-category.php';

            if($titoliQuestionari != null) {
        ?>
          <table class="w-full gap-2 justify-between bg-black bg-opacity-20 shadow-md rounded-lg px-2 py-3 mb-3">
            <thead class="w-full">
              <tr>
                <th rowspan="2">Data</th>
                <th rowspan="2">Titolo</th>
                <th colspan="<?=count($categorie)+1?>">Punteggio</th>
                <th rowspan="2">Vai al questionario compilato</th>
              </tr>
              <tr>
                <?php foreach($categorie as $categoria): ?>
                  <th><?=$categoria["nomeCategoria"]?></th>
                <?php endforeach; ?>
                <th>Totale</th>
              </tr>
            </thead>
            <tbody class="w-full">
              <?php for($i=0; $i<count($titoliQuestionari); $i++) { ?>
                <tr>
                  <td class="border-l-2 border-spacing-2 border-green-800 p-2"><?=$dateCompilazione[$i]?></td>
                  <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2"><?=$titoliQuestionari[$i]?></td>
                  <?php
                    $codQuestionarioCompilato = $codQuestionari[$i]["codQuestionarioCompilato"];
                    include __DIR__ . '/../php/api/api-get-scores-category.php';
                  
                    $j=0;
                    foreach($categorie as $categoria):
                      $flag = $j;
                      foreach($punteggi as $punteggio):
                        if($punteggio["categoria"] == $categoria["nomeCategoria"]):
                          $j++;
                  ?>
                    <td><?=$punteggio["punti"]?>/<?=$punteggio["max"]?></td>
                  <?php
                          break;
                        endif;
                      endforeach;
                      if($flag == $j):
                        $j++;
                  ?>
                    <td></td>
                  <?php
                      endif;
                    endforeach;
                  ?>
                  <td><?=$punteggiOttenuti[$i]?>%</td>
                  <td><a href="QuestionnairesFillView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>&titolo=<?=$titoliQuestionari[$i]?>">dettaglio completo</a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <div><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Menù principale</a></div>
          <?php } else { ?>
          <div>
            <a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">L'utente non ha ancora compilato alcun questionario</a>
          </div>
        <?php
            }
      	  } else {
        ?>
          <div>
            <a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Effettuare l'accesso per visionare il proprio storico</a>
          </div>
        <?php } ?>
    </div>
  </body>
</html>
