$(document).ready(function () {
  //do not allow space in username field
  $("#username").keypress(function (e) {
    console.log("click");
    if (e.which === 32) return false;
  });
});
