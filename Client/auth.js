(function validation() {
  const accessToken = getCookie("accessToken");
  const role = getCookie("role");

  console.log(accessToken);
  if (!accessToken || accessToken === "") {
    window.location.href = "http://127.0.0.1:5500/Client/index.html";
  } else{
    switch (role) {
      case "Admin":
        "http://127.0.0.1:5500/Client/pages/Admin/admin.html";
        break;
      case "Patient":
        "http://127.0.0.1:5500/Client/pages/patient/patient.html";

        break;
      case "Doctor":
        "http://127.0.0.1:5500/Client/pages/Doctor/doctor.html";

        break;
      default:
        // window.location.href = "http://127.0.0.1:5500/Client/index.html";
        break;
    }

    // if (role === "Admin") {
    //   window.location.href =
    //     "http://127.0.0.1:5500/Client/pages/Admin/admin.html";
    // } else if (role === "Patient") {
    //   window.location.href =
    //     "http://127.0.0.1:5500/Client/pages/patient/patient.html";
    // } else if (role === "Doctor") {
    //   window.location.href =
    //     "http://127.0.0.1:5500/Client/pages/Doctor/doctor.html";
    // }
  }
})();
