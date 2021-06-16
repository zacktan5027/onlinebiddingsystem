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

let form = document.querySelector("#addressForm");
let customerName = document.querySelector("#customerName");
let address1 = document.querySelector("#address1");
let address2 = document.querySelector("#address2");
let city = document.querySelector("#city");
let postcode = document.querySelector("#postcode");
let state = document.querySelector("#state");
let phoneNumber = document.querySelector("#phoneNumber");

function selectAddress(button) {
  customerName.value = button.querySelector("#savedCustomerName").innerHTML;
  address1.value = button.querySelector("#savedAddress1").innerHTML;
  address2.value = button.querySelector("#savedAddress2").innerHTML;
  city.value = button.querySelector("#savedCity").innerHTML;
  postcode.value = button.querySelector("#savedPostCode").innerHTML;
  state.value = button.querySelector("#savedState").innerHTML;
  phoneNumber.value = button.querySelector("#savedPhoneNumber").innerHTML;

  customerName.readOnly = true;
  address1.readOnly = true;
  address2.readOnly = true;
  city.readOnly = true;
  postcode.readOnly = true;
  state.disabled = true;
  phoneNumber.readOnly = true;
}

function clearForm() {
  customerName.value = "";
  address1.value = "";
  address2.value = "";
  city.value = "";
  postcode.value = "";
  state.value = "";
  phoneNumber.value = "";

  customerName.removeAttribute("readonly");
  address1.removeAttribute("readonly");
  address2.removeAttribute("readonly");
  city.removeAttribute("readonly");
  postcode.removeAttribute("readonly");
  state.removeAttribute("disabled");
  phoneNumber.removeAttribute("readonly");
}

function saveAddress() {
  if ($("#customerName").attr("readonly") === undefined) {
    let decision = confirm("Do you want to save this address?");
    if (decision == true) {
      $("#customerDecision").val(1);
    }
  } else if ($("#state").attr("disabled") !== undefined) {
    $("#state").removeAttr("disabled");
  }
}

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
