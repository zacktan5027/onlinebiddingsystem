$(document).ready(function () {
  $("#firstName").keypress(function (e) {
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

  $("#lastName").keypress(function (e) {
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
  $("#phoneNumber").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      //display error message
      $("#phone_error_msg").html("Number only").show().fadeOut("slow");
      return false;
    }
  });

  let phoneNumber = document.querySelector("#phoneNumber");

  /**
   * This JavaScript is to make the phone number look better
   */
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

function checkProfile(form) {
  let firstName = form.querySelector("#firstName").value.trim();
  let lastName = form.querySelector("#lastName").value.trim();
  let email = form.querySelector("#email").value.trim();

  let emptyField = "";
  let filled = true;

  if (firstName === "") {
    emptyField += ", first name ";
    form.querySelector("#firstName").value = "";
    filled = false;
  }
  if (lastName === "") {
    emptyField += ", last name ";
    form.querySelector("#lastName").value = "";
    filled = false;
  }
  if (email === "") {
    emptyField += ", email ";
    form.querySelector("#email").value = "";
    filled = false;
  }

  if (filled === false) {
    alert("Please fill up " + emptyField + " fields");
    return filled;
  } else {
    return filled;
  }
}
