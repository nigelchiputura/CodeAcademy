import { getImage } from "./utilities.js";

const modal = document.getElementById("product-modal");
const closeBtn = document.querySelector(".modal-close");
const carousel = $("#product-carousel");

export function openProductModal(images) {
  carousel.trigger("destroy.owl.carousel");
  carousel.html("");

  // inject images
  images.forEach((img) => {
    carousel.append(`
            <div class="item">
                <img src="${getImage(`inventory/${img}`)}" alt="">
            </div>
        `);
  });

  // Reinitialize Owl
  carousel.owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayTimeout: 2500,
  });

  modal.style.display = "block";
}

closeBtn.onclick = () => (modal.style.display = "none");
window.onclick = (e) => {
  if (e.target === modal) modal.style.display = "none";
};
