// Config
const isOpenClass = "modal-is-open";
const openingClass = "modal-is-opening";
const closingClass = "modal-is-closing";
const animationDuration = 400; // ms

// Toggle modal
async function toggleModal(event, modalId) {
  event.preventDefault();
  const modal = document.getElementById(modalId);
  modal.open ? closeModal(modal) : openModal(modal);
};

// Open modal
function openModal(modal) {
  const { documentElement: html } = document;
  html.classList.add(isOpenClass, openingClass);

  clearForm();

  setTimeout(() => {
    html.classList.remove(openingClass);
  }, animationDuration);
  modal.showModal();
};

// Close modal
function closeModal(modal) {
  const { documentElement: html } = document;
  html.classList.add(closingClass);

  clearForm();

  setTimeout(() => {
    html.classList.remove(closingClass, isOpenClass);
    modal.close();
  }, animationDuration);
};

function clearForm() {
  let form = document.querySelector("#upload-form");
  form.reset();

  document.querySelectorAll(".validation-error").forEach(element => {
    element.classList.remove("validation-error");
  });
  document.getElementById("info-box").style.display = "none";
}