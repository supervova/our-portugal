/**
 * Open an close collapsible panel
 *
 * @param {object} event
 */
function toggleCollapsible(event) {
  const button = event.target;
  const panelID = button.getAttribute('aria-controls');
  const panel = document.getElementById(panelID);

  // Toggle dropdowns
  panel.classList.toggle('is-open');

  // Toggle aria-expanded value
  if (button.getAttribute('aria-expanded') === 'true') {
    button.setAttribute('aria-expanded', 'false');
  } else {
    button.setAttribute('aria-expanded', 'true');
  }
}

// LISTENER
window.addEventListener('click', (event) => {
  if (event.target.matches('[data-collapsible-panel-toggle]')) {
    toggleCollapsible(event);
  }
});
