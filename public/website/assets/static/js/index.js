"use strict";

import { generateTemplate } from "./templateGenerator.js";
// import { generateTeamItemTemplate } from "./templateGenerator.js";
// import { generateInventoryItemTemplate } from "./templateGenerator.js";
// import { generateTestimonialItemTemplate } from "./templateGenerator.js";

// Item Containers
const servicesContainer = document.getElementById("service-container");
const aboutItemContainerRight = document.getElementById(
  "about-item-container-right"
);
const aboutItemContainerLeft = document.getElementById(
  "about-item-container-left"
);

$(document).ready(function () {
  // team carousel
  $(".team .owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    dots: true,
    nav: false,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      },
    },
  });

  // faq accordion
  $(".faq-head").each(function () {
    $(this).click(function () {
      $(this).next().toggleClass("show-faq-content");

      let icon = $(this).children("span").children("i").attr("class");

      if (icon == "fas fa-plus") {
        $(this).children("span").html("<i class = 'fas fa-minus'></i>");
      } else {
        $(this).children("span").html("<i class = 'fas fa-plus'></i>");
      }
    });
  });

  // testimonial carousel
  $(".testimonial .owl-carousel").owlCarousel({
    loop: true,
    autoplay: true,
    dots: true,
    nav: false,
    items: 1,
  });
});

// Testimonials Content

// generateTestimonialItemTemplate(
//   "profile (2).jpg",
//   "Professional, fast, and affordable. Took my laptop in for repairs and it was good as new within a day. Highly recommend them!",
//   "Tinashe M.",
//   "Marondera"
// );

// generateTestimonialItemTemplate(
//   "profile (2).jpg",
//   "I bought a second-hand laptop for school, and it works perfectly. The team was very honest and helped me choose based on my budget.",
//   "Memory D.",
//   "UZ Student"
// );

// generateTestimonialItemTemplate(
//   "profile (2).jpg",
//   "They helped me fix my desktop and set up all the software I needed for my office. Great customer service and attention to detail.",
//   "Mr. Nyandoro",
//   "Local Business Owner"
// );

// End Testimonials Content

// Team Content

// generateTeamItemTemplate(
//   "profile (2).jpg",
//   "Nigel Chiputura",
//   "Backend Developer"
// );

// generateTeamItemTemplate(
//   "profile (2).jpg",
//   "Nigel Chiputura",
//   "Backend Developer"
// );

// generateTeamItemTemplate(
//   "profile (2).jpg",
//   "Nigel Chiputura",
//   "Backend Developer"
// );

// generateTeamItemTemplate(
//   "profile (2).jpg",
//   "Nigel Chiputura",
//   "Backend Developer"
// );

// generateTeamItemTemplate(
//   "profile (2).jpg",
//   "Nigel Chiputura",
//   "Backend Developer"
// );

// End Team Content

// Services Content

// generateTemplate(
//   servicesContainer,
//   "detail-item",
//   "fas",
//   "fa-tools",
//   "Computer Repairs & Diagnosis",
//   "We diagnose and fix hardware issues for desktops and laptops — whether it’s a faulty hard drive, power issue, or system not booting.",
//   [],
//   "computer-repairs-bg.png"
// );

// generateTemplate(
//   servicesContainer,
//   "detail-item",
//   "fas",
//   "fa-cogs",
//   "Software Setup",
//   "Let us handle your operating system setup, drivers, antivirus installation, and software configuration — done right the first time.",
//   [],
//   "software-repairs-bg.png"
// );

// generateTemplate(
//   servicesContainer,
//   "detail-item",
//   "fas",
//   "fa-laptop",
//   "Laptop Sales",
//   "Affordable, reliable laptops for work, school, or personal use — available in various specs and price ranges.",
//   [],
//   "laptop-sales-bg.png"
// );

// End Services Content

// About Content

generateTemplate(
  aboutItemContainerRight,
  "about-item",
  "fas",
  "fa-book-open",
  "Our Story",
  "CodeAcademy was founded with a single mission: to empower the next generation of developers with the tools and knowledge they need to thrive in the digital world. What started as a small initiative has grown into a vibrant community of learners, mentors, and tech enthusiasts.",
  [],
  "",
  "From the very beginning, we understood that learning to code isn’t just about writing lines of syntax — it’s about solving real-world problems and building meaningful solutions. That’s why we emphasize hands-on projects, mentorship, and real-world applications in everything we teach.",
  "Over the years, we've helped dozens of students transition into successful careers in software development, web design, and IT. Our commitment to accessible, practical, and industry-relevant education remains at the core of who we are."
);

generateTemplate(
  aboutItemContainerLeft,
  "about-item",
  "fas",
  "fa-lightbulb",
  "Our Mission",
  "To provide quality, affordable, and practical tech education that equips learners with real-world skills, encourages creativity, and builds confidence to innovate and lead in today’s technology-driven world."
);

generateTemplate(
  aboutItemContainerLeft,
  "about-item",
  "fas",
  "fa-star",
  "Why Choose Us",
  "",
  [
    "Practical, project-based learning",
    "Experienced mentors and instructors",
    "Supportive peer community",
    "Up-to-date curriculum aligned with industry needs",
    "Affordable tuition with flexible options",
    "Real-world client projects and internship support",
    "Focus on both technical and soft skills",
    "Alumni success stories and career guidance",
  ]
);

// End About Content

// const teamItemContainer = document.getElementById("team-item-container");
// const testimonialItemContainer = document.getElementById(
//   "testimonial-item-container"
// );

// Remove extra child in owl carousel
// teamItemContainer.removeChild(teamItemContainer.children[0]);
// testimonialItemContainer.removeChild(testimonialItemContainer.children[0]);

// Inventory Content

// fetch("inventory.json")
//   .then((response) => response.json())
//   .then((data) => {
//     const inventory = data;
//     for (let i = 0; i < 3; i++) {
//       const inventoryDetails = inventory[i];
//       //   console.log(inventoryDetails);

//       generateInventoryItemTemplate(
//         inventoryDetails.imagePath,
//         inventoryDetails.name,
//         inventoryDetails.price,
//         inventoryDetails.features,
//         inventoryDetails.gallery
//       );
//     }
//   });

// End Inventory Content
