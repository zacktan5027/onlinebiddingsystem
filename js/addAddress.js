$(document).ready(function () {
  $("#address1").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (
      e.which != 32 &&
      e.which != 44 &&
      e.which != 46 &&
      (e.which < 48 || e.which > 57) &&
      (e.which < 65 || e.which > 90) &&
      (e.which < 97 || e.which > 122)
    ) {
      //display error message
      return false;
    }
  });

  $("#address2").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (
      e.which != 32 &&
      e.which != 44 &&
      e.which != 46 &&
      (e.which < 48 || e.which > 57) &&
      (e.which < 65 || e.which > 90) &&
      (e.which < 97 || e.which > 122)
    ) {
      //display error message
      return false;
    }
  });

  $("#city").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (
      e.which != 32 &&
      e.which != 44 &&
      e.which != 46 &&
      (e.which < 48 || e.which > 57) &&
      (e.which < 65 || e.which > 90) &&
      (e.which < 97 || e.which > 122)
    ) {
      //display error message
      return false;
    }
  });

  $("#postcode").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      //display error message
      $("#postcode_error_msg").html("Number only").show().fadeOut("slow");
      return false;
    }
  });

  $("#phoneNumber").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      //display error message
      $("#phone_error_msg").html("Number only").show().fadeOut("slow");
      return false;
    }
  });

  let phoneNumber = document.querySelector("#phoneNumber");

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

function checkAddress(form) {
  let name = form.querySelector("#name").value.trim();
  let address1 = form.querySelector("#address1").value.trim();
  let address2 = form.querySelector("#address2").value.trim();
  let city = form.querySelector("#city").value.trim();
  let state = form.querySelector("#state").value.trim();
  let postcode = form.querySelector("#postcode").value.trim();
  let phoneNumber = form.querySelector("#phoneNumber").value.trim();

  let emptyField = "";
  let filled = true;

  if (name === "") {
    emptyField += ", name ";
    form.querySelector("#name").value = "";
    filled = false;
  }
  if (address1 === "") {
    emptyField += ", address1 ";
    form.querySelector("#address1").value = "";
    filled = false;
  }
  if (address2 === "") {
    emptyField += ", address2 ";
    form.querySelector("#address2").value = "";
    filled = false;
  }
  if (city === "") {
    emptyField += ", city ";
    form.querySelector("#city").value = "";
    filled = false;
  }
  if (state === "") {
    emptyField += ", state ";
    form.querySelector("#state").value = "";
    filled = false;
  }
  if (postcode === "") {
    emptyField += ", postcode ";
    form.querySelector("#postcode").value = "";
    filled = false;
  }
  if (phoneNumber === "") {
    emptyField += ", phone number ";
    form.querySelector("#phoneNumber").value = "";
    filled = false;
  }

  if (filled === false) {
    alert("Please fill up " + emptyField);
    return filled;
  } else {
    return filled;
  }
}
