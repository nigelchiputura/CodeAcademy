// =============================
// Recycle Bin: Restore Selected
// =============================
const selectAllRestore = document.getElementById("selectAllRestore");
const restoreCheckboxes = document.querySelectorAll(".restore-checkbox");
const restoreSelectedBtn = document.getElementById("restoreSelectedBtn");

function updateRestoreButton() {
  if (!restoreSelectedBtn) return;
  const selected = document.querySelectorAll(
    ".restore-checkbox:checked"
  ).length;
  restoreSelectedBtn.disabled = selected === 0;
}

selectAllRestore?.addEventListener("change", (e) => {
  restoreCheckboxes.forEach((cb) => (cb.checked = e.target.checked));
  updateRestoreButton();
});

restoreCheckboxes.forEach((cb) =>
  cb.addEventListener("change", updateRestoreButton)
);
