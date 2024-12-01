function ValidarNombre() {
  let nombre = document.getElementById("usuario").value;
  let errorMessage = document.getElementById("nombreError");
  errorMessage.innerHTML = "";

  // validar que no este vacio que ono tenga numero y que tenga mas de 3 caracteres
  if (nombre === "") {
    errorMessage.innerHTML = "El nombre no puede estar vacío.";
    return false;
  }
  return true;
}

// que tenga mas de 6 caracteres que contenga letras y numeros y no este vacio
function ValidarContraseña() {
  let contraseña = document.getElementById("password").value;
  let errorPassword = document.getElementById("passwordError");
  errorPassword.innerHTML = "";
  if (contraseña === "") {
    errorPassword.innerHTML = "El nombre no puede estar vacío.";
    return false;
  }
  return true;
}
scripts.js



function ValidarFormulario() {
  return ValidarNombre() && ValidarContraseña();
}
