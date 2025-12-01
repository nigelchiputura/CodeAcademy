const userModalBtnContainer = document.querySelectorAll(".actions");

// Update User Detail Modal
const userUpdateModal = document.getElementById("editUserModal");
const userUpdateModalBtns = document.querySelectorAll(".edit-user-detail-btn");
const userUpdateModalBody = userUpdateModal.querySelector(".modal-body");

// Delete User Detail Modal
const userDeleteModal = document.getElementById("deleteUserModal");
const userDeleteSubmitBtn = userDeleteModal.querySelector("#user-delete-btn");
const userDeleteModalBody = userDeleteModal.querySelector(".modal-body");

// View User Detail Modal
const userDetailModal = document.getElementById("viewUserModal");
const userDetailModalBtns = document.querySelectorAll(".view-user-detail-btn");
const userDetailModalBody = userDetailModal.querySelector(".modal-body");

let userUpdateModalInputFields =
  userUpdateModalBody.querySelectorAll(".update-field");

userModalBtnContainer.forEach((container) => {
  let userInfo = container.dataset.user_info;
  let userInfoObject = JSON.parse(userInfo);

  let userModalBtns = container.querySelectorAll("button");

  userModalBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      let currentBtn = e.target;
      let btnAction = currentBtn.getAttribute("id");

      if (btnAction === "read") {
        // console.log(userInfoObject);

        for (let key in userInfoObject) {
          // console.log(key);
          let modalListGroup =
            userDetailModalBody.querySelectorAll(".list-group-item");
          modalListGroup.forEach((item) => {
            let modalListGroupListItem = item.getAttribute("id");
            if (modalListGroupListItem === key) {
              item.querySelector("span").textContent = userInfoObject[key];
              // console.log(item.querySelector("span").textContent)
              console.log(userInfoObject[key]);
            }
          });
        }
      } else if (btnAction === "update") {
        // text inputs (first_name, last_name, username, email, phone)
        userUpdateModalInputFields.forEach((inputField) => {
          const fieldName = inputField
            .getAttribute("id")
            .replace("-update", "");
          const value = userInfoObject[fieldName];

          if (typeof value !== "undefined" && !Array.isArray(value)) {
            inputField.value = value;
          }

          if (inputField.getAttribute("id") === "status-update") {
            let selectOptions = inputField.querySelectorAll("option");
            selectOptions.forEach((option) => {
              if (option.value === userInfoObject["status"]) {
                option.selected = true;
              }
            });
          }
        });

        // set hidden user_id
        const hiddenIdInput = document.getElementById("user-id-update");
        if (hiddenIdInput) {
          hiddenIdInput.value = userInfoObject["id"];
        }

        // roles: tick checkboxes
        const roleCheckboxes =
          userUpdateModalBody.querySelectorAll(".role-checkbox");
        const userRoles = Array.isArray(userInfoObject.roles)
          ? userInfoObject.roles.map((r) => r.toLowerCase())
          : [];

        roleCheckboxes.forEach((cb) => {
          cb.checked = userRoles.includes(cb.value.toLowerCase());
        });
      } else if (btnAction === "delete") {
        let confirmationMessage =
          userDeleteModalBody.querySelector("#confirm-delete");
        // console.log("DELETE!!!")
        confirmationMessage.querySelector("strong").textContent =
          userInfoObject["username"];
        userDeleteSubmitBtn.setAttribute("value", userInfoObject["id"]);
      }
    });
  });
});

function showCrudToast(message, type = "success") {
  const toastEl = document.getElementById("crudToast");
  const toastMessage = document.getElementById("crudToastMessage");

  toastEl.classList.remove(
    "text-bg-success",
    "text-bg-danger",
    "text-bg-warning"
  );
  toastEl.classList.add(`text-bg-${type}`);
  toastMessage.innerText = message;

  const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
  toast.show();
}

document.querySelectorAll(".edit-user-detail-btn").forEach((btn) => {
  btn.addEventListener("click", () =>
    showCrudToast("Editing user details...", "info")
  );
});

document.querySelectorAll(".delete-user-detail-btn").forEach((btn) => {
  btn.addEventListener("click", () =>
    showCrudToast("Deleting user!", "danger")
  );
});

document.querySelectorAll(".view-user-detail-btn").forEach((btn) => {
  btn.addEventListener("click", () =>
    showCrudToast("Viewing user details", "secondary")
  );
});

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
