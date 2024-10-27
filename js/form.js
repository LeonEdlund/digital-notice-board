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
  const titleInput = document.querySelector("input[name='title']");
  const categoryInput = document.querySelector("select[name='category']");
  const dateInput = document.querySelector("input[name='date']");
  const checkBoxInput = document.querySelector("input[name='no-date']");
  const descriptionInput = document.querySelector("textarea[name='description']");
  const inputs = [titleInput, categoryInput, dateInput, descriptionInput];

  document.getElementById("upload-form").addEventListener("submit", (e) => {
    let valid = true;

    if (titleInput.value.trim() === "") {
      showError(titleInput, "Fyll i en titel");
      valid = false;
    }

    if (categoryInput.value.trim() === "") {
      showError(categoryInput, "Välj en kategori");
      valid = false;
    }

    if (!checkBoxInput.checked && categoryInput.options[categoryInput.selectedIndex].dataset.date !== "no-date") {
      if (dateInput && dateInput.value.trim() === "") {
        showError(dateInput, "Välj ett datum");
        valid = false;
      }
    }

    if (descriptionInput.value.trim() === "") {
      showError(descriptionInput, "Fyll i en beskrivning");
      valid = false;
    }

    inputs.forEach(input => {
      if (input.value.trim() !== "" && input.classList.contains("validation-error")) {
        input.classList.remove("validation-error");
        input.placeholder = "";
      }
    });

    // Prevent form submission if any errors exist
    if (!valid) {
      e.preventDefault();
    }
  })

  inputs.forEach(input => {
    input.addEventListener("click", () => {
      input.classList.remove("validation-error");
    })

  })
}

function showError(elem, message) {
  elem.classList.add("validation-error");
  elem.placeholder = message;
}

function clearDatePicker() {
  document.getElementById('datepicker').value = "";
}