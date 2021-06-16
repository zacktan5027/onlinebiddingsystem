$(document).ready(function () {
  const form = document.querySelector(".bidding-area"),
    itemID = form.querySelector("#itemID").value,
    bidPrice = form.querySelector("#bidPrice"),
    bidButton = document.querySelector("#bidButton"),
    highestBidder = document.querySelector("#highestBidder"),
    currentBid = document.querySelector("#currentBid"),
    totalBidder = document.querySelector("#totalBidder");

  form.onsubmit = (e) => {
    e.preventDefault();
  };

  bidPrice.focus();
  bidPrice.onkeyup = () => {
    if (bidPrice.value != "") {
      bidButton.disabled = false;
    } else {
      bidButton.disabled = true;
    }
  };

  bidButton.onclick = () => {
    if (bidPrice.value <= currentBid.innerHTML.split(" ")[1]) {
      alert(
        "Your bid price cannot lower than or equal to the current bid price."
      );
      bidPrice.value = "";
      return false;
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "bidManager.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          bidPrice.value = "";
          console.log(xhr.response);
        }
      }
    };
    let formData = new FormData(form);
    xhr.send(formData);
  };

  setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "bidManager.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          currentBid.innerHTML = data;
        }
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("getCurrentBid&itemID=" + itemID);
    let xhr1 = new XMLHttpRequest();
    xhr1.open("POST", "bidManager.php", true);
    xhr1.onload = () => {
      if (xhr1.readyState === XMLHttpRequest.DONE) {
        if (xhr1.status === 200) {
          let data1 = xhr1.response;
          highestBidder.innerHTML = data1;
        }
      }
    };
    xhr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr1.send("getHighestBidder&itemID=" + itemID);
    let xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "bidManager.php", true);
    xhr2.onload = () => {
      if (xhr2.readyState === XMLHttpRequest.DONE) {
        if (xhr2.status === 200) {
          let data2 = xhr2.response;
          totalBidder.innerHTML = data2;
        }
      }
    };
    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr2.send("getTotalBidder&itemID=" + itemID);
    $("#bidPrice_error_msg").tooltip("hide");
  }, 500);

  //do not allow space in phone number field
  $("#bidPrice").keypress(function (e) {
    if (e.which === 32) return false;
  });

  $("#bidPrice").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      if (e.which === 32) {
        return false;
      } else {
        //display error message
        $("#bidPrice_error_msg").tooltip("show");

        return false;
      }
    }
  });
});
