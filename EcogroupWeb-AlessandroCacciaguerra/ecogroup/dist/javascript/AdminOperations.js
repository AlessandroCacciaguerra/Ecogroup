const addAdminForm = document.getElementById("addAdminForm");
const risultato =  document.getElementById("risultato");

addAdminForm.addEventListener("submit", (event) => {
  event.preventDefault();
  fetch(addAdminForm.action, {
      method: 'POST',
      body: new URLSearchParams(new FormData(addAdminForm))
  }).then((response) => response.text())
  .then((response) => {
      risultato.innerHTML = response;
  })
  .catch(err => risultato.innerHTML = err)
});