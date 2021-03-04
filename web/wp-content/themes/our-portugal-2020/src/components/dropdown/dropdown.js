// .dropdown(data-dropdown)
//   button.dropdown__toggle(data-dropdown-toggle)
//   ul.dropdown__menu(data-dropdown-menu)

/**
 * Change z-index of the hero section
 * Due to the decorative ribbon, the hero and the section below it overlap,
 * which makes it difficult to interact with the widgets.
 *
 * @param {number|string} index z-index of the hero sibling
 */
function changeHeroZindex(index) {
  const hero = document.querySelector('.hero');
  if (hero) {
    hero.style.setProperty('--zindex', index);
  }
}

/**
 * Change dropdown labels
 */

/**
 * Close dropdowns
 *
 * @param {object} dropdown Open dropdown menu
 */
function closeDropdowns(dropdown) {
  dropdown.classList.remove('is-open');
  dropdown
    .closest('[data-dropdown]')
    .querySelector('[data-dropdown-toggle]')
    .setAttribute('aria-expanded', false);
  changeHeroZindex(1);
}

/**
 * Click on dropdown label
 * When the user clicks on the label, toggle dropdown
 *
 * @param {object} event
 */
function toggleDropdownOnLabelClick(event) {
  const button = event.target;
  const dropdownMenu = button
    .closest('[data-dropdown]')
    .querySelector('[data-dropdown-menu]');

  // Close already open dropdown
  const openDropdown = document.querySelector('.is-open[data-dropdown-menu]');
  if (openDropdown && openDropdown !== dropdownMenu) {
    closeDropdowns(openDropdown);
  }

  // Toggle dropdowns
  dropdownMenu.classList.toggle('is-open');

  // Toggle aria-expanded value
  if (button.getAttribute('aria-expanded') === 'true') {
    button.setAttribute('aria-expanded', 'false');
    changeHeroZindex(1);
  } else {
    button.setAttribute('aria-expanded', 'true');
    changeHeroZindex('2');
  }
}

/**
 * Change dropdown labels
 */
// TODO: функции для всех фильтров. Запятые в перечисления добавлять с помощью
// CSS: .dropdown__item span:not(last-child)::after { content: ',\00a0'}
// для выборов checkbox'ов сохранять значения в массив, если массив полный
// передавать значения «любой». Если нет, выводить Array.join();

// (() => {
//   const openDropdown = document.querySelector('.is-open[data-dropdown-menu]');

//   if (openDropdown) {
//     const listOptions = openDropdown.querySelectorAll('.form__check-input');

//     listOptions.forEach((option) => {
//       option.addEventListener('change', (event) => {
//         const optionLabel = event.target
//           .closest('[data-dropdown]')
//           .querySelector('[data-dropdown-toggle]')
//           .querySelector('[data-dropdown-selected]');
//         optionLabel.textContent = event.target.dataset.label;
//       });
//     });
//   }
// })();

function changeDropDownLabel(component, radio) {
  const listOptions = document.getElementById(component);

  if (listOptions) {
    listOptions
      .querySelectorAll(`.form__check-input[name="${radio}"]`)
      .forEach((filter) => {
        filter.addEventListener('change', (event) => {
          const filterLabel = event.target
            .closest('[data-dropdown]')
            .querySelector('[data-dropdown-toggle]');
          filterLabel.innerHTML = event.target.dataset.label;
        });
      });
  }
}

(() => {
  const realtyCommandBar = document.getElementById('realty-command-bar');

  if (realtyCommandBar) {
    realtyCommandBar
      .querySelectorAll('.form__check-input[name="sort"]')
      .forEach((filter) => {
        filter.addEventListener('change', (event) => {
          const filterLabel = event.target
            .closest('[data-dropdown]')
            .querySelector('[data-dropdown-toggle]');
          filterLabel.textContent = event.target.dataset.label;
        });
      });
  }
})();

// LISTENERS
window.addEventListener('click', (event) => {
  if (event.target.matches('[data-dropdown-toggle]')) {
    toggleDropdownOnLabelClick(event);
  } else {
    document
      .querySelectorAll('[data-dropdown-menu].is-open')
      .forEach((dropdown) => {
        closeDropdowns(dropdown);
      });
  }
});

window.addEventListener('keydown', (event) => {
  if (event.key === 'Esc' || event.key === 'Escape') {
    document
      .querySelectorAll('[data-dropdown-menu].is-open')
      .forEach((dropdown) => {
        closeDropdowns(dropdown);
      });
  }
});

// CALLS
changeDropDownLabel('form-search', 'demand');
changeDropDownLabel('realty-command-bar', 'sort');
