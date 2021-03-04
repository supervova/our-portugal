// import responsiveCarousel from './components/carousel/carousel';
// import { Carousel } from '../node_modules/bootstrap/dist/js/bootstrap';

// FIXME: Uncaught TypeError: ourPortugal.responsiveCarousel is not a function
// https://webpack.js.org/guides/author-libraries/
// export default responsiveCarousel;
// export { responsiveCarousel };

// window.responsiveCarousel = responsiveCarousel;

Array.from(document.querySelectorAll('.carousel')).forEach(
  (elem) =>
    new Carousel(elem, {
      interval: false,
    })
);

// if (window.matchMedia('only screen and (max-width: 767px)').matches) {

// }
