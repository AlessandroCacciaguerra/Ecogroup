const questionarioSelezionato = document.getElementsByTagName("form");
const questionarioCompilato = document.getElementsByTagName("section");
const sezioni = document.getElementsByName("sectionOption");
const domande = document.getElementsByName("domanda");
const formError = document.getElementById("formError");
const codDomande = document.getElementsByName("codDomande");
const valoreRisposte = document.getElementsByName("risposte");

document.addEventListener('DOMContentLoaded', function() {
  for (let i = 0; i < sezioni.length; i++) {
    sezioni[i].addEventListener("click", function() {selezionasezione(sezioni[i].innerHTML);});
  }

  for (let i = 0; i < questionarioSelezionato.length; i++) {
    questionarioSelezionato[i].addEventListener("submit", (event) => {
      event.preventDefault();
      codDomande[i].value = '';
      valoreRisposte[i].value = '';
      let scelta;
      for(j = 0; j < domande.length; j++) {
        if(domande[j].parentElement.parentElement == questionarioSelezionato[i]) {
          codDomande[i].value = codDomande[i].value + ' ' + domande[j].firstElementChild.firstElementChild.innerHTML;
          scelta = domande[j].lastElementChild.lastElementChild.lastElementChild;
          valoreRisposte[i].value = valoreRisposte[i].value + ' ' + scelta.options[scelta.selectedIndex].value;
        }
      }
      fetch(questionarioSelezionato[i].action, {
          method: 'POST',
          body: new URLSearchParams(new FormData(questionarioSelezionato[i]))
      }).then((response) => response.text())
      .then((response) => {
          if(response != '') {
            formError.innerHTML = response;
          } else {
            window.location.reload();
            formError.innerHTML = "Invio effettuato con successo"
          }
      })
      .catch(err => formError.innerHTML = err)
    });
  }
});

function selezionasezione(sezione) {
  for (let i = 0; i < questionarioCompilato.length; i++) {
    if (questionarioCompilato[i].id == sezione) {
      questionarioCompilato[i].hidden = false;
    } else {
      questionarioCompilato[i].hidden = true;
    }
  }
  for (let i = 0; i < questionarioSelezionato.length; i++) {
    if (questionarioSelezionato[i].name == sezione) {
      questionarioSelezionato[i].hidden = false;
    } else {
      questionarioSelezionato[i].hidden = true;
    }
  }
}