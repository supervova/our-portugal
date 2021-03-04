export default function responsiveCarousel(id) {
  if (window.matchMedia('only screen and (max-width: 767px)').matches) {
    // Activate Carousel
    const carouselParent = document.querySelector(id);
    // eslint-disable-next-line no-undef
    const carousel = new bootstrap.Carousel(carouselParent, {
      interval: 2000,
      wrap: false,
    });

    // Enable Carousel Indicators
    carouselParent.querySelectorAll('carousel__indicator').forEach((el) => {
      el.addEventListener('click', () => {
        // TODO: add data-slide-to to indicators
        const { slideTo } = el.dataset;
        carousel.to(slideTo);
      });
    });

    // Enable Carousel Controls
    carouselParent
      .querySelector('.carousel__control.is-prev')
      .addEventListener('click', () => {
        carousel.prev();
      });

    carouselParent
      .querySelector('.carousel__control.is-next')
      .addEventListener('click', () => {
        carousel.next();
      });
  }
}
