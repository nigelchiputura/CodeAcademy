// flashMessage.js

window.addEventListener("DOMContentLoaded", () => {
  const flash = document.querySelector(".flash-message");
  if (!flash) return;

  // Show animation
  flash.classList.add("show");

  // Auto hide after 5 seconds
  setTimeout(() => hideFlash(), 5000);

  // Close button support
  const closeBtn = flash.querySelector(".close-btn");
  if (closeBtn) {
    closeBtn.addEventListener("click", hideFlash);
  }

  function hideFlash() {
    flash.classList.remove("show");
    setTimeout(() => (flash.style.display = "none"), 400);
  }
});
