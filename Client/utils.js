const getCookie = (cookieName) => {
  return document.cookie
    .split(";")
    .find((row) => row.includes(cookieName + "="))
    ?.split("=")[1];
};

// const setCookie = (cookieName, value, maxAge) => {
//   console.log(cookieName, value, maxAge);
//   console.log(maxAge ? "max-age=" + maxAge : "");
//   document.cookie = `${cookieName}=${value};${
//     maxAge ? "max-age=" + maxAge : ""
//   };path=/`;
// };

// const clearCookie = (cookieName) => {
//     const expireDate = new Date();
//     document.cookie = `${cookieName}="";expires=${
//         expireDate.getSeconds() + 5
//     };path=/`;

//     console.log(expireDate)
//   console.log(document.cookie)
// };

function setCookie(
  key,
  value,
  expireDays,
  expireHours,
  expireMinutes,
  expireSeconds
) {
  var expireDate = new Date();
  if (expireDays) {
    expireDate.setDate(expireDate.getDate() + expireDays);
  }
  if (expireHours) {
    expireDate.setHours(expireDate.getHours() + expireHours);
  }
  if (expireMinutes) {
    expireDate.setMinutes(expireDate.getMinutes() + expireMinutes);
  }
  if (expireSeconds) {
    expireDate.setSeconds(expireDate.getSeconds() + expireSeconds);
  }
  document.cookie =
    key +
    "=" +
    value +
    ";domain=" +
    window.location.hostname +
    ";path=/" +
    ";expires=" +
    expireDate.toUTCString();
}

function deleteCookie(name) {
  setCookie(name, "", null, null, null, 1);
}

function get_cookie(name) {
  return document.cookie.split(";").some((c) => {
    return c.trim().startsWith(name + "=");
  });
}
