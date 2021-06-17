$(document).ready(function () {
  var ratedIndex = -1,
    feedback = null;

  resetStarColors();

  if (localStorage.getItem("ratedIndex") != null) {
    setStars(parseInt(localStorage.getItem("ratedIndex")));
  }

  $(".star").on("click", function () {
    ratedIndex = parseInt($(this).data("index"));
    $("#rating").val(parseInt($(this).data("index")) + 1);
  });

  $(".star").mouseover(function () {
    resetStarColors();
    var currentIndex = parseInt($(this).data("index"));
    setStars(currentIndex);
  });

  $(".star").mouseleave(function () {
    resetStarColors();

    if (ratedIndex != -1) setStars(ratedIndex);
  });

  $("#rating_submit").on("click", function () {
    feedback = $("#feedback").val();
    if (ratedIndex != -1) {
      insertToTheDB();
      window.location.href = "dish.php?id=" + dishID + "";
    } else {
      $("#error_msg")
        .html("Please choose a star for your rating")
        .show()
        .fadeOut("slow");
    }
  });
});

/**
 * @param  {} max
 */
function setStars(max) {
  for (var i = 0; i <= max; i++)
    $(".star:eq(" + i + ")").css("color", "yellow");
}

/**
 */
function resetStarColors() {
  $(".star").css("color", "white");
}

/**
 */
function checkForm(form) {
  form.classList.add("was-validated");

  if ($("#rating").val() == "") {
    return false;
  }
  if (form.feedback.value.trim() === "") {
    return false;
  }
}
