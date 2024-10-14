// Get modal elements
const modal = document.getElementById("myModal");
const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementsByClassName("close")[0];

// Open modal when button is clicked
openModalBtn.onclick = function() {
  modal.style.display = "block";
}

// Close modal when "X" is clicked
closeModalBtn.onclick = function() {
  modal.style.display = "none";
}

// Close modal when clicking outside of modal content
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
