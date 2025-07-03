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
    <title>ecogroup-adminsurveys</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'moderator')) { ?>
      <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg min-h-[60%] w-5/6 mx-auto text-gray-200">
        <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Questionari</h1>
        <div class="flex gap-3 flex-col md:flex-row justify-between">
          <ul class="QUESTIONARI bg-black bg-opacity-20 p-2 rounded-xl shadow-md">
            <button id="Aggiungi"><li class="border border-site-secondary rounded-lg px-3 py-1 mb-2 hover:bg-site-primary cursor-pointer">Aggiungi</li></button>
            <button id="Modifica"><li class="border border-site-secondary rounded-lg px-3 py-1 mb-2 hover:bg-site-primary cursor-pointer">Modifica</li></button>
          </ul>
          <div id="AddSurvey" class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
            <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Crea questionario</h1>
            <form action="/api/api-admin-add-survey.php" method="POST" id="addSurveyForm">
              <fieldset id="firstPage" class="flex flex-col gap-2 text-left">
                <input type="hidden" id="adminID" name="adminID" value="<?=$_SESSION['user_id']?>" readonly>
                <input type="hidden" id="numeroDomanda" name="numeroDomanda" value="" readonly>
                <input type="hidden" id="peso" name="peso" value="" readonly>
                <input type="hidden" id="codDomanda" name="codDomanda" value="" readonly>
                <input type="hidden" id="sezione" name="sezione" value="" readonly>
                <div>
                  <label for="titolo1" class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Titolo:</label>
                  <input type="text" id="titolo1" name="titolo" class="bg-green-900 px-2 mb-3 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" required>
                </div>
                <div>
                  <label for="sezioni" class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Nuove sezioni</label>
                  <p class="text-xs pb-2 ml-2">(premi "/" per separare; valgono anche per la sezione "Modifica"; se non usate, non persisteranno alla ricarica della pagina)</p>
                  <textarea id="sezioni" name="sezioniDaAggiungere" class="bg-green-900 px-2 mb-3 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md"></textarea>
                  <button onclick="aggiungiSezioni()" type="button" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">aggiungi</button>
                </div>
              </fieldset>
              <fieldset id="secondPage" class="flex flex-col gap-2 text-left" hidden>
                <div class="flex justify-between gap-2">
                  <div class="flex flex-col w-full">
                    <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md" for="CategoriaAttuale1">Categoria</label>
                    <select id="CategoriaAttuale1" name="CategoriaAttuale1" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700">
                      <option onclick="disponiDomande1('')">Seleziona categoria</option>
                      <?php
                        include __DIR__ . '/../php/api/api-get-category.php';

                        foreach($categorie as $categoria):
                      ?>
                        <option name="optionCategory" onclick="disponiDomande1(this.innerHTML)"><?=$categoria["nomeCategoria"]?></option>
                      <?php
                        endforeach;
                        unset($categoria);
                      ?>
                    </select>
                  </div>
                  <div class="flex flex-col w-full">
                    <label for="SezioneAttuale1" class="font-Inter text-xl mb-1 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Sezione</label>
                    <select id="SezioneAttuale1" name="SezioneAttuale1" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700">
                      <?php
                        include __DIR__ . '/../php/api/api-get-sections.php';

                        foreach($sezioni as $sezione):
                      ?>
                        <option><?=$sezione["nome"]?></option>
                      <?php
                        unset($sezione);
                        endforeach;
                      ?>
                    </select>
                  </div>
                </div>
                <div class="overflow-auto box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 max-h-72 mt-2">
                  <table class="overflow-auto w-full">
                    <tr class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md" id="intestazione" hidden>
                      <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%] text-center">Inserita</th>
                      <th class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[70%] text-center">Testo</th>
                      <th class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Numero</th>
                      <th class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Impatto</th>
                      <th class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Peso</th>
                      <th class="border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Sezione</th>
                    </tr>
                    <?php
                      include __DIR__ . '/../php/api/api-admin-get-questions-survey.php';

                      unset($domanda);
                      foreach($domande as $domanda):
                    ?>
                      <tr name="question" hidden>
                        <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center">
                          <button name="aggiungiDomanda" type="button" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">Aggiungi</button>
                        </td>
                        <td class="border-l-2 border-spacing-2 border-green-800 p-2"><?=$domanda["testo"]?></td>
                        <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 text-center"></td>
                        <td class="border-r-2 border-spacing-2 border-green-800 p-2 text-center">
                          <p hidden><?=$domanda["positiva"]?></p>
                          <?php if($domanda["positiva"] == 1) { ?>
                            <i class="fa-solid fa-plus"></i>
                          <?php } else { ?>
                            <i class="fa-solid fa-minus"></i>
                          <?php } ?>
                        </td>
                        <td class="border-r-2 border-spacing-2 border-green-800 p-2 text-center"></td>
                        <td hidden><?=$domanda["CATEGORIE_idCATEGORIA"]?></td>
                        <td hidden><?=$domanda["codDomanda"]?></td>
                        <td class="border-r-2 border-spacing-2 border-green-800 p-2 text-center"></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
                <input type="submit" id="crea" value="Crea" class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 text-black">
              </fieldset>
            </form>
            <button id="reset" type="button" class="border-green-800 mt-3 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Annulla</button>
          </div>
          <div id="ModifySurveys" class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2" hidden>
            <section id="Pagina1">
              <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Questionari presenti</h1>
              <table class="w-full">
                <tr class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md">
                  <th class="border-l-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[10%]">ID</th>
                  <th class="border-l-2 border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[70%]">Titolo</th>
                  <th class="border-l-2 border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[10%]">Elimina</th>
                  <th class="border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[10%]">Modifica</th>
                </tr>
                <?php
                  include __DIR__ . '/../php/api/api-admin-get-surveys-alterables.php';

                  foreach($questionari as $questionario):
                ?>
                  <tr name="modificaQuestionario" class="hover:cursor-pointer hover:bg-white hover:bg-opacity-50 rounded-xl">
                    <td class="border-l-2 border-spacing-2 border-green-800 text-center"><?=$questionario["codQuestionario"]?></td>
                    <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 text-center"><?=$questionario["titolo"]?></td>
                    <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 text-center"><button onclick="eliminaQuestionario(this.parentElement.parentElement.firstElementChild.innerHTML)">elimina</button></td>
                    <td class="border-r-2 border-spacing-2 border-green-800 text-center"><button onclick="modificaQuestionario(this.parentElement.parentElement)">modifica</button></td>
                  </tr>
                <?php
                  endforeach;
                  unset($questionario);
                ?>
              </table>
            </section>
            <section>
              <?php
                include __DIR__ . '/../php/api/api-get-sections.php';

                foreach($questionari as $questionario):
              ?>
                <form action="/api/api-admin-alter-survey.php" method="POST" name="alterSurveyForm" class="w-full">
                  <fieldset name="Pagina2" hidden>
                    <legend class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Modifica questionario</legend>
                    <label for="titolo">Id questionario:</label>
                    <input type="text" name="codQuestionario" value="<?=$questionario['codQuestionario']?>" class="text-black w-5 text-center" readonly>
                    <label for="titolo">Id moderatore:</label>
                    <input type="text" name="codModeratore" value="<?=$_SESSION["user_id"]?>" class="text-black w-5 text-center" readonly>
                    <label for="titolo">Titolo:</label>
                    <input type="text" name="titolo" value="<?=$questionario['titolo']?>" class="bg-green-800 p-2 text-center w-1/3">
                    <input type="hidden" id="numeroDomanda" name="numeroDomanda" value="" readonly>
                    <input type="hidden" id="peso" name="peso" value="" readonly>
                    <input type="hidden" id="codDomanda" name="codDomanda" value="" readonly>
                    <input type="hidden" id="sezione" name="sezione" value="" readonly>
                    <div>
                      <div>
                        <label for="CategoriaAttuale">Categoria</label>
                        <select name="CategoriaAttuale" class="mb-1 p-2 rounded-xl shadow-md text-black">
                          <option onclick="disponiDomande2('')">Seleziona categoria</option>
                        <?php foreach($categorie as $categoria): ?>
                            <option onclick="disponiDomande2(this.innerHTML)" value="0"><?=$categoria["nomeCategoria"]?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div>
                        <label for="SezioneAttuale">Sezione</label>
                        <select name="SezioneAttuale" class="mb-1 p-2 rounded-xl shadow-md text-black">
                          <?php
                            $codQuestionario = $questionario["codQuestionario"];
                            include __DIR__ . '/../php/api/api-get-sections.php';

                            foreach($sezioni as $sezione):
                          ?>
                            <option name="secOption" onclick="setValue(this)" value="0"><?=$sezione["nome"]?></option>
                          <?php
                            endforeach;
                          ?>
                        </select>
                        <p hidden></p>
                      </div>
                    </div>
                    <div class="overflow-auto box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 max-h-72 mt-2">
                      <table class="overflow-auto w-full">
                        <tbody>
                          <tr class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md" name="intestazione2" hidden>
                            <th class="border-l-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[10%] text-center">Inserita</th>
                            <th class="border-l-2 border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[70%]">Testo</th>
                            <th class="border-l-2 border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Numero</th>
                            <th class="border-l-2 border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Peso</th>
                            <th class="border-l-2 border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Sezione</th>
                            <th class="border-r-2 border-b-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">Impatto</th>
                          </tr>
                          <?php
                            include __DIR__ . '/../php/api/api-admin-get-questions-survey.php';

                            unset($domanda);
                            unset($valoriAggiunti);
                            foreach ($domande as $domanda):
                          ?>
                            <tr name="domanda" hidden>
                              <td name="<?=$codQuestionario?>" class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">
                                <?php if($domanda["numero"] != ''): ?>
                                  <button name="rimuoviDomanda" type="button" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">Rimuovi</button>
                                <?php else: ?>
                                  <button name="aggiungiDomanda" type="button" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl">Aggiungi</button>
                                <?php endif; ?>
                              </td>
                              <td hidden>
                                <?php if($domanda["numero"] != ''): ?>
                                  <input type="hidden" name="codDomandaSingolo2" value="<?=$domanda["codDomanda"]?>">
                                <?php else: ?>
                                  <?=$domanda["codDomanda"]?>
                                <?php endif; ?>
                              </td>
                              <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[70%]"><?=$domanda["testo"]?></td>
                              <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">
                                <?php if($domanda["numero"] != ''): ?>
                                  <input name="numeroDomandaSingolo2" type="number" value="<?=$domanda["numero"]?>" min="0" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700 w-12" required>
                                <?php endif; ?>
                              </td>
                              <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">
                                <?php if($domanda["numero"] != ''): ?>
                                  <input name="pesoSingolo2" type="number" value="<?=$domanda["peso"]?>" min="0" max="10" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" required>
                                <?php endif; ?>
                              </td>
                              <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">
                                <?php if($domanda["numero"] != ''): ?>
                                  <input type="text" name="sezioneSingola2" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" value="<?=$domanda["sezione"]?>" readonly required>
                                <?php endif; ?>
                              </td>
                              <td class="border-l-2 border-r-2 border-spacing-2 border-green-800 p-2 w-[5%] text-center">
                                <p hidden><?=$domanda["positiva"]?></p>
                                <?php if($domanda["positiva"] == 1) { ?>
                                  <i class="fa-solid fa-plus"></i>
                                <?php } else { ?>
                                  <i class="fa-solid fa-minus"></i>
                                <?php }?>
                              </td>
                              <td hidden><?=$domanda["CATEGORIE_idCATEGORIA"]?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </fieldset>
                  <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 text-black" type="submit" value="Modifica" name="modify" hidden>
                  <input type="hidden" name="commento" readonly>
                </form>
              <?php endforeach; ?>
              <section class="flex flex-col gap-2">
                <div id="Pagina3" class="p-2 bg-black bg-opacity-20 rounded-xl shadow-md" hidden>
                  <label class="block font-bold mb-2 bg-opacity-20 rounded-xl shadow-md" for="commento">Descrizione</label>
                  <textarea class="bg-green-900 px-2 py-1 ring-1 w-full h-32 text-start ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" id="commento" maxlength="1024"></textarea>
                </div>
              </section>
              <div>
                <button id="previous" enabled="false" hidden class="border-green-800 mt-3 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Precedente</button>
                <button id="next" enabled="false" hidden class="border-green-800 mt-3 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1">Successivo</button>
              </div>
            </section>
          </div>
          <div>
            <form id="removeSurveyForm" action="/api/api-admin-remove-survey.php" method="POST" hidden>
              <input type="text" name="codQuestionario">
            </form>
            <p id="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl text-black"></p>
          </div>
        </div>
        <div class="flex"><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Menù principale</a></div>
      </div>
      <script src="javascript/AdminSurveys.js"></script>
      <?php } else { ?>
      <div>
        <a href="index.php">Solo i moderatori possono aggiungere o alterare questionari</a>
      </div>
    <?php } ?>
  </body>
</html>
