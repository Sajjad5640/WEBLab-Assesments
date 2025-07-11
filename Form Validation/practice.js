document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('biodata-form');
  const inputs = form.querySelectorAll('input, select, textarea');
  const radioGroups = form.querySelectorAll('.radio-group');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (validateInputs()) {
      generatePDF();
    }
  });

  const setError = (element, message) => {
    const inputControl = element.closest('.input-control');
    const errorDisplay = inputControl.querySelector('.error');
    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success');
  };

  const setSuccess = (element) => {
    const inputControl = element.closest('.input-control');
    const errorDisplay = inputControl.querySelector('.error');
    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
  };

  const isValidEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email.toLowerCase());
  };

  const isValidPhone = (phone) => {
    const re = /^[0-9]{10,15}$/;
    return re.test(phone);
  };

  function validateInputs() {
    let valid = true;

    // Text, number, date, email, select, textarea
    inputs.forEach((input) => {
      if (
        input.type !== 'radio' &&
        input.type !== 'checkbox' &&
        input.type !== 'submit' &&
        input.type !== 'button'
      ) {
        const value = input.value.trim();
        if (!value) {
          setError(input, `${input.name} is required`);
          valid = false;
        } else if (input.id === 'email' && !isValidEmail(value)) {
          setError(input, 'Invalid email format');
          valid = false;
        } else if (input.id === 'phone' && !isValidPhone(value)) {
          setError(input, 'Invalid phone number');
          valid = false;
        } else {
          setSuccess(input);
        }
      }
    });

    // Radio validation
    radioGroups.forEach((group) => {
      const name = group.querySelector('input')?.name;
      if (name && !form.querySelector(`input[name="${name}"]:checked`)) {
        setError(group.querySelector('input'), `Please select an option`);
        valid = false;
      } else if (name) {
        setSuccess(group.querySelector('input'));
      }
    });

    return valid;
  }

  function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    let y = 20;

    const getRadioValue = (name) => {
      const checked = form.querySelector(`input[name="${name}"]:checked`);
      return checked ? checked.value : '';
    };

    const getCheckboxValues = (name) => {
      return Array.from(form.querySelectorAll(`input[name="${name}"]:checked`))
        .map((el) => el.value)
        .join(', ');
    };

    doc.setFontSize(18);
    doc.setTextColor(106, 17, 203);
    doc.text('Matrimonial Biodata', 105, y, { align: 'center' });
    y += 10;

    doc.setDrawColor(106, 17, 203);
    doc.line(20, y, 190, y);
    y += 10;

    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);

    const addLine = (label, value) => {
      if (y > 280) {
        doc.addPage();
        y = 20;
      }
      doc.text(`${label}: ${value}`, 20, y);
      y += 8;
    };

    addLine('Full Name', form.fullName.value);
    addLine('Email', form.email.value);
    addLine('Date of Birth', form.dob.value);
    addLine('Gender', getRadioValue('gender'));
    addLine('Marital Status', getRadioValue('marital'));
    addLine('Blood Group', form.blood.value);
    addLine('Height (cm)', form.height.value);
    addLine('Weight (kg)', form.weight.value);
    addLine('Body Color', getRadioValue('color'));
    addLine('Family Members', form.family.value);
    addLine('Education', form.education.value);
    addLine('Profession', form.profession.value);
    addLine('Languages Known', getCheckboxValues('languages') || 'None');
    addLine('Hobbies', getCheckboxValues('hobbies') || 'None');
    addLine('Nationality', form.nationality.value);

    // Multi-line Address
    const addressLines = doc.splitTextToSize(`Address: ${form.address.value}`, 170);
    addressLines.forEach((line) => {
      doc.text(line, 20, y);
      y += 7;
    });

    addLine('Phone Number', form.phone.value);

    // Save the PDF
    doc.save('matrimonial_biodata.pdf');
  }
});
