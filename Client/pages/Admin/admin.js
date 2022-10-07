const logoutBtn = document.querySelector("#logout-doctor");

logoutBtn?.addEventListener("click", (el) => {
  el.preventDefault();

  deleteCookie("accessToken");
  deleteCookie("role");
  window.location.href = "http://127.0.0.1:5500/Client/index.html";
});

const modalProfile = document.getElementsByClassName(
  "container-register-doctor"
)[0];
const btn_profile = document.getElementById("add-btn");
const btnClose = document.getElementById("close-modal");
console.log(modalProfile);
console.log(modalProfile, btn_profile);

btn_profile.addEventListener("click", (el) => {
  modalProfile.style.display = "block";
});

btnClose.addEventListener("click", () => {
  modalProfile.style.display = "none";
});

//create dynamic table for doctors !!! ADMIN PAGE

const listDoctors = [
  {
    name: "Milos",
    surname: "Zukin",
    email: "Dentist",
    phonenumber: "9482428",
  },
  {
    name: "Milos",
    surname: "Zukin",
    email: "Dentist",
    phonenumber: "9482428",
  },
  {
    name: "Milos",
    surname: "Zukin",
    email: "Dentist",
    phonenumber: "9482428",
  },
];

const tableHeaders = document.getElementsByTagName("tbody")[0];
console.log(tableHeaders, "dwadawdwa");

function createDynamicTable(listDoctors) {
  listDoctors.forEach((doctor) => {
    let tr = document.createElement("tr");
    tableHeaders.append(tr);

    const tdName = document.createElement("td");
    const tdSurname = document.createElement("td");
    const tdEmail = document.createElement("td");
    const tdPhoneNumber = document.createElement("td");
    tr.append(tdName);
    tr.append(tdSurname);
    tr.append(tdEmail);
    tr.append(tdPhoneNumber);
    tdName.innerHTML = doctor.name;
    tdSurname.innerHTML = doctor.surname;
    tdEmail.innerHTML = doctor.email;
    tdPhoneNumber.innerHTML = doctor.phonenumber;
  });
}
createDynamicTable(listDoctors);

//Created user from Role

const form = document.getElementById("registerFromAdmin");
form.addEventListener(
  "submit",
  async (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const reqData = {};
    for (var [key, value] of formData.entries()) {
      reqData[key] = value;
    }
    res = await axios
      .post(
        "http://localhost/Clinic/Api/controllers/AdminController.php",
        JSON.stringify(reqData),
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      )
      .then((res) => {
        console.log(res)
        alert("You have successfully created an account");
        // window.location.href = "http://127.0.0.1:5500/Client/index.html";
      })
      .catch((err) => {
        const messageErr = err.response.data.messages
        
        alert(`Creating not successfully:  ${messageErr}`);
      });
  },
  false
);

