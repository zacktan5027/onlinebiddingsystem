$(document).ready(function () {
  /**
   * This funtion is use to restrict the input of alphabatical characters in postcode field.
   *
   * @param  {} "#postcode"
   */
  $("#postcode").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      //display error message
      $("#postcode_error_msg").html("Number only").show().fadeOut("slow");
      return false;
    }
  });

  /**
   * This funtion is use to restrict the input of alphabatical characters in phone number field
   *
   * @param  {} "#phoneNumber"
   */
  $("#phoneNumber").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      //display error message
      $("#phone_error_msg").html("Number only").show().fadeOut("slow");
      return false;
    }
  });

  $("#state").change(function () {
    $("#stateValue").val($("#state").val());
  });
});

let form = document.querySelector("#addressForm");
let name = document.querySelector("#name");
let address1 = document.querySelector("#address1");
let address2 = document.querySelector("#address2");
let city = document.querySelector("#city");
let postcode = document.querySelector("#postcode");
let state = document.querySelector("#state");
let stateValue = document.querySelector("#stateValue");
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

/**
 * This function is used to disable all the field if the user click the address badge
 *
 * @param  {} button
 */
function selectAddress(button) {
  name.value = button.querySelector("#savedCustomerName").innerHTML;
  address1.value = button.querySelector("#savedAddress1").innerHTML;
  address2.value = button.querySelector("#savedAddress2").innerHTML;
  city.value = button.querySelector("#savedCity").innerHTML;
  postcode.value = button.querySelector("#savedPostCode").innerHTML;
  state.value = button.querySelector("#savedState").innerHTML;
  stateValue.value = button.querySelector("#savedState").innerHTML;
  phoneNumber.value = button.querySelector("#savedPhoneNumber").innerHTML;

  name.readOnly = true;
  address1.readOnly = true;
  address2.readOnly = true;
  city.readOnly = true;
  postcode.readOnly = true;
  state.disabled = true;
  phoneNumber.readOnly = true;
}

/**
 * This function is used to clear the form
 *
 */
function clearForm() {
  name.value = "";
  address1.value = "";
  address2.value = "";
  city.value = "";
  postcode.value = "";
  state.value = "";
  stateValue.value = button.querySelector("#savedState").innerHTML;
  phoneNumber.value = "";

  name.removeAttribute("readonly");
  address1.removeAttribute("readonly");
  address2.removeAttribute("readonly");
  city.removeAttribute("readonly");
  postcode.removeAttribute("readonly");
  state.removeAttribute("disabled");
  phoneNumber.removeAttribute("readonly");
}

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
    alert("Please fill up " + emptyField + " fields");
    return filled;
  } else {
    saveAddress();
    return filled;
  }
}

/**
 * This function is used to prompt user whether to save the address input
 */
function saveAddress() {
  if ($("#name").attr("readonly") === undefined) {
    let decision = confirm("Do you want to save this address?");
    if (decision == true) {
      $("#customerDecision").val(1);
    }
  } else if ($("#state").attr("disabled") !== undefined) {
    $("#state").removeAttr("disabled");
  }
}
