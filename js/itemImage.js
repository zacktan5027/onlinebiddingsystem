$(document).ready(function () {
  Dropzone.options.dropzoneFrom = {
    autoProcessQueue: false,
    acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
    init: function () {
      var submitButton = document.querySelector("#submit-all");
      var removeButton = document.querySelector("#remove-all");
      myDropzone = this;
      removeButton.addEventListener("click", function () {
        myDropzone.removeAllFiles();
      });
      submitButton.addEventListener("click", function () {
        myDropzone.processQueue();
      });
      this.on("complete", function () {
        if (
          this.getQueuedFiles().length == 0 &&
          this.getUploadingFiles().length == 0
        ) {
          var _this = this;
          _this.removeAllFiles();
        }
        list_image();
      });
    },
  };

  list_image();

  function list_image() {
    var id = $("#itemID").val();
    $.ajax({
      url: "itemImageManager.php",
      method: "POST",
      data: {
        getPicture: "true",
        itemID: id,
      },
      success: function (data) {
        console.log(data);
        $("#preview").html(data);
      },
    });
  }

  $(document).on("click", ".remove_image", function () {
    var name = $(this).attr("id");
    $.ajax({
      url: "itemImageManager.php",
      method: "POST",
      data: {
        name: name,
      },
      success: function (data) {
        list_image();
      },
    });
  });
});
