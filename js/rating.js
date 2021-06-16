var ratedIndex = -1,
  feedback = null;

$(document).ready(function () {
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

function setStars(max) {
  for (var i = 0; i <= max; i++)
    $(".star:eq(" + i + ")").css("color", "yellow");
}

function resetStarColors() {
  $(".star").css("color", "white");
}

function checkForm() {
  if ($("#rating").val() == "") {
    return false;
  }
}
