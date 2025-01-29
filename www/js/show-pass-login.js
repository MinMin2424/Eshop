var showPassCheckbox = document.getElementById("show-pass");
var pass = document.getElementById("password");

showPassCheckbox.addEventListener("change", function () {
  if (showPassCheckbox.checked) {
    pass.type = "text";
  } else {
    pass.type = "password";
  }
});