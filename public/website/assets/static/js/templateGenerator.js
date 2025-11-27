"use strict";

import { getImage } from "./utilities.js";
import { createListitem } from "./utilities.js";
// import { openProductModal } from "./modal.js";

// HTML Templates
const generalTemplate = document.getElementById("template");
const teamItemTemplate = document.getElementById("team-item-template");
const faqItemTemplate = document.getElementById("faq-item-template");
const inventoryItemTemplate = document.getElementById(
  "inventory-item-template"
);
const testimonialItemTemplate = document.getElementById(
  "testimonial-item-template"
);

// Item Containers
const faqItemContainer = document.getElementById("faq-item-container");
const inventoryItemContainer = document.getElementById(
  "inventory-item-container"
);
const teamItemContainer = document.getElementById("team-item-container");
const testimonialItemContainer = document.getElementById(
  "testimonial-item-container"
);

// General Template Generator
export function generateTemplate(
  containerElement,
  contentDivClass,
  fontawesomeClassType,
  fontawesomeIconType,
  heading,
  description,
  itemlist = null,
  imagePath = null,
  additionalInfo1 = null,
  additionalInfo2 = null
) {
  const clonedElement = generalTemplate.content.cloneNode(true);

  let contentDiv = clonedElement.getElementById("content-div");
  contentDiv.classList.add(contentDivClass);

  if (imagePath) {
    contentDiv.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)), url('${getImage(
      imagePath
    )}')`;
  }

  clonedElement
    .getElementById("icon")
    .classList.add(fontawesomeClassType, fontawesomeIconType);
  clonedElement.querySelector("h2").textContent = heading;

  let serviceDescription = clonedElement.querySelector(".p1");
  serviceDescription.textContent = description;

  if (itemlist) {
    let list = clonedElement.querySelector("ul");
    for (let i = 0; i < itemlist.length; i++) {
      createListitem(list, itemlist[i]);
    }
  }

  let additionalParagraph1 = clonedElement.querySelector(".p2");
  let additionalParagraph2 = clonedElement.querySelector(".p3");

  if (additionalInfo1) {
    additionalParagraph1.textContent = additionalInfo1;
  } else {
    additionalParagraph1.style.display = "none";
  }

  if (additionalInfo2) {
    additionalParagraph2.textContent = additionalInfo2;
  } else {
    additionalParagraph2.style.display = "none";
  }

  containerElement.append(clonedElement);
}

// Team Template Generator
export function generateTeamItemTemplate(
  imgPath,
  name,
  role,
  facebookLink = "#",
  instagramLink = "#",
  twitterLink = "#"
) {
  const clonedElement = teamItemTemplate.content.cloneNode(true);

  let teamImg = clonedElement.querySelector(".team-img");
  teamImg.querySelector("img").setAttribute("src", getImage(imgPath));

  let teamIconLinks = teamImg.querySelectorAll("a");
  teamIconLinks.forEach((link) => {
    let linkType = link.getAttribute("id");
    if (linkType === "facebook") {
      link.setAttribute("href", facebookLink);
    } else if (linkType === "instagram") {
      link.setAttribute("href", instagramLink);
    } else {
      link.setAttribute("href", twitterLink);
    }
  });

  let teamName = teamImg.querySelector("h3");
  let teamRole = teamImg.querySelector("span");

  teamName.textContent = name;
  teamRole.textContent = role;

  teamItemContainer.appendChild(clonedElement);
}

// Faq Template Generator
export function generateFaqItemTemplate(question, response1, response2) {
  const clonedElement = faqItemTemplate.content.cloneNode(true);

  let faqHead = clonedElement.querySelector(".faq-head");
  faqHead.querySelector("h3").textContent = question;

  let faqContent = clonedElement.querySelector(".faq-content");
  faqContent.querySelector(".p1").textContent = response1;
  faqContent.querySelector(".p2").textContent = response2;

  faqItemContainer.append(clonedElement);
}

// Inventory Template Generator
// export function generateInventoryItemTemplate(
//   imagePath,
//   version,
//   packageCost,
//   inclusions,
//   gallery = []
// ) {
//   const clonedElement = inventoryItemTemplate.content.cloneNode(true);

//   let image = clonedElement.querySelector("img");
//   image.setAttribute("src", getImage(`inventory/${imagePath}`));

//   // CLICK EVENT TO OPEN MODAL
//   image.addEventListener("click", function () {
//     openProductModal(gallery);
//   });

//   let packageVersion = clonedElement.querySelector("h2");
//   packageVersion.textContent = version;

//   let price = clonedElement.querySelector("span");
//   price.textContent = packageCost;

//   let inclusionsList = clonedElement.querySelector("ul");
//   for (let i = 0; i < inclusions.length; i++) {
//     createListitem(inclusionsList, inclusions[i]);
//   }

//   inventoryItemContainer.appendChild(clonedElement);
// }

// Testimonial Template Generator
export function generateTestimonialItemTemplate(
  imagePath,
  statement,
  clientName,
  clientRole
) {
  const clonedElement = testimonialItemTemplate.content.cloneNode(true);

  let image = clonedElement
    .querySelector(".testimonial-img")
    .querySelector("img");
  image.setAttribute("src", getImage(imagePath));

  let testimonial = clonedElement.querySelector("p");
  testimonial.textContent = statement;

  let name = clonedElement.querySelector("span");
  name.textContent = clientName;

  let role = clonedElement.querySelector(".testimonial-role");
  role.textContent = `― ${clientRole}`;

  testimonialItemContainer.appendChild(clonedElement);
}
