const initInfoSlider = () => {
  if (typeof Swiper === "undefined") {
    // Retry after a short delay if Swiper isn't loaded yet
    setTimeout(initInfoSlider, 100);
    return;
  }

  const swiperInfoEl = document.querySelector(".swiper-info");
  if (!swiperInfoEl) return;
  console.log(swiperInfoEl);

  const swiperInfo = new Swiper(swiperInfoEl, {
    slidesPerView: 1,
    spaceBetween: 20,
  });
};

initInfoSlider();
