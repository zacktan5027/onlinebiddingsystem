const manageShippingTable = document.getElementById("manageShippingTable");
if (manageShippingTable) {
  new simpleDatatables.DataTable(manageShippingTable);
}

$("select").each(function () {
  $(this).val($(this).attr("value")).change();
});

$("input[name='trackingNumber']").keypress(function (e) {
  if (
    (e.which < 48 || e.which > 57) &&
    (e.which < 65 || e.which > 90) &&
    (e.which < 97 || e.which > 122)
  ) {
    return false;
  }
});

function checkAddShipping(form) {
  let trackingNumber = form.trackingNumber.value.trim();
  let courierName = form.courierName.value.trim();

  let filled = true;

  if (trackingNumber === "") {
    filled = false;
    form.trackingNumber.value = "";
  }
  if (courierName === "") {
    filled = false;
    form.courierName.value = "";
  }
  form.classList.add("was-validated");
  return filled;
}

function checkEditShipping(form) {
  let trackingNumber = form.trackingNumber.value.trim();
  let courierName = form.courierName.value.trim();

  let filled = true;

  if (trackingNumber === "") {
    filled = false;
    form.trackingNumber.value = "";
  }
  if (courierName === "") {
    filled = false;
    form.courierName.value = "";
  }
  form.classList.add("was-validated");
  return filled;
}
