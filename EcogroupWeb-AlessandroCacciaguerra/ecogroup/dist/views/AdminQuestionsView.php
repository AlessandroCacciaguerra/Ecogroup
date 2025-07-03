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
    <title>ecogroup-adminquestions</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'moderator')) { ?>
      <div class="bg-site-primary bg-opacity-70 backdrop-blur-md drop-shadow-lg border-green-600 p-10 rounded-lg min-h-[60%] w-5/6 mx-auto text-gray-200">
        <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Domande</h1>
        <div class="flex gap-3 flex-col md:flex-row justify-between">
          <select class="CATEGORIE bg-black bg-opacity-20 p-2 rounded-xl shadow-md">
            <option id="Aggiungi" class="border border-site-secondary rounded-lg px-3 py-1 mb-2 hover:bg-site-primary cursor-pointer" value="Aggiungi">Aggiungi</option>
            <option id="Modifica" class="border border-site-secondary rounded-lg px-3 py-1 mb-2 hover:bg-site-primary cursor-pointer" value="Modifica" selected hidden>Modifica</option>
            <option id="Categorie" class="border border-site-secondary rounded-lg px-3 py-1 mb-2 hover:bg-site-primary cursor-pointer" value="Categorie">Categorie</option>
          </select>
          <div id="AddQuestions" class="w-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2" hidden>
            <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Aggiunta domanda</h1>
            <form action="/api/api-admin-add-question.php" method="POST" id="addQuestionForm">
              <input type="hidden" name="codModeratore" value="<?=$_SESSION['user_id']?>" readonly>
              <div class="mb-4">
                <label for="domandaText1" class="block font-bold mb-2">Testo della domanda</label>
                <textarea id="domandaText1" name="testo" maxlength="1024" class="bg-green-900 px-2 py-1 ring-1 w-full h-32 text-start ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" required></textarea>
              </div>
              <div class="flex justify-between self-center">
                <div class="mb-4">
                  <input type="checkbox" id="positiveImpact1" name="isPositive" class="mr-2 leading-tight bg-green-800">
                  <label for="positiveImpact1" class="font-bold">Impatto positivo</label>
                  <p class="text-xs">(Una domanda con impatto negativo sul risultato avrà pesi di segno negativo - da 0 a -1)</p>
                </div>
                <div class="mb-4">
                  <label for="category1" class="font-bold mb-2 mr-2">Categoria</label>
                  <select id="category1" name="categoria" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" required>
                    <?php
                      include __DIR__ . '/../php/api/api-get-category.php';

                      foreach($categorie as $categoria):
                    ?>
                      <option value="<?=$categoria["nomeCategoria"]?>"><?=$categoria["nomeCategoria"]?></option>
                      <?php
                        endforeach;
                        unset($scategoria);
                      ?>
                  </select>
                </div>
              </div>
              <div class="mb-4">
                <label for="risposte">Possibili risposte</label>
                <div class="flex gap-2">
                  <p class="text-xs pb-2">(premi "/" una volta digitata - non meno di due alternative)</p>
                  <p>I pesi delle risposte hanno valore crescente - in ordine di inserimento - da 0 a 1; più elementi si inseriscono, minore sarà la differenza (costante) fra i valori di risposte adiacenti</p>
                </div>
                <textarea id="risposte" name="risposte" pattern="([\w\s]/){2,}" class="bg-green-900 px-2 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md w-full" required></textarea>
              </div>
              <div class="flex justify-center">
                <input type="submit" value="aggiungi" class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 w-1/4 text-black">
              </div>
            </form>
          </div>
          <div id="ModifyQuestions" class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2">
            <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Domande presenti</h1>
            <section id="primaPagina">
              <label class="font-Inter text-xl mb-1 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Categoria</label>
              <select id="CategoriaAttuale" name="CategoriaAttuale" class="bg-green-900 p-2 mt-1 mx-1 rounded-md ring-1 ring-inset ring-green-700">
                <option name="catOption" onclick="domandeInCategoria('')">Seleziona categoria</option>
                <?php foreach($categorie as $categoria): ?>
                  <option name="catOption" onclick="domandeInCategoria(this.innerHTML)"><?=$categoria["nomeCategoria"]?></option>
                <?php
                  endforeach;
                  unset($scategoria);
                ?>
              </select>
              <div>
                <table class="w-full mt-4">
                  <tr id="tableHead" class="bg-black bg-opacity-20 p-2 rounded-xl shadow-md" hidden>
                    <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[5%]">ID</th>
                    <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[70%]">Testo</th>
                    <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[5%]">Impatto</th>
                    <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[10%]">Risposte</th>
                    <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[5%]"> Rimuovi</th>
                    <th class="border-l-2 border-spacing-2 border-green-800 p-2 w-[5%]">Modifica</th>
                  </tr>
                  <?php
                    foreach($categorie as $categoria):
                      include __DIR__ . '/../php/api/api-admin-get-questions-alterables.php';

                      foreach($message as $domanda):
                  ?>
                    <tr name="domanda" class="hover:cursor-pointer hover:bg-white hover:bg-opacity-50 rounded-xl" hidden>
                      <td hidden><?=$categoria["nomeCategoria"]?></td>
                      <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center"><?=$domanda["codDomanda"]?></td>
                      <td class="border-l-2 border-spacing-2 border-green-800 p-2"><?=$domanda["testo"]?></td>
                      <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" name="<?=$domanda['positiva']?>">
                        <p hidden><?=$domanda['positiva']?></p>
                        <?php if($domanda["positiva"] == 1) { ?>
                          <i class="fa-solid fa-plus"></i>
                        <?php } else { ?>
                          <i class="fa-solid fa-minus"></i>
                        <?php } ?>
                      </td>
                      <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center"><?php include __DIR__ . '/../php/api/api-admin-get-question-answers.php'; ?><?=$scelte[0]["valore"]?><?php for($i=1; $i<count($scelte); $i++) {?>/<?=$scelte[$i]["valore"]?><?php } ?></td>
                      <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" name="eliminaDomanda"> 
                        <button name="removeQuestionButton" onclick="eliminaDomanda(this.parentElement.parentElement.children[1].innerHTML)" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">elimina</button>
                      </td>
                      <td class="border-l-2 border-spacing-2 border-green-800 p-2 text-center" name="modificaDomanda"> 
                        <button name="alterQuestionButton" onclick="modificaDomanda(this.parentElement.parentElement.children[1].innerHTML,this.parentElement.parentElement.children[2].innerHTML,this.parentElement.parentElement.children[3].firstElementChild.innerHTML,this.parentElement.parentElement.children[0].innerHTML,this.parentElement.parentElement.children[4].innerHTML)" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">modifica</button>
                      </td>
                    </tr>
                  <?php
                      endforeach;
                      unset($domanda);
                    endforeach;
                    unset($categoria);
                  ?>
                </table>
              </div>
            </section>
            <section id="secondaPagina" hidden>
              <form action="/api/api-admin-alter-question.php" method="POST" id="alterQuestionForm">
                <legend class="font-Inter text-xl mb-1 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Modifica</legend>
                <input type="hidden" id="cod" name="cod" required>
                <div class="mb-4">
                  <label for="domandaText2">Testo della domanda</label>
                  <textarea id="domandaText2" name="testo" maxlength="1024" class="text-black" required></textarea>
                </div>
                <div class="flex justify-between self-center">
                  <div class="mb-4">
                    <input type="checkbox" id="positiveImpact2" name="isPositive">
                    <label for="positiveImpact2">Impatto positivo</label>
                  </div>
                  <div class="mb-4">
                    <label for="category2">Categoria</label>
                    <select id="category2" class="bg-green-900 p-2 mt-1 mx-1 rounded-md ring-1 ring-inset ring-green-700" name="categoria" required>
                      <?php foreach($categorie as $categoria): ?>
                        <option><?=$categoria["nomeCategoria"]?></option>
                      <?php
                        endforeach;
                        unset($categoria);
                      ?>
                    </select>
                  </div>
                  <div class="mb-4">
                    <label for="risposteText2">Risposte</label>
                    <textarea id="risposteText2" name="testoRisposte" maxlength="1024" class="text-black" required></textarea>
                  </div>
                </div>
                <div class="flex justify-center">
                  <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 w-1/4 text-black" id="indietro" type="reset" value="annulla">
                  <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 w-1/4 text-black" id="altera" type="submit" value="modifica" enabled="false">
                </div>
              </form>
            </section>
            <form action="/api/api-admin-remove-question.php" method="POST" id="removeQuestionForm" hidden>
              <input type="hidden" name="codDomanda" readonly required>
              <input type="hidden" name="index" readonly required>
            </form>
          </div>
          <div id="AddCategory" class="gap-2 w-full max-h-full bg-black bg-opacity-20 p-2 rounded-xl shadow-md mb-2" hidden>
            <h1 class="font-Inter text-3xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md">Categorie</h1>
            <div class="flex justify-center gap-2">
              <div class="w-1/2 text-center box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 h-fit">
                <form action="/api/api-admin-add-category.php" method="POST" id="addCategoryForm" class="flex flex-col gap-2 text-left">
                  <label class="font-Inter text-xl mb-3 bg-black bg-opacity-20 w-full p-2 rounded-xl shadow-md" for="categoria">Aggiungi categoria:</label>
                  <input class="bg-green-900 px-2 py-1 ring-1 ring-inset ring-green-700 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-md" type="text" id="categoria" name="categoria" required>
                  <input class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary my-1 text-black" type="submit" value="aggiungi">
                </form>
                <div class="w-1/2 box-border bg-black bg-opacity-20 rounded-xl shadow-md p-2 max-h-96">
                  <h3 class="font-Inter text-xl mb-3 bg-black bg-opacity-20 p-2 rounded-xl shadow-md">Già presenti:</h3>
                  <p class="text-xs">Le categorie senza domande</br>associate si possono cancellare</p>
                  <ul class="h-[85%] overflow-auto">
                    <?php
                      $flag = false;
                      foreach($categorie as $categoria):
                    ?>
                      <li class="mb-2">
                        <div class="flex flex-auto gap-2">
                          <p class="bg-black bg-opacity-20 shadow-md px-2 rounded-full py-1"><?=$categoria["codCategoria"]?></p>
                          <p class="bg-black bg-opacity-20 shadow-md px-2 mr-1 rounded-xl w-full pl-3 py-1"><?=$categoria["nomeCategoria"]?></p>
                          <?php
                            include __DIR__ . '/../php/api/api-admin-get-category-questions.php';
                            if(count($questions) == 0):
                          ?>
                            <button name="removeCategoryButton" onclick="eliminaCategoria(this.parentElement.children[1].innerHTML)" class="bg-site-error bg-opacity-60 border border-site-error text-xs p-3 rounded-xl">elimina</button>
                          <?php
                              $flag = true;
                            endif;
                          ?>
                        </div>
                      </li>
                    <?php
                      endforeach;
                      unset($categoria);
                      if($flag):
                    ?>
                      <form id="removeCategoryForm" action="/api/api-admin-remove-category.php" method="POST">
                        <input type="hidden" name="nomeCategoria" readonly required>
                      </form>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div>
            <p id="risultato" class="bg-site-secondary bg-opacity-60 border border-site-secondary text-xs p-3 rounded-xl text-black"></p>
          </div>
        </div>
        <div class="flex"><a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md text-white" href="index.php">Menù principale</a></div>
      </div>
      <script src="javascript/AdminQuestions.js"></script>
    <?php } else { ?>
      <div>
        <a href="index.php">Solo i moderatori possono operare sulle domande dei questionari</a>
      </div>
    <?php } ?>
  </body>
</html>
