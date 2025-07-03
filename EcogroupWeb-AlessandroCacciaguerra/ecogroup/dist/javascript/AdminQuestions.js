const domande = document.getElementsByName("domanda");

const codiceDomanda = document.getElementById("cod");
const testoDomanda = document.getElementById("domandaText2");
const impattoDomanda = document.getElementById("positiveImpact2");
const categoriaDomanda = document.getElementById("category2");
const testoRisposte = document.getElementById("risposteText2");

const intestazione = document.getElementById("tableHead");
const primaPagina = document.getElementById("primaPagina");
const secondaPagina = document.getElementById("secondaPagina");
const indietro = document.getElementById("indietro");
const altera = document.getElementById("altera");

const risultato = document.getElementById("risultato");

const addQuestionForm = document.getElementById("addQuestionForm");
const removeQuestionForm = document.getElementById("removeQuestionForm");
const alterQuestionForm = document.getElementById("alterQuestionForm");
const addCategoryForm = document.getElementById("addCategoryForm");
const removeCategoryForm = document.getElementById("removeCategoryForm");

const AddQuestions = document.getElementById("AddQuestions");
const ModifyQuestions = document.getElementById("ModifyQuestions");
const AddCategory = document.getElementById("AddCategory");

const Aggiungi = document.getElementById("Aggiungi");
const Modifica = document.getElementById("Modifica");
const Categorie = document.getElementById("Categorie");

function domandeInCategoria(categoriaSelezionata) {
  intestazione.hidden = true;
  for(let i=0; i<domande.length; i++) {
    if(domande[i].firstElementChild.innerHTML == categoriaSelezionata) {
      intestazione.hidden = false;
      domande[i].hidden = false;
    } else {
      domande[i].hidden = true;
    }
  }
}

function modificaDomanda(codice, testo, impatto, categoria, risposte) {
  primaPagina.hidden = true;
  secondaPagina.hidden = false;
  codiceDomanda.value = codice;
  testoDomanda.value = testo;
  if(impatto == 1) {
    impattoDomanda.checked = true;
  } else {
    impattoDomanda.checked = false;
  }
  for(let i=0; i<categoriaDomanda.childElementCount; i++) {
    if(categoriaDomanda.children[i].innerHTML == categoria) {
      categoriaDomanda.children[i].selected = true;
      break;
    }
  }
  testoRisposte.innerHTML = risposte;
  altera.enabled = true;
}

function eliminaDomanda(codDomanda) {
  removeQuestionForm.firstElementChild.value = codDomanda;
  removeQuestionForm.children[1].value = alterQuestionForm.children[3].children[1].children[1].selectedIndex;
  removeQuestionForm.submit();
/*  fetch(removeQuestionForm.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(removeQuestionForm))
  }).then((response) => response.text())
  .then((response) => {
      self.location.replace = response;
  })
  .catch(err => risultato.innerHTML = err);*/
}

function eliminaCategoria(nomeCategoria) {
  removeCategoryForm.firstElementChild.value = nomeCategoria;
  removeCategoryForm.submit();
/*  fetch(removeCategoryForm.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(removeCategoryForm))
  }).then((response) => response.text())
  .then((response) => {
      self.location.replace = response;
  })
  .catch(err => risultato.innerHTML = err);*/
}

function AQaction() {
  AddQuestions.hidden = false;
  ModifyQuestions.hidden = true;
  AddCategory.hidden = true;

  Aggiungi.hidden = true;
  Modifica.hidden = false;
  Categorie.hidden = false;
}

function MQaction() {
  AddQuestions.hidden = true;
  ModifyQuestions.hidden = false;
  AddCategory.hidden = true;

  Aggiungi.hidden = false;
  Modifica.hidden = true;
  Categorie.hidden = false;
}

function ACaction() {
  AddQuestions.hidden = true;
  ModifyQuestions.hidden = true;
  AddCategory.hidden = false;

  Aggiungi.hidden = false;
  Modifica.hidden = false;
  Categorie.hidden = true;
}

addQuestionForm.addEventListener("submit", (event) => {
  event.preventDefault();
  fetch(addQuestionForm.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(addQuestionForm))
  }).then((response) => response.text())
  .then((response) => {
      if(response == '') {
        window.location.search = "http://localhost:8080/AdminQuestionsView.php?start=AQ";
      } else {
        risultato.innerHTML = response;
      }
  })
  .catch(err => risultato.innerHTML = err)
});

alterQuestionForm.addEventListener("submit", (event) => {
  event.preventDefault();
  fetch(alterQuestionForm.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(alterQuestionForm))
  }).then((response) => response.text())
  .then((response) => {
      if(response == '') {
        window.location.search = "http://localhost:8080/AdminQuestionsView.php?start=MQa" + alterQuestionForm.children[3].children[1].children[1].selectedIndex;
      } else {
        risultato.innerHTML = response;
      }
  })
  .catch(err => risultato.innerHTML = err)
});

addCategoryForm.addEventListener("submit", (event) => {
  event.preventDefault();
  fetch(addCategoryForm.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(addCategoryForm))
  }).then((response) => response.text())
  .then((response) => {
      if(response == '') {
        window.location.search = "http://localhost:8080/AdminQuestionsView.php?start=ACa";
      } else {
        risultato.innerHTML = response;
      }
  })
  .catch(err => risultato.innerHTML = err)
});

indietro.addEventListener("click", function() {
  altera.enabled = false;
  secondaPagina.hidden = true;
  primaPagina.hidden = false;
});

Aggiungi.addEventListener('click', function() {AQaction(); risultato.innerHTML = '';});

Modifica.addEventListener('click', function() {MQaction(); risultato.innerHTML = '';});

Categorie.addEventListener('click', function() {ACaction(); risultato.innerHTML = '';});

document.addEventListener("DOMContentLoaded", function() {
  if((new URLSearchParams(window.location.search)).has("start")) {
    let inizio = (new URLSearchParams(window.location.search)).get("start");
    if(inizio.substring(0,2) == 'AQ') {
      Aggiungi.click();
      Aggiungi.setAttribute("selected",true);
      risultato.innerHTML = "Domanda aggiunta con successo";
    } else if(inizio.substring(0,2) == 'AC') {
      Categorie.click();
      Categorie.setAttribute("selected",true);
      if(inizio[2] == 'a') {
        risultato.innerHTML = "Categoria aggiunta con successo";
      } else {
        if(inizio[2] == '0') {
          risultato.innerHTML = "Categoria rimossa con successo";
        } else {
          risultato.innerHTML = "Errore nell'esecuzione della query";
        }
      }
    } else if(inizio.substring(0,2) == 'MQ') {
      Modifica.click();
      Modifica.setAttribute("selected",true);
      if(inizio[2] == 'a') {
        risultato.innerHTML = "Domanda alterata con successo";
      } else {
        if(inizio[2] == '0') {
          risultato.innerHTML = "Domanda rimossa con successo";
        } else {
          risultato.innerHTML = "Errore nell'esecuzione della query";
        }
      }
      primaPagina.children[1].selectedIndex = parseInt(inizio.substring(3))+1;
      primaPagina.children[1].children[primaPagina.children[1].selectedIndex].click();
    }
    history.pushState(null, "", location.href.split("&s")[0]);
  } else {
    Modifica.click();
    Modifica.setAttribute("selected",true);
  }
});
