const startButton = document.querySelector("#startButton"),
  stopButton = document.querySelector("#stopButton"),
  serverStatus = document.querySelector("#serverStatus");

startButton.onclick = () => {
  serverStatus.innerHTML = "Identifying...";
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "serverManager.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("startServer");
};

stopButton.onclick = () => {
  serverStatus.innerHTML = "Identifying...";
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "stopServer.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("stopServer");
};

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "getServerStatus.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        serverStatus.innerHTML = data;
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("serverStatus");
}, 500);
