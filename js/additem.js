$(document).ready(function () {
  $("#startPrice").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      if (e.which === 32) {
        return false;
      } else {
        return false;
      }
    }
  });

  $("#itemQuantity").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      if (e.which === 32) {
        return false;
      } else {
        return false;
      }
    }
  });
});
