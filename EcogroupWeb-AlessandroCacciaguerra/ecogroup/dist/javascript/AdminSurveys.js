const AddSurvey = document.getElementById("AddSurvey");
const ModifySurveys = document.getElementById("ModifySurveys");

const Aggiungi = document.getElementById("Aggiungi");
const Modifica = document.getElementById("Modifica");

const risultato = document.getElementById("risultato");

/////////////////////////////////////////////////////////////////////////

const SezioniDaAggiungere = document.getElementById("sezioni");
const SezioneAttuale1 = document.getElementById("SezioneAttuale1");
const Crea = document.getElementById("crea");
const reset = document.getElementById("reset");
const addSurveyForm = document.getElementById("addSurveyForm");

const intestazione = document.getElementById("intestazione");
const secondPage = document.getElementById("secondPage");
const questions = document.getElementsByName("question");

const numeroDomanda = document.getElementById("numeroDomanda");
const peso = document.getElementById("peso");
const codDomanda = document.getElementById("codDomanda");
const sezione = document.getElementById("sezione");

let nextQuestionNumber1 = 0;

/////////////////////////////////////////////////////////////////////////

const domande = document.getElementsByName("domanda");

const primaPagina = document.getElementById("Pagina1");
const secondaPagina = document.getElementsByName("Pagina2");
const terzaPagina = document.getElementById("Pagina3");

const previousPage = document.getElementById("previous");
const nextPage = document.getElementById("next");

const alterSurveyForm = document.getElementsByName("alterSurveyForm");
const removeSurveyForm = document.getElementById("removeSurveyForm");

const modifySurvey = document.getElementsByName("modificaQuestionario");
const modify = document.getElementsByName("modify");

const intestazione2 = document.getElementsByName("intestazione2");
const commento = document.getElementById("commento");
const sezioniSelect = document.getElementsByName("SezioneAttuale");
const categorieSelect = document.getElementsByName("CategoriaAttuale");

let nextQuestionNumber2;
let lastVisitedPage;

/////////////////////////////////////////////////////////////////////////

Aggiungi.addEventListener('click', function() {
  AddSurvey.hidden = false;
  ModifySurveys.hidden = true;
});

Modifica.addEventListener('click', function() {
  AddSurvey.hidden = true;
  ModifySurveys.hidden = false;
});

/////////////////////////////////////////////////////////////////////////

reset.addEventListener("click", function() {
  questions.forEach((question) => {
    if(question.firstElementChild.firstElementChild.innerHTML == 'Rimuovi') {
      question.firstElementChild.firstElementChild.click();
    }
  });
  secondPage.hidden = true;
});

addSurveyForm.addEventListener("submit", (event) => {
    event.preventDefault();
});

Crea.addEventListener('click', function() {
    let numeri = document.getElementsByName("numeroDomandaSingolo1");
    let pesi = document.getElementsByName("pesoSingolo1");
    let codici = document.getElementsByName("codDomandaSingolo1");
    let sezioni = document.getElementsByName("sezioneSingola1");

    for(let i=0; i<codici.length; i++) {
        numeroDomanda.value += numeri[i].value + ' ';
        peso.value += pesi[i].value + ' ';
        codDomanda.value += codici[i].value + ' ';
        sezione.value += sezioni[i].value + '/';
    }
    
    fetch(addSurveyForm.action, {
        method: 'POST',
        body: new URLSearchParams(new FormData(addSurveyForm))
    }).then((response) => response.text())
    .then((response) => {
        if(response == '') {
            window.location.reload();
            risultato.innerHTML = "Questionario aggiunto con successo";
        } else {
            numeroDomanda.value = "";
            peso.value = "";
            codDomanda.value = "";
            sezione.value = "";
            risultato.innerHTML = response;
        }
    })
    .catch(err => risultato.innerHTML = err)
});

function prossimoNumeroDomanda1() {
    nextQuestionNumber1++;
    return nextQuestionNumber1;
}

function reimpostaNumeriDomande1(numberRemoved) {
    if(numberRemoved < nextQuestionNumber1) {
        let numeriDaReimpostare = document.getElementsByName("numeroDomandaSingolo1");
        for(let i=0; i<numeriDaReimpostare.length; i++) {
            if(numeriDaReimpostare[i].value > numberRemoved) {
                numeriDaReimpostare[i].value = numeriDaReimpostare[i].value - 1;
            }
        }
    }
    nextQuestionNumber1--;
}

for (let i=0; i<questions.length; i++) {
  questions[i].firstElementChild.firstElementChild.addEventListener("click", function() {
      if(questions[i].children[4].innerHTML == '') {
          questions[i].children[0].firstElementChild.innerHTML = 'Rimuovi';
          questions[i].children[2].innerHTML = '<input name="numeroDomandaSingolo1" type="number" value="' + prossimoNumeroDomanda1() + '" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700 w-12" readonly required>';
          if(questions[i].children[3].firstElementChild.innerHTML == '1') {
            questions[i].children[4].innerHTML = '<input name="pesoSingolo1" type="number" value="1" min="0" max="10" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" required>';
          } else {
            questions[i].children[4].innerHTML = '<input name="pesoSingolo1" type="number" value="-1" max="0" min="-10" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" required>';
          }
          questions[i].children[6].innerHTML = '<input type="hidden" name="codDomandaSingolo1" value="' + questions[i].children[6].innerHTML + '">';
          questions[i].children[7].innerHTML = '<input type="text" name="sezioneSingola1" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" value="' + SezioneAttuale1.value + '" readonly required>';
      } else {
          reimpostaNumeriDomande1(questions[i].children[2].firstElementChild.value);
          questions[i].children[0].firstElementChild.innerHTML = 'Aggiungi';
          questions[i].children[2].innerHTML = '';
          questions[i].children[4].innerHTML = '';
          questions[i].children[6].innerHTML = questions[i].children[6].innerHTML.replace('<input type="hidden" name="codDomandaSingolo1" value="','').replace('">','');
          questions[i].children[7].innerHTML = '';
      }
  });
}

function disponiDomande1(categoria) {
    let flag = true;
    for(i=0; i<questions.length; i++) {
        if(questions[i].children[5].innerHTML == categoria) {
            intestazione.hidden = false;
            flag = false;
            questions[i].hidden = false;
        } else {
            questions[i].hidden = true;
        }
    }
    if(flag) {
        intestazione.hidden = true;
    }
}

function aggiungiSezioni() {
  let sezioniPulite = SezioniDaAggiungere.value.split('/');
  let flag;
  for(i=0;i<sezioniPulite.length;i++) {
    if(sezioniPulite[i] != '') {
      flag = false;
      for(j=0;j<SezioneAttuale1.childElementCount;j++) {
        if (SezioneAttuale1.children[j].innerHTML == sezioniPulite[i]) {
          flag = true;
          break;
        }
      }
      if(!flag) {
        SezioneAttuale1.innerHTML += '<option>' + sezioniPulite[i] + '</option>';
        for(j=0;j<sezioniSelect.length;j++) {
          sezioniSelect[j].innerHTML += '<option>' + sezioniPulite[i] + '</option>';
        }
      }
    }
  }
  SezioniDaAggiungere.value = '';
}

/////////////////////////////////////////////////////////////////////////


function setValue(opzione) {
  opzione.parentElement.nextElementSibling.innerHTML = opzione.innerHTML;
}

function prossimoNumeroDomanda2(tabella) {
  for(let i=0; i<tabella.childElementCount-1; i++) {
    if(tabella.children[i+1].children[3].childElementCount > 0) {
      if(tabella.children[i+1].children[3].firstElementChild.value > nextQuestionNumber2) {
        nextQuestionNumber2 = tabella.children[i+1].children[3].firstElementChild.value;
      }
    }
  }
  nextQuestionNumber2++;
  return nextQuestionNumber2;
}

function reimpostaNumeriDomande2(numberRemoved, tabella) {
  if(numberRemoved < nextQuestionNumber2) {
    for(let i=0; i<tabella.childElementCount-1; i++) {
      if(tabella.children[i+1].children[3].childElementCount > 0) {
        if(tabella.children[i+1].children[3].firstElementChild.value > numberRemoved) {
          tabella.children[i+1].children[3].firstElementChild.value = tabella.children[i+1].children[3].firstElementChild.value - 1;
        }
      }
    }
  }
  nextQuestionNumber2--;
}

let selettore_sezioni;
let selettore_categorie;
let new_value;
for (let i=0; i<domande.length; i++) {
  if(domande[i].firstElementChild.firstElementChild.innerHTML == 'Rimuovi') {
    selettore_categorie = domande[i].parentElement.parentElement.parentElement.previousElementSibling.firstElementChild.lastElementChild;
    selettore_sezioni = domande[i].parentElement.parentElement.parentElement.previousElementSibling.lastElementChild.children[1];
    for(j=0;j<selettore_sezioni.childElementCount;j++) {
      if(selettore_sezioni.children[j].innerHTML == domande[i].children[5].firstElementChild.value) {
        selettore_sezioni.children[j].setAttribute("class", "bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-500 text-white");
        new_value = Number(selettore_sezioni.children[j].value);
        selettore_sezioni.children[j].setAttribute("value", (new_value++).toString());
        break;
      }
    }
    for(j=0;j<selettore_categorie.childElementCount;j++) {
      if(selettore_categorie.children[j].innerHTML == domande[i].lastElementChild.innerHTML) {
        selettore_categorie.children[j].setAttribute("class", "bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-500 text-white");
        new_value = Number(selettore_categorie.children[j].value);
        selettore_categorie.children[j].setAttribute("value", (new_value++).toString());
        break;
      }
    }
  }
  domande[i].firstElementChild.firstElementChild.addEventListener("click", function() {
    selettore_categorie = domande[i].parentElement.parentElement.parentElement.previousElementSibling.firstElementChild.lastElementChild;
    selettore_sezioni = domande[i].parentElement.parentElement.parentElement.previousElementSibling.lastElementChild.children[1];
    if(domande[i].firstElementChild.firstElementChild.innerHTML == 'Aggiungi') {
      domande[i].children[0].firstElementChild.innerHTML = 'Rimuovi';
      domande[i].children[1].innerHTML = '<input type="hidden" name="codDomandaSingolo2" value="' + domande[i].children[1].innerHTML.trim() + '">';
      domande[i].children[3].innerHTML = '<input name="numeroDomandaSingolo2" type="number" value="' + prossimoNumeroDomanda2(domande[i].parentElement) + '" min="0" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700 w-12" required>';
      if(domande[i].children[6].firstElementChild.innerHTML == '1') {
        domande[i].children[4].innerHTML = '<input name="pesoSingolo2" type="number" value="1" min="0" max="10" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" required>';
      } else {
        domande[i].children[4].innerHTML = '<input name="pesoSingolo2" type="number" value="-1" max="0" min="-10" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" required>';
      }
      domande[i].children[5].innerHTML = '<input type="text" name="sezioneSingola2" value="' + selettore_sezioni.nextElementSibling.innerHTML + '" class="bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-700" readonly required>';
      //evidenzia sezione se è nuova
      for(j=0;j<selettore_sezioni.childElementCount;j++) {
        if(selettore_sezioni.children[j].innerHTML == selettore_sezioni.nextElementSibling.innerHTML) {
          selettore_sezioni.children[j].setAttribute("class", "bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-500 text-white");
          new_value = Number(selettore_sezioni.getAttribute("value"));
          selettore_sezioni.children[j].setAttribute("value", (new_value++).toString());
          break;
        }
      }
      //evidenzia categoria se è nuova
      selettore_categorie.getAttribute("selected").setAttribute("class", "bg-green-900 p-1 rounded-md ring-1 ring-inset ring-green-500 text-white");
      new_value = Number(selettore_categorie.selected.getAttribute("value"));
      selettore_categorie.selected.setAttribute("value", (new_value++).toString());
    } else {
      let sezione_rimossa = domande[i].children[5].firstElementChild.value;
      reimpostaNumeriDomande2(domande[i].children[3].firstElementChild.value, domande[i].parentElement);
      domande[i].children[0].firstElementChild.innerHTML = 'Aggiungi';
      domande[i].children[1].innerHTML = domande[i].children[1].innerHTML.replace('<input type="hidden" name="codDomandaSingolo2" value="','').replace('">','');
      domande[i].children[3].innerHTML = '';
      domande[i].children[4].innerHTML = '';
      domande[i].children[5].innerHTML = '';
      //de-evidenzia sezione se è vuota
      for(j=0;j<selettore_sezioni.childElementCount;j++) {
        if(selettore_sezioni.children[j].innerHTML == sezione_rimossa) {
          new_value = Number(selettore_sezioni.children[j].getAttribute("value"));
          selettore_sezioni.children[j].setAttribute("value", (new_value--).toString());
          if(selettore_sezioni.children[j].getAttribute("value") == '0') {
            selettore_sezioni.children[j].setAttribute("class", "");
          }
          break;
        }
      }
      //de-evidenzia categoria se è vuota
      new_value = Number(selettore_categorie.selected.getAttribute("value"));
      selettore_categorie.selected.setAttribute("value", (new_value--).toString());
      if(selettore_categorie.selected.getAttribute("value") == '0') {
        selettore_categorie.selected.setAttribute("class", "");
      }
    }
  });
}

function disponiDomande2(categoria) {
  let flag = true;
  for (let i=0; i<domande.length; i++) {
    if(domande[i].lastElementChild.innerHTML == categoria) {
      for(let j=0; j<intestazione2.length; j++) {
        intestazione2[j].hidden = false;
      }
      flag = false;
      domande[i].hidden = false;
    } else {
      domande[i].hidden = true;
    }
  }
  if(flag) {
    for(let j=0; j<intestazione2.length; j++) {
      intestazione2[j].hidden = true;
    }
  }
}

for (let i=0; i<alterSurveyForm.length; i++) {
  alterSurveyForm[i].addEventListener("submit", (event) => {
    event.preventDefault();
  });

  secondaPagina[i].nextElementSibling.addEventListener("click", function() {
    for (let j=0; j<secondaPagina[i].children[12].firstElementChild.firstElementChild.childElementCount-1; j++) {
      if(secondaPagina[i].children[12].firstElementChild.firstElementChild.children[j+1].children[1].childElementCount > 0) {
        secondaPagina[i].children[7].value += secondaPagina[i].children[12].firstElementChild.firstElementChild.children[j+1].children[3].firstElementChild.value + ' ';
        secondaPagina[i].children[8].value += secondaPagina[i].children[12].firstElementChild.firstElementChild.children[j+1].children[4].firstElementChild.value + ' ';
        secondaPagina[i].children[9].value += secondaPagina[i].children[12].firstElementChild.firstElementChild.children[j+1].children[1].firstElementChild.value + ' ';
        secondaPagina[i].children[10].value += secondaPagina[i].children[12].firstElementChild.firstElementChild.children[j+1].children[5].firstElementChild.value + '/';
      }
    }
    alterSurveyForm[i].lastElementChild.value = commento.value;
    fetch(alterSurveyForm[i].action, {
        method: 'POST',
        body: new URLSearchParams(new FormData(alterSurveyForm[i]))
    }).then((response) => response.text())
    .then((response) => {
        if(response == '') {
          window.location.reload();
          risultato.innerHTML = "Questionario modificato con successo";
        } else {
            secondaPagina[i].children[7].value = '';
            secondaPagina[i].children[8].value = '';
            secondaPagina[i].children[9].value = '';
            secondaPagina[i].children[10].value = '';
            risultato.innerHTML = response;
        }
    })
    .catch(err => risultato.innerHTML = err)
  });

  sezioniSelect[i].firstElementChild.click();
}

function eliminaQuestionario(codice) {
  removeSurveyForm.firstElementChild.value = codice;
  removeSurveyForm.submit();
  window.location.reload();
}

function modificaQuestionario(questionarioSelezionato) {
  primaPagina.hidden = true;
  previousPage.hidden = false;
  nextPage.hidden = false;
  previousPage.enabled = true;
  nextPage.enabled = true;
  for (let i=0; i<secondaPagina.length; i++) {
    if(secondaPagina[i].children[2].value == questionarioSelezionato.firstElementChild.innerHTML) {
      secondaPagina[i].hidden = false;
      modify[i].hidden = false;
      lastVisitedPage = i;
      nextQuestionNumber2 = 0;
    } else {
      secondaPagina[i].hidden = true;
    }
  }
  for (let i=0; i<domande.length; i++) {
    domande[i].hidden = true;
  }
}

previousPage.addEventListener("click", function() {
  if(secondaPagina[lastVisitedPage].hidden == false) {
    primaPagina.hidden = false;
    secondaPagina[lastVisitedPage].hidden = true;
    modify[lastVisitedPage].hidden = true;
    previousPage.hidden = true;
    nextPage.hidden = true;
    previousPage.enabled = false;
    nextPage.enabled = false;
    for(let j=0; j<intestazione2.length; j++) {
      intestazione2[j].hidden = true;
    }
  } else if(terzaPagina.hidden == false) {
    nextPage.hidden = false;
    nextPage.enabled = true;
    secondaPagina[lastVisitedPage].hidden = false;
    terzaPagina.hidden = true;
  }
});

nextPage.addEventListener("click", function() {
  if(secondaPagina[lastVisitedPage].hidden == false) {
    nextPage.enabled = false;
    nextPage.hidden = true;
    secondaPagina[lastVisitedPage].hidden = true;
    terzaPagina.hidden = false;
  }
});