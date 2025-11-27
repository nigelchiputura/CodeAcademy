"use strict";

export function createListitem(parentElement, content) {
  let item = document.createElement("li");
  item.textContent = content;
  parentElement.append(item);
}

export function getImage(pathToImage) {
  let ImageFolder = "static/images/";
  return ImageFolder + pathToImage;
}

export function reverse(filePath, param, arg) {
  return `${filePath}?${param}=${arg}`;
}

export function resetActiveBtns() {
  let activeBtn = document.querySelector(".active-btn");
  activeBtn.classList.remove("active-btn");
}
