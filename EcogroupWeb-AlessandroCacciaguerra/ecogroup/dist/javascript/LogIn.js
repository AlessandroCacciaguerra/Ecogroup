const loginform = document.getElementById("LoginForm");
const clueform = document.getElementById("ClueForm");
const address = document.getElementById("email");
const erroreForm = document.getElementById("erroreForm");

clueform.addEventListener("submit", (event) => {
  event.preventDefault();
  fetch(clueform.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(loginform))
  }).then((response) => response.text())
  .then((response) => {
      if(response.startsWith('mailto')) {
      console.log(response);
        mailWindow = window.open(response);
        mailWindow.close();
        erroreForm.innerHTML = "E-mail inviata all'indirizzo specificato (oggetto: 'Ecogroup password reminder')";
      } else {
        erroreForm.innerHTML = "L'indirizzo e-mail digitato non è presente sul sito o non ha indizio associato";
      }
  })
  .catch(err => erroreForm.innerHTML = err)
});

loginform.addEventListener("submit", (event) => {
  event.preventDefault();
  fetch(loginform.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(loginform))
  }).then((response) => response.text())
  .then((response) => {
      if(response[0] == '.') {
        self.location.replace(response);
      } else {
        erroreForm.innerHTML = response;
      }
  })
  .catch(err => erroreForm.innerHTML = err)
});
