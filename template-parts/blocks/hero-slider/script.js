document.addEventListener("DOMContentLoaded", () => {
  const swiperHomeEl = document.querySelector(".swiper-home");

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
});
