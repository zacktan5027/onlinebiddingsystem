function previewFile(input) {
  var file = $("#screenShot").get(0).files[0];

  if (file) {
    var reader = new FileReader();

    reader.onload = function () {
      $("#previewScreenShot").attr("src", reader.result);
    };

    reader.readAsDataURL(file);
  }
}
