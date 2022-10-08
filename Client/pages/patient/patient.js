const token = getCookie("accessToken");
// const doctorsList = [];

const fetchDoctors = () => {
  axios
    .get(
      "http://localhost/Clinic/Api/controllers/PatientController.php?fetch=doctors",
      {
        headers: {
          Authorization: token,
        },
      }
    )
    .then((res) => {
      console.log(res);
      const doctorsList = res.data.data;
      createDoctorsList(doctorsList)
    })
    .catch((err) => {
      // console.log(err);
      // alert(err);
      // throw err;
    });
};



function createDoctorsList(listDoctors) {
  const doctorContainer = document.getElementById("doctors-container");
  
  listDoctors.forEach((doctor) => {
    doctorContainer.innerHTML += `<div class="doctors-card">
    <div class="doctors-image">
      <div class="image-doctors">
        <img class="img-doctor"
          src="https://cdn-prod.medicalnewstoday.com/content/images/articles/317/317991/doctor-in-branding-article.jpg"
          alt="doctors-card" />
      </div>
    </div>
    <div class="doctors-info">
      <div class="doctors-info-container">
        <h2>Doctor Name: ${doctor.name}</h2>
        <h2>Surname:${doctor.surname }</h2>
        <h2>Email: ${doctor.email} </h2>
        <h2>Gender:${doctor.gender}</h2>
        <h2>Phone number:${doctor.phoneNumber}</h2>
        <h2>Birth Place: ${doctor.birthPlace}</h2>
      </div>
    </div>
    <div class="doctors-select">
      <div class="button-container">
        <button class="btn-doctor">Your selected doctor</button>
        <button class="btn-doctor">Send message</button>
      </div>
    </div>
    </div>`;
  });
}

fetchDoctors();

const logoutBtn = document.querySelector("#logout-patient");

logoutBtn?.addEventListener("click", (el) => {
  el.preventDefault();

  deleteCookie("accessToken");
  deleteCookie("role");
  window.location.href = "http://127.0.0.1:5500/Client/index.html";
});

const modalProfile = document.getElementsByClassName("modal-profile")[0];
const btn_profile = document.getElementById("profile-btn");
const btnClose = document.getElementById("close-modal");

btn_profile.addEventListener("click", (el) => {
  modalProfile.style.display = "block";
});

btnClose.addEventListener("click", () => {
  modalProfile.style.display = "none";
});
