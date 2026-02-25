const initHeroSlider = () => {
  if (typeof Swiper === "undefined") {
    // Retry after a short delay if Swiper isn't loaded yet
    setTimeout(initHeroSlider, 100);
    return;
  }

  const swiperHomeEl = document.querySelector(".swiper-home");
  if (!swiperHomeEl) return;

  const swiperHome = new Swiper(swiperHomeEl, {
    slidesPerView: 1,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    autoplay: {
      delay: 10000,
      disableOnInteraction: false,
    },
    loop: true,
  });
};

document.addEventListener("DOMContentLoaded", initHeroSlider);
