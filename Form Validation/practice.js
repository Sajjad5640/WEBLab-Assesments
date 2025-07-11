const form = document.getElementById('biodata-form');
const inputs = form.querySelectorAll('input, select');

form.addEventListener('submit', (e) => {
  e.preventDefault();
  validateInputs();
});

const setError = (element, message) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');
  errorDisplay.innerText = message;
  inputControl.classList.add('error');
  inputControl.classList.remove('success');
};

const setSuccess = (element) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');
  errorDisplay.innerText = '';
  inputControl.classList.add('success');
  inputControl.classList.remove('error');
};

const isValidEmail = (email) => {
  const re = /^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/;
  return re.test(String(email).toLowerCase());
};

function validateInputs() {
  let valid = true;

  inputs.forEach((input) => {
    const value = input.value.trim();

    if (!value) {
      setError(input, `${input.name} is required`);
      valid = false;
    } else {
      if (input.id === 'email' && !isValidEmail(value)) {
        setError(input, 'Invalid email format');
        valid = false;
      } else {
        setSuccess(input);
      }
    }
  });

  if (valid) {
    alert('Biodata submitted successfully!');
    form.submit();
  }
}
