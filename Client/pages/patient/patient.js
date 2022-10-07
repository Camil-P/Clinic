const fetchDoctors = () => {
  axios
  .get(
    "http://localhost/Clinic/Api/controllers/PatientController.php?fetch=doctors",
    {
      headers: {
        "Authorization": token,
      },
    }
  )
  .then((res) => {
    console.log(res)
    alert("You have successfully created an account");
  })
  .catch(({response}) => {
    console.log(response.data);
    alert(response.data.messages[0]);
    throw err;
  });
};

fetch();

const logoutBtn = document.querySelector("#logout-patient");
console.log(logoutBtn);


logoutBtn?.addEventListener("click", (el) => {
  el.preventDefault();

  deleteCookie("accessToken");
  deleteCookie("role");
  window.location.href = "http://127.0.0.1:5500/Client/index.html";
});

const modalProfile = document.getElementsByClassName("modal-profile")[0];
const btn_profile = document.getElementById("profile-btn");
const btnClose = document.getElementById("close-modal");
console.log(modalProfile, btn_profile);

btn_profile.addEventListener("click", (el) => {
  modalProfile.style.display = "block";
});

btnClose.addEventListener("click", () => {
  modalProfile.style.display = "none";
});
