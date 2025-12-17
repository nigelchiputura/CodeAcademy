const url = window.location.href;
// console.log(url);
const fileName = url.substring(url.lastIndexOf("/") + 1).slice(0, -4);
// console.log(fileName);

const sidebarMenu = document.getElementById("menu");
const sidebarLinks = sidebarMenu.querySelectorAll("li");
const defaultActiveLink = document.getElementById("index");

sidebarLinks.forEach((link) => {
  link.classList.remove("active");
  let linkType = link.getAttribute("id");
  // console.log(linkType)

  if (fileName === linkType) {
    link.classList.add("active");
  }
});

const toggleBtn = document.getElementById("toggleSidebar");
const sidebar = document.getElementById("sidebar");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("show");
});
