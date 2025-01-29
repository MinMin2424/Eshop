function loaded(event) {
    // Najít formulář v html
    // document.getElementById() or document.querySelector() or document.form[0]
    let form = document.getElementById("form-registration");
    if (form == null) {
        return;
    }
    // zaregistrovat submit formuláře na funkci validate
    form.addEventListener("submit", validate);
}


function validate(event) {
    const pass1 = document.getElementById("password1");
    const pass2 = document.getElementById("password2");

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

window.addEventListener('load', loaded);