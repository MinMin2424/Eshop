let mybutton = document.getElementById("myBtn");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// Add event listener to handle click on the button
mybutton.addEventListener("click", topFunction);

function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}