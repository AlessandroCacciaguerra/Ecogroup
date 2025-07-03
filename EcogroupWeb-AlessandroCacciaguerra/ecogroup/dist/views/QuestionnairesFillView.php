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
    <title>ecogroup-questionarioview</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <?php if(isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])) { ?>
      <div class="mx-2 my-3 xl:mx-auto bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg">
        <?php $titoloQuestionario = isset($_GET["titolo"]) ? $_GET["titolo"] : "Questionario obbligatorio"; ?>
        <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md text-gray-200"><?=$titoloQuestionario?></h1>
        <?php
           include __DIR__ . '/../php/api/api-user-get-survey-titles.php';
	   if(sizeof($questionari) > 1):
        ?>
          <div class="mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md text-gray-200">
	    <h2 class="font-Inter text-2xl">Altri questionari</h2>
	    <table>
	      <tr>
		<th>Titolo</th>
		<th>Domande</th>
		<th>Stato</th>
	      </tr>
		<?php
		  include __DIR__ . '/../php/api/api-user-get-survey-titles.php';

		  foreach($questionari as $questionario):
		    if($questionario["titolo"] != $titoloQuestionario):
		?>
		  <tr>
		    <td><a href="QuestionnairesFillView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>&titolo=<?=$questionario["titolo"]?>"><?=$questionario["titolo"]?></a></td>
		    <td><?=$questionario["numero_domande"]?></td>
		    <?php
		      $codQuestionario = $questionario["codQuestionario"];
		      include __DIR__ . '/../php/api/api-user-get-survey-score.php';
		      if(count($risposteQuestionario) == 0) {
		    ?>
		      <td>non compilato</td>
		    <?php } elseif(count($risposteQuestionario) == $questionario["numero_domande"]) { ?>
		      <td>interamente compilato</td>
		    <?php } else { ?>
		      <td><?=$questionario["numero_domande"]-count($risposteQuestionario)?> domande rimanenti</td>
		    <?php } ?>
		  </tr>
		<?php
		    endif;
		  endforeach;
		?>
	     </table>
          </div>
        <?php endif; ?>
        <div class="flex gap-3 flex-col md:flex-row justify-between">
          <select class="border border-site-secondary rounded-lg px-2 py-1 mb-1 hover:bg-site-primary cursor-pointer h-12">
            <option class="border-site-secondary border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary">Seleziona sezione</option>
            <?php
              include __DIR__ . '/../php/api/api-user-get-survey.php';
              
              include __DIR__ . '/../php/api/api-user-get-survey-score.php';

              include __DIR__ . '/../php/api/api-get-sections.php';
              if(!isset($error)) {

                foreach($sezioniQuestionario as $sezione):
            ?>
              <option name="sectionOption" class="border-site-secondary border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary"><?=$sezione["nome"]?></option>
            <?php
                endforeach;
                unset($sezione);
            ?>
          </select>
          <?php
              foreach($sezioniQuestionario as $sezione):
                $index = array_search($sezione['nome'],array_column($domandeQuestionario,'sezioni_nome'));
                if(!in_array($domandeQuestionario[$index]["codDomandaQuestionario"],array_column($risposteQuestionario,'codDomandaQuestionario'))) {
          ?>
            <form class="w-full overflow-auto h-96 mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" action="/api/api-user-add-done-survey.php" method="POST" name="<?=$sezione["nome"]?>" hidden>
              <input name="inviaQuestionario" type="submit" class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-black" value="Salva">
              <input type="hidden" name="codQuestionario" value="<?=$domandeQuestionario[0]['sezioni_questionari_codQuestionario']?>">
              <input type="hidden" name="codAzienda" value="<?=$_SESSION["user_id"]?>">
              <input type="hidden" name="codDomande" value="">
              <input type="hidden" name="risposte" value="">
              <div class="text-gray-200">
                <?php
                    unset($domanda);
                    foreach($domandeQuestionario as $domanda):
                      if($domanda["sezioni_nome"] == $sezione["nome"]):
                ?>
                  <div class="<?=$domanda["numeroDomanda"]?>" name="domanda">
                    <div>
                      <p hidden><?=$domanda["codDomandaQuestionario"]?></p>
                      <h2><?=$domanda["numeroDomanda"]?></h2>
                      <p><?=$domanda["testo"]?></p>
                      <div>
                        <label for="risposta">Risposta:</label>
                        <select name="risposta" size="<?=count($domanda["scelteValori"])?>" class="text-green-700" required>
                          <?php for($i=0; $i<count($domanda["scelteValori"]); $i++) { ?>
                            <option name="scelta" class="<?=$sezione["nome"]?>" value="<?=$domanda["sceltePesi"][$i] * $domanda["peso"]?>" ><?=$domanda["sceltePesi"][$i] * $domanda["peso"]?>  <?=$domanda["scelteValori"][$i]?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                <?php
                    endif;
                  endforeach;
                ?>
              </div>
              <input name="inviaQuestionario" type="submit" class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-black" value="Salva">
            </form>
          <?php } else { ?>
            <section id="<?=$sezione["nome"]?>" hidden>
              <div class="w-full overflow-auto h-96 mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md text-gray-200">
                <?php
                    unset($domanda);
                    foreach($domandeQuestionario as $domanda):
                      if($domanda["sezioni_nome"] == $sezione["nome"]):
                ?>
                  <div name="domanda">
                    <div>
                      <p hidden><?=$domanda["codDomandaQuestionario"]?></p>
                      <h2><?=$domanda["numeroDomanda"]?></h2>
                      <p><?=$domanda["testo"]?></p>
                      <div>
                        <label for="risposta">Risposta:</label>
                        <ul name="risposta" class="text-green-700">
                            <?php
                              for($i=0; $i<count($domanda["scelteValori"]); $i++) {
                                $index = array_search($domanda["codDomandaQuestionario"],array_column($risposteQuestionario,'codDomandaQuestionario'));
                                if($domanda["sceltePesi"][$i]*$domanda["peso"] == $risposteQuestionario[$index]['punteggio']) {
                            ?>
                            <li name="scelta" class="bg-black border p-1" value="<?=$domanda["sceltePesi"][$i] * $domanda["peso"]?>"><?=$domanda["sceltePesi"][$i] * $domanda["peso"]?>  <?=$domanda["scelteValori"][$i]?> &#10004</li>
                          <?php } else { ?>
                            <li name="scelta" class="bg-white border p-1" value="<?=$domanda["sceltePesi"][$i] * $domanda["peso"]?>" ><?=$domanda["sceltePesi"][$i] * $domanda["peso"]?>  <?=$domanda["scelteValori"][$i]?></li>
                          <?php
                                }
                              }
                          ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                <?php
                    endif;
                  endforeach;
                ?>
              </div>
            </section>
          <?php 
                }
            endforeach;
          ?>
        </div>
        <div><p class="text-gray-200" id="formError"></p></div>
        <?php } else { ?>
          <div class="bg-site-error bg-opacity-60 border border-site-error text-xs p-2 rounded-xl mt-2">
            <p id="error"><?=$error?></p>
          </div>
        <?php
            }
        ?>
        <div class="flex"><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Menù principale</a></div>
      </div>
      <script src="./../javascript/QuestionnairesFill.js"></script>
    <?php } else { ?>
      <div><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Solo gli utenti autenticati possono compilare questionari</a></div>
    <?php } ?>
  </body>
</html>
