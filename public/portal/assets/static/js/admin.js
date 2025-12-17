const modalBtnContainer = document.querySelectorAll(".actions");

// Update User Detail Modal
const updateModal = document.getElementById("editModal");
const updateModalBtns = document.querySelectorAll(".edit-detail-btn");
const updateModalBody = updateModal.querySelector(".modal-body");

// Delete User Detail Modal
const deleteModal = document.getElementById("deleteModal");
const deleteSubmitBtn = deleteModal.querySelector("#delete-detail-btn");
const deleteModalBody = deleteModal.querySelector(".modal-body");

// View User Detail Modal
const detailModal = document.getElementById("viewModal");
const detailModalBtns = document.querySelectorAll(".view-detail-btn");
const detailModalBody = detailModal.querySelector(".modal-body");

let updateModalInputFields = updateModalBody.querySelectorAll(".update-field");

modalBtnContainer.forEach((container) => {
  let info = container.dataset.info;
  // console.log(info);
  let infoObject = JSON.parse(atob(info));

  let modalBtns = container.querySelectorAll("button");

  modalBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      let currentBtn = e.target;
      let btnAction = currentBtn.getAttribute("id");

      if (btnAction === "read") {
        // console.log(infoObject);

        for (let key in infoObject) {
          // console.log(key);
          let modalListGroup =
            detailModalBody.querySelectorAll(".list-group-item");
          modalListGroup.forEach((item) => {
            let modalListGroupListItem = item.getAttribute("id");
            if (
              modalListGroupListItem === key &&
              modalListGroupListItem !== "image"
            ) {
              // console.log(item.querySelector("span").textContent)

              item.querySelector("span").textContent = infoObject[key];
            }
            if (
              modalListGroupListItem === key &&
              modalListGroupListItem === "image"
            ) {
              item
                .querySelector("img")
                .setAttribute("src", `/uploads/${infoObject[key]}`);
            }
          });
        }
      } else if (btnAction === "update") {
        // text inputs (first_name, last_name, username, email, phone)
        updateModalInputFields.forEach((inputField) => {
          const fieldName = inputField
            .getAttribute("id")
            .replace("-update", "");
          const value = infoObject[fieldName];

          if (fieldName === "image") {
            value
              ? inputField
                  .querySelector("a")
                  .setAttribute("href", `/uploads/${value}`)
              : inputField.querySelector("a").setAttribute("href", "#");
            value
              ? (inputField.querySelector("a").textContent = value.replace(
                  "services/",
                  ""
                ))
              : (inputField.querySelector("a").textContent =
                  "No Image Has Been Set"),
              console.log("");
          }

          if (typeof value !== "undefined" && !Array.isArray(value)) {
            inputField.value = value;
          }

          if (inputField.getAttribute("id") === "status-update") {
            let selectOptions = inputField.querySelectorAll("option");
            selectOptions.forEach((option) => {
              if (option.value === infoObject["status"]) {
                option.selected = true;
              }
              if (option.value == infoObject["is_active"]) {
                option.selected = true;
              }
            });
          }
        });

        // set hidden id
        const hiddenIdInput = document.getElementById("id-update");
        if (hiddenIdInput) {
          hiddenIdInput.value = infoObject["id"];
        }

        // roles: tick checkboxes
        const roleCheckboxes =
          updateModalBody.querySelectorAll(".role-checkbox");
        const userRoles = Array.isArray(infoObject.roles)
          ? infoObject.roles.map((r) => r.toLowerCase())
          : [];

        roleCheckboxes.forEach((cb) => {
          cb.checked = userRoles.includes(cb.value.toLowerCase());
        });
      } else if (btnAction === "delete") {
        let confirmationMessage =
          deleteModalBody.querySelector("#confirm-delete");
        // console.log("DELETE!!!");

        if (infoObject["username"]) {
          confirmationMessage.querySelector(
            "strong"
          ).textContent = `"${infoObject["username"]}"`;
        } else if (infoObject["title"]) {
          confirmationMessage.querySelector(
            "strong"
          ).textContent = `"${infoObject["title"]}"`;
        } else {
          confirmationMessage.querySelector("strong").textContent = "";
        }

        deleteSubmitBtn.setAttribute("value", infoObject["id"]);
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

document.querySelectorAll(".edit-detail-btn").forEach((btn) => {
  btn.addEventListener("click", () =>
    showCrudToast("Editing user details...", "info")
  );
});

document.querySelectorAll(".delete-detail-btn").forEach((btn) => {
  btn.addEventListener("click", () =>
    showCrudToast("Deleting user!", "danger")
  );
});

document.querySelectorAll(".view-detail-btn").forEach((btn) => {
  btn.addEventListener("click", () =>
    showCrudToast("Viewing user details", "secondary")
  );
});
