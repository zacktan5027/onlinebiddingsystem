$(document).ready(function () {
  $('input[name="password"]').keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which === 32) {
      return false;
    }
  });
  $("input[name='confirmPassword']").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which === 32) {
      return false;
    }
  });
});

function checkEditStaff(form) {
  form.classList.add("was-validated");

  let password = form.password.value;
  let confirmPassword = form.password.value;

  let emptyField = "";
  let filled = true;

  if (password === "") {
    form.password.value = "";
    filled = false;
  }
  if (confirmPassword === "") {
    form.confirmPassword.value = "";
    filled = false;
  }

  if (filled === false) {
    return filled;
  } else {
    return filled;
  }
}
