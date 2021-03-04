/* eslint-disable no-shadow */

const mainMenuToggler = document.getElementById('navbar-toggler');

function openMainMenu() {
  const mainMenu = document.getElementById('navbar-section-links');

  /* When the menu is already open, and the user clicks the trigger,
  we don't want to rerun the entire event registration. We'll add an early
  return for that. */
  if (mainMenu.classList.contains('is-open')) {
    return;
  }

  // Show menu…
  mainMenu.classList.add('is-open');
  mainMenuToggler.classList.add('is-pressed');

  /* When the click happens outside of the menu, we remove the .is-open
  and .is-pressed */
  function handleClick(event) {
    if (!mainMenu.contains(event.target)) {
      // Hide menu an switch button state
      mainMenu.classList.remove('is-open');
      mainMenuToggler.classList.remove('is-pressed');

      // remove the event listener after the dropdown menu is hidden
      window.removeEventListener('click', handleClick);
    }
  }

  /* wrap the event listener registration in a requestAnimationFrame call so it
  will be registered in the browser's next event loop, after the current event
  is handled */
  window.requestAnimationFrame(() => {
    window.addEventListener('click', handleClick);
  });
}

if (mainMenuToggler) {
  mainMenuToggler.addEventListener('click', () => {
    openMainMenu();
  });
}
