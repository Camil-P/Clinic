let inputs = document.querySelectorAll("input");

let errors = {
  ime_prezime: [],
  korisnicko_ime: [],
  email: [],
  loznika: [],
  ponovi_lozinku: [],
};

inputs.forEach((el) => {
  el.addEventListener("change", (e) => {
    let curentInput = e.target;
    let inputvalue = curentInput.value;
    let inputName = curentInput.getAttribute("name");
    if (inputvalue.length > 4) {
      errors[inputName] = [];
      switch (inputName) {
        case "ime_prezime":
          let validation = inputvalue.trim();
          validation = validation.split(" ");
          if (validation.length < 2) {
            errors[inputName].push("Moras napisati ime prezime");
          }
          break;
        case "email":
          if (!validateEmail(inputvalue)) {
            errors[inputName].push("Neisprvna email adresa");
          }
          break;

        case "ponovi_lozinku":
          let loznika = document.querySelector('input[name="lozinka"]').value;
          if (inputvalue !== loznika) {
            errors[inputName].push("loznike se ne poklapaju");
            console.log("Netacna lozinka");
          }
          break;
      }
    } else {
      errors[inputName] = ["Polje ne moze imati manje od 5 karaktera"];
    }

    populateErrors();
  });

  const populateErrors = () => {
    for (let elem of document.querySelectorAll("ul")) {
      elem.remove();
    }

    for (let key of Object.keys(errors)) {
      let input = document.querySelector(`input[name=${key}]`);
      let parentElement = document.querySelector(`input[name="${key}"]`);
      // .parentElement;
      let errorsElement = document.createElement("ul");
      // parentElement.appendChild(errorsElement);

      errors[key].forEach((error) => {
        let li = document.createElement("li");
        li.innerText = error;

        errorsElement.appendChild(li);
      });
    }
  };
});

const validateEmail = (email) => {
  if (
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(
      email
    )
  ) {
    return true;
  } else {
    return false;
  }
};

//Create user:

// function createUser(btn) {

//   console.log(btn);
//   console.log("tu sam");
//   btn.preventDefault();

//   var formEl = document.forms.formRegisterId;
//   var formData = new FormData(formEl);
// }

const form = document.getElementById("registerForm");
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
        "http://localhost/Clinic/Api/controllers/UserController.php",
        JSON.stringify(reqData),
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      )
      .then((res) => {
        alert("You have successfully created an account");
        window.location.href = "/var/www/html/Clinic/Client/index.html";

      })
      .catch((err) => {
        console.log(window.location);
        alert("Creating not successfully");
      });

    // console.log("render");
    // const xhttp = new XMLHttpRequest();
    // xhttp.open(
    //   "POST",
    //   "http://localhost/Clinic/Api/controllers/UserController.php"
    // );
    // xhttp.setRequestHeader("Content-Type", "application/json");
    // xhttp.onreadystatechange = function () {
    //   if (this.status == 201) {
    //     alert("Creation successful");
    //   }
    // };

    // xhttp.onreadystatechange = function () {
    //   elseif(this.status != 201 || this.status != 200);
    //    alert("Creation not successful");
    // };

    // xhttp.send(JSON.stringify(reqData));
  },
  false
);
