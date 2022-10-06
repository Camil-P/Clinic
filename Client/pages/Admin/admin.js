const logoutBtn = document.querySelector("#logout-doctor");


logoutBtn?.addEventListener("click", (el) => {
  el.preventDefault();

  deleteCookie("accessToken");
  deleteCookie("role");
  window.location.href = "http://127.0.0.1:5500/Client/index.html";
});


const modalProfile = document.getElementsByClassName("container-register-doctor")[0];
const btn_profile = document.getElementById("add-btn");
const btnClose = document.getElementById("close-modal");
console.log(modalProfile)
console.log(modalProfile, btn_profile);

btn_profile.addEventListener("click", (el) => {
  modalProfile.style.display = "block";
});

btnClose.addEventListener("click", () => {
  modalProfile.style.display = "none";
});