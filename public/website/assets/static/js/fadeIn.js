document.addEventListener("DOMContentLoaded", function () {
  const elements = document.querySelectorAll(".fade-in");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Add the fade-in class when visible
          entry.target.classList.add("visible");
        } else {
          // Remove it when out of view so animation can replay
          entry.target.classList.remove("visible");
        }
      });
    },
    { threshold: 0.3 }
  );

  elements.forEach((el) => observer.observe(el));
});
