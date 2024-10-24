// Config
const isOpenClass = "modal-is-open";
const openingClass = "modal-is-opening";
const closingClass = "modal-is-closing";
const animationDuration = 400; // ms

// Toggle modal
async function toggleModal(event, modalId, postId = "NO-POST") {
  event.preventDefault();
  const modal = document.getElementById(modalId);

  if (postId !== "NO-POST") {
    const result = await fetchPost(postId);
    setModalInfo(modal, result, postId);
  }

  modal.open ? closeModal(modal) : openModal(modal);
};

// Open modal
function openModal(modal) {
  const { documentElement: html } = document;
  html.classList.add(isOpenClass, openingClass);

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

// get post from db
async function fetchPost(postId) {
  const url = `models/post-get.php?post=${postId}`;
  const response = await fetch(url);

  if (!response.ok) {
    throw new Error(`Response status: ${response.status}`);
  }

  const json = await response.json();
  return json;
}

function setModalInfo(modal, result) {
  const modalWrapper = modal.querySelector("#modal-wrapper");
  modalWrapper.innerHTML = "";

  // create elements
  let hgroup = document.createElement("hgroup");
  let title = document.createElement("h2");
  let date = document.createElement("h3");
  let text = document.createElement("p");
  let img = document.createElement("img");

  // populate elements
  title.innerHTML = result.title;
  date.innerHTML = result.created_at;
  text.innerHTML = result.body;
  img.setAttribute("src", result.img);

  // Append the image as a child to the modal
  hgroup.appendChild(title)
  hgroup.appendChild(date)
  modalWrapper.appendChild(img);
  modalWrapper.appendChild(hgroup);
  modalWrapper.appendChild(text);
}

function clearForm() {
  document.querySelector("form").reset();
  document.querySelectorAll(".validation-error").forEach(element => {
    element.classList.remove("validation-error");
  });
  document.getElementById("info-box").style.display = "none";
}