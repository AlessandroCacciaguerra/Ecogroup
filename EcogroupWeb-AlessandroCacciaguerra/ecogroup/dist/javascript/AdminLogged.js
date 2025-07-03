const mostraRisultati = document.getElementsByName("mostraRisultati");
const rows = document.getElementById("table_body");

const primaPagina = document.getElementById("primapagina");
const secondaPagina = document.getElementById("secondapagina");

document.addEventListener("DOMContentLoaded", function() {
  for(i=0; i<mostraRisultati.length; i++) {
    let id = mostraRisultati[i].parentElement.parentElement.children[1].firstElementChild.innerHTML;
    mostraRisultati[i].addEventListener("click", function() {
      primaPagina.toggleAttribute("hidden");
      secondaPagina.toggleAttribute("hidden");
      for(j=0; j<rows.childElementCount; j=j+2) {
        if(rows.children[j].firstElementChild.innerHTML == id) {
          rows.children[j].hidden = false;
          rows.children[j+1].hidden = false;
        } else {
          rows.children[j].hidden = true;
          rows.children[j+1].hidden = true;
        }
      }
    });
  }
});

function tornaIndietro() {
  secondaPagina.toggleAttribute("hidden");
  primaPagina.toggleAttribute("hidden");
}