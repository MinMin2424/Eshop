function loaded(event) {
    // Find form in html
    let form = document.getElementById("form-registration");
    if (form == null) {
        return;
    }
    form.addEventListener("submit", validate);

    // Find input element in html by id
    const username = document.getElementById("username");
    const emailAdress = document.getElementById("email-address");
    const phoneNumber = document.getElementById("phone-number");
    const address = document.getElementById("address");
    const city = document.getElementById("city");
    const pass1 = document.getElementById("password1");
    const pass2 = document.getElementById("password2");

    // Check if input field is not "", remove class "error" and span
    username.addEventListener("input", function() {
        checkField(username, "username-error");
    });
    emailAdress.addEventListener("input", function() {
        checkField(emailAdress, "email-error");
    });
    phoneNumber.addEventListener("input", function() {
        checkField(phoneNumber, "phone-error");
    });
    address.addEventListener("input", function() {
        checkField(address, "address-error");
    });
    city.addEventListener("input", function() {
        checkField(city, "city-error");
    });

    // Check if the password is not "", remove class "error" and span
    pass1.addEventListener("input", function() {
        checkPassword(pass1, "error1");
    });
    pass2.addEventListener("input", function() {
        checkPassword(pass2, "error2");
    });
}

// Function to remove class and span for input field
function checkField(inputField, errorId) {
    const errorSpan = document.getElementById(errorId);

    if (inputField.value.trim() !== "") {
        errorSpan.innerHTML = "";
        inputField.classList.remove("error");
    }
}

// Function to remove class and span for passwords
function checkPassword(passwordField, errorId) {
    const errorSpan = document.getElementById(errorId);

    if (passwordField.value.trim() !== "") {
        errorSpan.innerHTML = "";
        passwordField.classList.remove("error");
    }
}

function validate(event) {

    const username = document.getElementById("username");
    const emailAdress = document.getElementById("email-address");
    const phoneNumber = document.getElementById("phone-number");
    const address = document.getElementById("address");
    const city = document.getElementById("city");
    const pass1 = document.getElementById("password1");
    const pass2 = document.getElementById("password2");

    const fields = [
        { element: username, errorId: "username-error" },
        { element: emailAdress, errorId: "email-error" },
        { element: phoneNumber, errorId: "phone-error" },
        { element: address, errorId: "address-error" },
        { element: city, errorId: "city-error" },
    ];

    let isValid = true;

    // If input field is not filled, add class "error" and display span with some text
    fields.forEach(field => {
        const errorSpan = document.getElementById(field.errorId);

        if (field.element.value.trim() === "") {
            errorSpan.innerHTML = `The ${field.errorId.replace('-error', '')} is empty!`;
            field.element.classList.add("error");
            isValid = false;
        } else {
            errorSpan.innerHTML = "";
            field.element.classList.remove("error");
        }
    });

    if (!isValid) {
        event.preventDefault();
        return;
    }

    if (!validate_pass("1") || !validate_pass("2")) {
        event.preventDefault();
        return;
    }
    
    // porovnat hodnoty
    if (pass1.value.trim() != pass2.value.trim()) {
        if (document.getElementById("error3") != null) {
            document.getElementById("error3").innerHTML = "Password values do not match."
        }
        event.preventDefault();
        return;
    }
}

// Check if passwords exist and are filled
function validate_pass (number) {
    const pass = document.getElementById("password" + number);
    if (pass == null) {
        alert("we have a problem, some fields were not found.");
        return false;
    }

    if (pass.value.trim() == ""){
        var span = document.getElementById("error" + number);
        span.innerHTML = "The password is empty and don't do that!";
        pass.classList.add("error");
        return false;
    }
    return true;
}

window.addEventListener("load", loaded);