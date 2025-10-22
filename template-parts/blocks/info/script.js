document.addEventListener("DOMContentLoaded", () => {
  const swiperInfoEl = document.querySelector(".swiper-info");
  console.log(swiperInfoEl);

  const swiperInfo = new Swiper(swiperInfoEl, {
    slidesPerView: 1,
    spaceBetween: 20,
  });
});
