function updateLoginLink(isLoggedIn) {
    var loginLink = document.getElementById("user");
    var user_info = document.getElementById("user-info");
        if (isLoggedIn) {
            loginLink.href = "/user-page.html";
            user_info.style.display = "none";
        } else {
            loginLink.href = "/form-login.html";
        }
    }

var isLoggedIn = true;
updateLoginLink(isLoggedIn);
