/**
 * -----------------------------------------------------------------------------
 * FORM VALIDATION
 * -----------------------------------------------------------------------------
 * Add the novalidate attribute to the <form>.
 */

(() => {
  const forms = document.querySelectorAll('.is-should-be-validated');

  // Loop over forms
  Array.prototype.slice.call(forms).forEach((form) => {
    const inputs = form.querySelectorAll(':required, [pattern]');
    const button = form.querySelector('.btn.is-submit');

    /**
     * Add and remove .is-invalid to parent elements to change siblings styles:
     * show shared alert, shift suffix etc
     * @param {object} el is checked input
     */
    const checkParent = (el) => {
      const row = el.closest('[data-validaion-parent]');
      if (row) {
        if (!el.checkValidity()) {
          row.classList.add('is-invalid');
          row.classList.remove('is-correct');
        } else {
          row.classList.remove('is-invalid');
          row.classList.add('is-correct');
        }
      }
    };

    // Add and remove validation classes on blur
    inputs.forEach((input) => {
      input.addEventListener('blur', () => {
        // add .is-touched on input
        input.classList.add('is-touched');

        // SERVER-SIDE: remove the class added at the server validation stage
        // input.classList.remove('is-invalid');

        checkParent(input);
      });
    });

    // Disabling form submissions if there are invalid fields
    form.addEventListener(
      'submit',
      (event) => {
        // Prevent invalid form submission
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          inputs.forEach((input) => {
            checkParent(input);
          });
        } else {
          button.classList.add('has-spinner');
          button.disabled = true;
        }

        // Check the completion of all required fields on submit
        form.classList.add('has-been-validated');
      },
      false
    );
  });
})();
