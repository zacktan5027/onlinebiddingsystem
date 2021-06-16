$(document).ready(function () {
  let highestBidder = document.querySelector("#highestBidder");
  let currentBid = document.querySelector("#currentBid");
  let totalBidder = document.querySelector("#totalBidder");

  setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "user/bidManager.php", true);
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
    xhr1.open("POST", "user/bidManager.php", true);
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
    xhr2.open("POST", "user/bidManager.php", true);
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
});
