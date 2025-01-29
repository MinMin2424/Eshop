var showPassCheckbox = document.getElementById("show-pass");
var pass1 = document.getElementById("password1");
var pass2 = document.getElementById("password2");

showPassCheckbox.addEventListener("change", function () {
  if (showPassCheckbox.checked) {
    pass1.type = "text";
    pass2.type = "text";
  } else {
    pass1.type = "password";
    pass2.type = "password";
  }
});