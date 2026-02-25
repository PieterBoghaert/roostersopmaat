const initSlider = () => {
  if (typeof Swiper === "undefined") {
    // Retry after a short delay if Swiper isn't loaded yet
    setTimeout(initSlider, 100);
    return;
  }

  const sliderEl = document.querySelector(".swiper-logo");

  if (sliderEl && !sliderEl.classList.contains("swiper-initialized")) {
    new Swiper(sliderEl, {
      loop: true,
      slidesPerView: 3,
      speed: 7000,
      allowTouchMove: false,
      autoplay: {
        delay: 0,
        disableOnInteraction: true,
        pauseOnMouseEnter: true,
      },
      breakpoints: {
        320: { slidesPerView: 2, spaceBetween: 10 },
        480: { slidesPerView: 3, spaceBetween: 10 },
        640: { slidesPerView: 4, spaceBetween: 10 },
        768: { slidesPerView: 5, spaceBetween: 15 },
        1024: { slidesPerView: 6, spaceBetween: 15 },
      },
    });
  }
};

// 👉 Frontend
document.addEventListener("DOMContentLoaded", initSlider);

// 👉 Gutenberg editor (if available)
if (window.wp && wp.data && wp.data.subscribe) {
  wp.data.subscribe(initSlider);
}
