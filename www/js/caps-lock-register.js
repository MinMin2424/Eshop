// REGISTER FORM

var myInput = document.getElementById("password1");
var myInput2 = document.getElementById("password2");
var text = document.getElementById("caps-lock");


// When the user presses any key on the keyboard, run the function
myInput.addEventListener("keyup", function(event) {
  if (event.getModifierState("CapsLock")) {
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
});

myInput2.addEventListener("keyup", function(event) {
    if (event.getModifierState("CapsLock")) {
      text.style.display = "block";
    } else {
      text.style.display = "none";
    }
  });

