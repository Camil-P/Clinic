var dateFormField = document.getElementById("date");
dateFormField.value = formatDate(new Date());
const startingHourFormField = document.getElementById("startingHour");

const token = getCookie("accessToken");

let appointments = [];

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
      // console.log(res);
    })
    .catch(({ response }) => {
      console.log(response);
      alert(response);
      // throw err;
    });
};

fetchDoctors();

const fetchAppointments = () => {
  axios
    .get("http://localhost/Clinic/Api/controllers/AppointmentController.php", {
      headers: {
        Authorization: token,
      },
    })
    .then(({ data }) => {
      appointments = data.data;
      console.log(appointments);
      displayStartingHours(dateFormField.value);
    })
    .catch(({ response }) => {
      console.log(response.data);
      alert(response.data.messages[0]);
    });
};

fetchAppointments();

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

const form = document.getElementById("createAppointment");
form.addEventListener(
  "submit",
  async (event) => {
    event.preventDefault();

    const formData = new FormData(form);
    const reqData = {};
    for (var [key, value] of formData.entries()) {
      reqData[key] = key === "startingHour" ? parseInt(value) : value;
    }

    res = await axios
      .post(
        "http://localhost/Clinic/Api/controllers/AppointmentController.php",
        JSON.stringify(reqData),
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: token,
          },
        }
      )
      .then(({ data }) => {
        alert("Appointment created successfully.");
        window.location.reload();
      })
      .catch(({ response }) => {
        alert(response.data.messages[0]);
      });
  },
  false
);

const handleDateChange = (dateEl) => {
  console.log(dateEl.value);
  displayStartingHours(dateEl.value);
};

const displayStartingHours = (date) => {
  startingHourFormField.innerHTML = "";

  let appointmentStartingHours = appointments
    .filter((a) => a.date === date.toString())
    .map((a) => a.startingHour);

  for (let i = 8; i < 16; i++) {
    const optionEl = document.createElement('option');
    optionEl.value = i;
    if (appointmentStartingHours.includes(i)){
      optionEl.innerHTML = i + " Already appointed";
      optionEl.disabled = true;
    }
    else{
      optionEl.innerHTML = i;
    }
      startingHourFormField.appendChild(optionEl);
  }
};
