// Back To Top
// const backToTop = document.getElementById("back-to-top");

$(document).ready(function () {
  // navigation bar toggle
  $("#navbar-toggler").click(function () {
    $(".navbar-collapse").slideToggle(400);
  });

  // navbar bg change
  $(window).scroll(function () {
    let pos = $(window).scrollTop();
    if (pos >= 100) {
      $(".navbar").addClass("cng-navbar");
      // backToTop.style.opacity = 1;
      // backToTop.style.pointerEvents = "all";
    } else {
      $(".navbar").removeClass("cng-navbar");
      // backToTop.style.opacity = 0;
      // backToTop.style.pointerEvents = "none";
    }
  });
});

document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
  toggle.addEventListener("click", function (e) {
    e.preventDefault();

    const parent = this.parentElement;

    // close previously open dropdowns
    document.querySelectorAll(".dropdown.open").forEach((d) => {
      if (d !== parent) d.classList.remove("open");
    });

    // toggle current dropdown
    parent.classList.toggle("open");
  });
});

// Optional: close dropdown when clicking outside
document.addEventListener("click", function (e) {
  if (!e.target.closest(".dropdown")) {
    document
      .querySelectorAll(".dropdown.open")
      .forEach((d) => d.classList.remove("open"));
  }
});
