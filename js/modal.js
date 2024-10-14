// Config
const isOpenClass = "modal-is-open";
const openingClass = "modal-is-opening";
const closingClass = "modal-is-closing";
const animationDuration = 500; // ms

// Toggle modal
async function toggleModal(event, modalId, postId = null) {
  event.preventDefault();
  const modal = document.getElementById(modalId);

  if (postId) {
    const result = await fetchPost(postId);
    setModalInfo(modal, result);
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

  setTimeout(() => {
    html.classList.remove(closingClass, isOpenClass);
    modal.close();
  }, animationDuration);
};

// get post from db
async function fetchPost(postId) {
  const url = `post-get.php?post=${postId}`;
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`Response status: ${response.status}`);
    }

    const json = await response.json();
    return json;
  } catch (error) {
    console.error(error.message);
  }
}

function setModalInfo(modal, result) {
  title = modal.querySelector("h2");
  p = modal.querySelector("p");
  title.innerHTML = result[0].title;
  p.innerHTML = result[0].text;
}