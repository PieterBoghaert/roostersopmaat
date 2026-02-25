import "./../scss/style.scss";
import Headroom from "headroom.js";

document.addEventListener("DOMContentLoaded", () => {
  // grab an element
  var headerEl = document.querySelector(".site-header");
  // construct an instance of Headroom, passing the element
  var headroom = new Headroom(headerEl);
  // initialise
  headroom.init();

  //animation on scroll
  const animatedBlocks = document.querySelectorAll(
    ".info-block, .process-grid .card"
  );

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in-view");
          obs.unobserve(entry.target); // run only once
        }
      });
    },
    { threshold: 0.15 }
  );

  animatedBlocks.forEach((block) => observer.observe(block));

  //email protection
  const emailLinks = document.querySelectorAll(".email-protected");

  emailLinks.forEach((link) => {
    const email = link.parentElement
      .getAttribute("href")
      ?.replace("mailto:", "");

    if (!email) return;
    link.parentElement.setAttribute("href", "mailto:" + atob(email));
    link.textContent = atob(email);
  });
});
