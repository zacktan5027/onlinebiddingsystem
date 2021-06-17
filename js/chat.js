$(document).ready(function () {
  const form = document.querySelector("#typingArea"),
    sellerID = form.querySelector("#sellerID").value,
    inputField = form.querySelector("#inputField"),
    sendBtn = form.querySelector("#sendButton"),
    chatBox = document.querySelector("#chatBox");

  form.onsubmit = (e) => {
    e.preventDefault();
  };

  sendBtn.onclick = () => {
    if (inputField.value.trim() === "") {
      inputField.value = "";
      alert("Please fill up the message field before sending");
      return false;
    } else {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "chatManager.php", true);
      xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            inputField.value = "";
            scrollToBottom();
          }
        }
      };
      let formData = new FormData(form);
      xhr.send(formData);
    }
  };

  chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
  };

  chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
  };

  setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "chatManager.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          chatBox.innerHTML = data;
          if (!chatBox.classList.contains("active")) {
            scrollToBottom();
          }
        }
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("getChat&sellerID=" + sellerID);
  }, 500);
});

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}
