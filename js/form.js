document.addEventListener("DOMContentLoaded", init);

function init() {
  initializeDatePicker();
  eventListenerForDate();
  removeDateOnCategoryChange()
}

function initializeDatePicker() {
  const elem = document.getElementById('datepicker');
  const today = new Date();

  const twoMonthsAhead = new Date();
  twoMonthsAhead.setMonth(today.getMonth() + 2);

  new Datepicker(elem, {
    clearButton: true,
    autohide: false,
    format: 'dd/mm',
    maxNumberOfDates: 10,
    minDate: today,
    maxDate: twoMonthsAhead,
  });
}

function eventListenerForDate() {
  const checkBox = document.getElementById("checkbox");
  const datePicker = document.getElementById('datepicker');

  checkBox.addEventListener("change", () => {
    if (checkBox.checked) {
      datePicker.disabled = true;
      clearDatePicker();
    } else {
      datePicker.disabled = false;
    }
  });
}

function removeDateOnCategoryChange() {
  const categories = document.getElementById("category");
  const dateField = document.getElementById('date-section');

  categories.addEventListener("change", () => {
    switch (categories.value) {
      case "buy":
      case "info":
        clearDatePicker();
        dateField.style.display = 'none';
        break;
      default:
        dateField.style.display = 'block';
    }
  });
}

function clearDatePicker() {
  document.getElementById('datepicker').value = "";
}