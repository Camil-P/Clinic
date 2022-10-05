const logoutBtn = document.querySelector("#logout-patient");
console.log(logoutBtn);

console.log("tu sam rodjace");

logoutBtn?.addEventListener("click", (el) => {
  el.preventDefault();

deleteCookie('accessToken')
window.location.href = "http://127.0.0.1:5500/Client/index.html";

});
