setTimeout(function () {
  const message = document.querySelector(".display-msg");
  if (message) {
    message.style.opacity = 0;
    message.style.display = "none";
  }
}, 5000);
