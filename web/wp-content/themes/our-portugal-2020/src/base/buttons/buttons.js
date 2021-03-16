(() => {
  let lastScrollTop = 0;
  const btnBack = document.getElementById('btn-back');

  if (btnBack) {
    window.addEventListener(
      'scroll',
      () => {
        const scrollTop =
          window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > lastScrollTop) {
          // downscroll code
          btnBack.classList.remove('is-visible');
        } else {
          // upscroll code
          btnBack.classList.add('is-visible');
        }
        // For Mobile or negative scrolling
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
      },
      false
    );
  }
})();
