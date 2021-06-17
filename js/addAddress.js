$(document).ready(function () {
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
