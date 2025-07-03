<?php
  require_once("/www/ecogroup/dist/php/session.php");
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
    <title>ecogroup-adminhome</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <?php if(isset($_SESSION["user_id"]) && isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "moderator")) { ?>
      <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg w-2/3 mx-auto">
        <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md text-white">Questionari</h1>
        <div id="primapagina">
          <table class="w-full">
            <tr class="bg-black bg-opacity-20 p-2 shadow-md text-white">
              <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Ordine</th>
              <th class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[10%]">Id</th>
              <th class="border-r-2 border-spacing-2 border-green-800 p-2 w-[80%]">Titolo</th>
            </tr>
            <?php
              include __DIR__ . '/../php/api/api-admin-get-surveys-scores.php';

              foreach($QuestionarioSingolo as $questionarioS):
            ?>
                <tr class=" hover:cursor-pointer hover:bg-white hover:bg-opacity-10">
                  <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center"><button name="mostraRisultati"><?=$questionarioS["ordine"]?></button></td>
                  <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 text-center"><button name="mostraRisultati"><?=$questionarioS["codQuestionario"]?></button></td>
                  <td class="border-r-2 border-spacing-2 border-green-800 p-2 text-center"><button name="mostraRisultati"><?=$questionarioS["titolo"]?></button></td>
                </tr>
            <?php endforeach; ?>
          </table>
        </div>
        <div id="secondapagina" class="px-3 bg-opacity-20 bg-black w-full p-2 rounded-xl shadow-md text-white" hidden>
          <h2 class="font-Inter text-lg mb-2 pl-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Risultati aziende</h2>
          <?php if(count($AllQuestionari) > 0): ?>
            <div class="mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md flex justify-between px-3">
              <?php include __DIR__ . '/../php/api/api-get-category.php'; ?>
              <table>
                <thead>
                  <tr>
                    <th rowspan="2">Id questionario</th>
                    <th rowspan="2">Id azienda</th>
                    <th rowspan="2">Nome azienda</th>
                    <th colspan="<?=count($categorie)+1?>">Punteggio</th>
                    <th rowspan="2">Data compilazione</th>
                  </tr>
                  <tr>
                    <?php foreach($categorie as $categoria): ?>
                      <th><?=$categoria["nomeCategoria"]?></th>
                    <?php endforeach; ?>
                    <th>Totale</th>
                  </tr>
                </thead>
                <tbody id="table_body">
                  <?php
                    $sum = array_fill(0,count($categorie),0);
                    $max = array_fill(0,count($categorie),0);
                    //suddividi punteggi per categoria
                    $j=0;
                    foreach($AllQuestionari as $questionarioA) {
                  ?>
                    <tr hidden>
                      <td><?=$questionarioA["codQuestionario"]?></td>
                      <td><?=$questionarioA["aziende_codAzienda"]?></td>
                      <td><?=$questionarioA["nomeAzienda"]?></td>
                      <?php
                        $codQuestionarioCompilato = $questionarioA["codQuestionarioCompilato"];
                        include __DIR__ . '/../php/api/api-get-scores-category.php';
                        $i=0;
                        foreach($categorie as $categoria):
                          $flag = $i;
                          foreach($punteggi as $punteggio):
                            if($punteggio["categoria"] == $categoria["nomeCategoria"]):
                              $sum[$i] += $punteggio["punti"];
                              $max[$i] += $punteggio["max"];
                              $i++;
                            ?>
                        <td><?=round($punteggio["punti"]/$punteggio["max"]*100,2)?>%</td>
                      <?php
                              break;
                            endif;
                          endforeach;
                          if($flag == $i):
                      ?>
                        <td></td>
                      <?php
                            $i++;
                          endif;
                        endforeach;
                      ?>
                      <td><?=$questionarioA["punteggio"]?>%</td>
                      <td><?=$questionarioA["dataCompilazione"]?></td>
                    </tr>
                    <tr hidden>
                      <td colspan="<?=count($categorie)+5?>">
                        <details>
                          <table>
                            <tr>
                              <th>Domanda</th>
                              <th>Categoria</th>
                              <th>Punti</th>
                              <th>Risposta</th>
                            </tr>
                            <?php
                              foreach($rispostePunteggio[$j] as $risposta):
                                $codDomandaQuestionario = $risposta['codDomandaQuestionario'];
                                $punti = $risposta['punteggio'];
                                include __DIR__ . '/../php/api/api-get-question.php';
                            ?>
                              <tr>
                                <td><?=$domanda["testo"]?></td>
                                <td><?=$domanda["CATEGORIE_idCATEGORIA"]?></td>
                                <td class="text-center"><?=$domandaQuestionario["peso"]*$risposta["punteggio"]?></td>
                                <td><?=$scelta["valore"]?></td>
                              </tr>
                            <?php endforeach; ?>
                          </table>
                        </details>
                      </td>
                    </tr>
                  <?php
                      $j++;
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3">Punteggio medio:</td>
                    <?php
                      $i=0;
                      foreach($categorie as $categoria):
                    ?>
                      <td><?=$sum[$i] > 0 ? round($sum[$i]/$max[$i]*100,2) : 0?>%</td>
                    <?php
                        $i++;
                      endforeach;
                    ?>
                    <td colspan="2"><?=round(array_sum($sum)/array_sum($max)*100)?>%</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          <?php endif; ?>
          <div class="flex"><button onclick="tornaIndietro()" class="border-white border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-black shadow-md text-white">Torna indietro</button></div>
        </div>
        <div class="flex"><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Menù principale</a></div>
      </div>
      <script src="javascript/AdminLogged.js"></script>
    <?php } else { ?>
      <div><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">La pagina è riservata agli amministratori del sito</a></div>
    <?php } ?>
  </body>
</html>
