const signInForm = document.getElementById("SignInForm");
const primaPagina = document.getElementById("firstPage");
const secondaPagina = document.getElementById("secondPage");
const cambiaPagina =  document.getElementById("changePage");
const erroreForm =  document.getElementById("erroreForm");

cambiaPagina.addEventListener("click", function() {
  primaPagina.toggleAttribute("hidden");
  secondaPagina.toggleAttribute("hidden");
  if(cambiaPagina.innerHTML == "Ho letto") {
    cambiaPagina.innerHTML = "Indietro";
  } else {
    cambiaPagina.innerHTML = "Ho letto";
  }
});

signInForm.addEventListener("submit", (event) => {
  event.preventDefault();
  fetch(signInForm.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(signInForm))
  }).then((response) => response.text())
  .then((response) => {
      if(response[0] == '.') {
        window.location.replace(response);
      } else {
        erroreForm.innerHTML = response;
      }
  })
  .catch(err => erroreForm.innerHTML = err)
});
