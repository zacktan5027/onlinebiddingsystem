$(document).ready(function () {
  //do not allow space in username field
  $("#username").keypress(function (e) {
    console.log("click");
    if (e.which === 32) return false;
  });

  //do not allow space in password field
  $("#password").keypress(function (e) {
    if (e.which === 32) return false;
  });
});
