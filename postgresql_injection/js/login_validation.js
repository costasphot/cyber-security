/**
 * js/login_validation.js
 * 
 * Full Name: George Constantine Fotopoulos
 * R.N.: 1117202200234
 */

function ValidateLoginForm() {
  const username_input = document.getElementById("username");
  const password_input = document.getElementById("password");

  if (username_input.value.trim() === "" || password_input.value.trim() === "") {
    alert("Please fill in both the username and password fields.");
    return false;
  }

  return true;
}
