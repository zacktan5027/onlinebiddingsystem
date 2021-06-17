$(document).ready(function () {
  //do not allow space in username field
  $("#username").keypress(function (e) {
    if (e.which === 32) return false;
  });

  //do not allow space in password field
  $("#password").keypress(function (e) {
    if (e.which === 32) return false;
  });

  //do not allow space in confirm password field
  $("#confirmPassword").keypress(function (e) {
    if (e.which === 32) return false;
  });

  //do not allow space in email field
  $("#email").keypress(function (e) {
    if (e.which === 32) return false;
  });

  //do not allow space in phone number field
  $("#phoneNumber").keypress(function (e) {
    if (e.which === 32) return false;
  });

  $("#phoneNumber").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      if (e.which === 32) {
        return false;
      } else {
        //display error message
        $("#phone_error_msg").html("Number only").show().fadeOut("slow");
        return false;
      }
    }
  });
  $(document).mouseup(function (e) {
    var container = $(".requirement-body");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      $(".collapse").collapse("hide");
    }
  });

  let password = document.getElementById("password");
  let passwordVisible = document.getElementById("passwordVisible");
  let confirmPassword = document.getElementById("confirmPassword");
  let confirmPasswordVisible = document.getElementById(
    "confirmPasswordVisible"
  );
  let phoneNumber = document.getElementById("phoneNumber");

  //validare the password when the user is typing
  password.onkeyup = function () {
    // validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if (password.value.match(lowerCaseLetters)) {
      lowerCase.classList.remove("invalid");
      lowerCase.classList.add("valid");
    } else {
      lowerCase.classList.remove("valid");
      lowerCase.classList.add("invalid");
    }

    // validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if (password.value.match(upperCaseLetters)) {
      upperCase.classList.remove("invalid");
      upperCase.classList.add("valid");
    } else {
      upperCase.classList.remove("valid");
      upperCase.classList.add("invalid");
    }

    // validate numbers
    var numbers = /[0-9]/g;
    if (password.value.match(numbers)) {
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }

    // validate length
    if (password.value.length >= 8) {
      passwordLength.classList.remove("invalid");
      passwordLength.classList.add("valid");
    } else {
      passwordLength.classList.remove("valid");
      passwordLength.classList.add("invalid");
    }
  };

  passwordVisible.onclick = function () {
    if (passwordVisible.checked == true) {
      password.type = "text";
    } else {
      password.type = "password";
    }
  };

  //check whether the confirm password is same with the password enter previously
  confirmPassword.onkeyup = function () {
    if (
      document.getElementById("confirmPassword").value ==
      document.getElementById("password").value
    ) {
      match.classList.remove("invalid");
      match.classList.add("valid");
    } else {
      match.classList.remove("valid");
      match.classList.add("invalid");
    }
  };

  confirmPasswordVisible.onclick = function () {
    if (confirmPasswordVisible.checked == true) {
      confirmPassword.type = "text";
    } else {
      confirmPassword.type = "password";
    }
  };

  phoneNumber.onkeyup = function () {
    let phone_number = phoneNumber.value;
    phone_number = phone_number.replace(/[^0-9]/g, "");
    let block1 = "";
    let block2 = "";
    let block3 = "";
    let formatted = "";

    if (phone_number.length == 11) {
      block1 = phone_number.substring(0, 3);
      block2 = phone_number.substring(3, 7);
      block3 = phone_number.substring(7, 11);

      if (phone_number.length >= 4 && phone_number.length <= 7) {
        formatted = block1 + " " + block2;
        phoneNumber.value = formatted;
      } else if (phone_number.length >= 8 && phone_number.length <= 11) {
        formatted = block1 + " " + block2 + " " + block3;
        phoneNumber.value = formatted;
      } else {
        phoneNumber.value = phone_number;
      }
    } else {
      block1 = phone_number.substring(0, 3);
      block2 = phone_number.substring(3, 6);
      block3 = phone_number.substring(6, 10);

      if (phone_number.length >= 4 && phone_number.length <= 6) {
        formatted = block1 + " " + block2;
        phoneNumber.value = formatted;
      } else if (phone_number.length >= 7 && phone_number.length <= 10) {
        formatted = block1 + " " + block2 + " " + block3;
        phoneNumber.value = formatted;
      } else {
        phoneNumber.value = phone_number;
      }
    }
  };
});

//function to check the password and confirm password
function checkPassword(form) {
  var lowerCaseLetters = /[a-z]/g;
  var upperCaseLetters = /[A-Z]/g;
  var numbers = /[0-9]/g;

  if (form.password.value != form.confirmPassword.value) {
    alert("Password did not match: Please try again...");
    form.confirmPassword.focus();
    return false;
  }
  if (!form.password.value.match(lowerCaseLetters)) {
    alert("Password does not contain lower case letters: Please try again...");
    form.password.focus();
    return false;
  }

  if (!form.password.value.match(upperCaseLetters)) {
    alert("Password does not contain upper case letters: Please try again...");
    form.password.focus();
    return false;
  }

  if (!form.password.value.match(numbers)) {
    alert("Password does not contain numbers: Please try again...");
    form.password.focus();
    return false;
  }

  if (form.password.value.length < 8) {
    alert("Password does not have more than 8 characters: Please try again...");
    form.password.focus();
    return false;
  }
}
