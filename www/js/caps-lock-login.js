// LOGIN FORM

document.addEventListener("DOMContentLoaded", function () {
    var myInput3 = document.getElementById("password");
    var text = document.getElementById("caps-lock");
  
    myInput3.addEventListener("keyup", function (event) {
      if (event.getModifierState("CapsLock")) {
        text.style.display = "block";
      } else {
        text.style.display = "none";
      }
    });
  });