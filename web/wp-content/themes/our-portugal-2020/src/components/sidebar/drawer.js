/* eslint-disable no-unused-vars, no-shadow */
(() => {
  const drawerToggle = document.getElementById('drawer-toggle');
  const drawer = document.getElementById('drawer');

  function setAriaExpanded() {
    drawer.setAttribute('aria-hidden', 'false');
    drawerToggle.setAttribute('aria-expanded', 'true');
  }

  function setAriaHidden() {
    drawer.setAttribute('aria-hidden', 'true');
    drawerToggle.setAttribute('aria-expanded', 'false');
  }

  function openDrawer(event) {
    const backdrop = document.getElementById('backdrop');

    /* When the drawer is already open, and the user clicks the drawer trigger,
    we don't want to rerun the entire event registration. We'll add an early
    return for that. */
    if (drawer.classList.contains('is-open')) {
      return;
    }

    // Show drawer and backdrop
    drawer.classList.add('is-open');
    backdrop.classList.add('is-on');
    setAriaExpanded();

    // When the click happens outside of the drawer, we remove the .is-open
    function handleClick(event) {
      if (!drawer.contains(event.target)) {
        drawer.classList.remove('is-open');
        backdrop.classList.remove('is-on');
        setAriaHidden();

        // remove the event listener after the drawer is hidden
        window.removeEventListener('click', handleClick);
      }
    }

    /* wrap the event listener registration in a requestAnimationFrame call so it
    will be registered in the browser's next event loop, after the current event
    is handled */
    window.requestAnimationFrame(() => {
      // listen to all click events on window
      window.addEventListener('click', handleClick);
    });
  }

  // Add addEventListener to button
  if (drawerToggle) {
    drawerToggle.addEventListener('click', openDrawer);
  }
})();
