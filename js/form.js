window.addEventListener("DOMContentLoaded", init);

function init() {
  initializeDatePicker();
  addEventListeners();
}

/* --------- INITIALIZE DATEPICKER ------------ */
function initializeDatePicker() {
  const elem = document.getElementById('datepicker');
  const today = new Date();

  // set date 2 months in the future
  let twoMonthsAhead = new Date();
  twoMonthsAhead.setMonth(today.getMonth() + 2);

  new Datepicker(elem, {
    clearButton: true,
    autohide: false,
    format: 'dd/mm',
    maxNumberOfDates: 10,
    minDate: today,
    maxDate: twoMonthsAhead,
    dateDelimiter: ', ',
    language: 'sv'
  });
}

/* --------- EVENT LISTENERS ------------ */
function addEventListeners() {
  handleCheckboxChange();
  handleCategoryChange();
  handleInfoBox();
  formValidation();
}

function handleCheckboxChange() {
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

function handleCategoryChange() {
  const categoriesSelect = document.getElementById("category");
  const dateFieldDiv = document.getElementById('date-section');

  categoriesSelect.addEventListener("change", () => {
    const categoriesWithNoDate = ["buy", "info", "lost"];
    if (categoriesWithNoDate.includes(categoriesSelect.value)) {
      clearDatePicker();
      dateFieldDiv.style.display = 'none';
    } else {
      dateFieldDiv.style.display = 'block';
    }
  });
}

function handleInfoBox() {
  const infoIcon = document.getElementById("info-icon");
  const infoDiv = document.getElementById("info-box");
  infoDiv.style.display = infoDiv.style.display || "none";

  infoIcon.addEventListener("click", () => {
    infoDiv.style.display = (infoDiv.style.display === "none") ? "block" : "none";
  });

  document.addEventListener("click", (event) => {
    if (infoDiv.style.display === "block" && !infoDiv.contains(event.target) && event.target !== infoIcon) {
      infoDiv.style.display = "none";
    }
  });
}

function formValidation() {

}

function clearDatePicker() {
  document.getElementById('datepicker').value = "";
}