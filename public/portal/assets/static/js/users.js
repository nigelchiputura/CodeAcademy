const selectAll = document.getElementById("selectAllUsers");
const userCheckboxes = document.querySelectorAll(".user-checkbox");
const deleteSelectedBtn = document.getElementById("deleteSelectedBtn");
const confirmDeleteModal = new bootstrap.Modal(
  document.getElementById("confirmDeleteModal")
);
const selectedCountText = document.getElementById("selectedCount");
const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");

function updateDeleteButton() {
  const selected = document.querySelectorAll(".user-checkbox:checked").length;
  deleteSelectedBtn.disabled = selected === 0;
}

selectAll?.addEventListener("change", (e) => {
  userCheckboxes.forEach((cb) => (cb.checked = e.target.checked));
  updateDeleteButton();
});

userCheckboxes.forEach((cb) =>
  cb.addEventListener("change", updateDeleteButton)
);

deleteSelectedBtn?.addEventListener("click", () => {
  const selected = document.querySelectorAll(".user-checkbox:checked").length;
  selectedCountText.textContent = selected;
  confirmDeleteModal.show();
});

confirmDeleteBtn?.addEventListener("click", () => {
  const selectedIds = Array.from(
    document.querySelectorAll(".user-checkbox:checked")
  ).map((cb) => cb.closest("tr").dataset.userId);

  console.log("Deleting users:", selectedIds);

  confirmDeleteModal.hide();
  showCrudToast(
    `${selectedIds.length} user(s) deleted successfully!`,
    "danger"
  );

  selectedIds.forEach((id) =>
    document.querySelector(`[data-user-id="${id}"]`)?.remove()
  );
  updateDeleteButton();
});
