<?php

/**
 * Správa uživatelských přihlášení a odhlášení.
 */

session_start();

/**
 * Funkce pro načtení uživatelů ze souboru users.json.
 * @return array Vrací pole uživatelů.
 */
function getUsers() {
    $file = '../../data-users-products/users.json';
    $data = file_get_contents($file);
    return json_decode($data, true);
}

$error = "";

// Zpracování formuláře po odeslání.
if(isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST ["password"];
    $users = getUsers();

    // Porovnání uživatelského jména a hesla s uloženými daty.
    foreach ($users as $user) {
        if ($username == $user["username"] && password_verify($password, $user["hashed-password"])) {
            $_SESSION["user"] = $user;
            header("Location: ../user-page.php");
            break;
        } else {
            $error = "Incorrect username or password.";
        }
    }
}

// Zpracování odhlášení uživatele.
if (isset($_GET["logout"])) {
    // Zrušení session při odhlášení.
    session_destroy();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Login</title>
    <link rel="stylesheet" href="../css/login-form.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Space%20Grotesk">
</head>
<body>

    <header class="header-main-form">
        <nav>
            <a href="../index.php" class="logo-form">
                    <img src="../images/nav/logo.png" alt="website logo">
            </a>
        </nav>
    </header>
    
    <div class="login-form">

        <form action="login-form.php" method="post">

            <h1>Login</h1>

            <?php echo "<span class='error'>$error</span>"; ?>

            <div class="input-box">
                <input type="text" placeholder="Username" name="username" id="username"
                    value="<?php
                                if (isset($_POST['username'])) {
                                    echo htmlspecialchars($_POST['username']);
                                    } 
                            ?>"
                >
                <img src="../images/login-form/user.png" alt="user icon">
            </div>

            <div class="input-box">
                <input type="password" placeholder="Password" name="password" id="password">
                <img src="../images/login-form/lock.png" alt="lock user">
            </div>

            <input type="checkbox" id="show-pass">Show Password

            <p id="caps-lock">Warning! Caps lock is ON!!!</p>
            
            <div class="forgot-password">
                <a href="./change_password.php">Forgot password?</a>
            </div>

            <button type="submit" class="btn" id="submit" name="submit">Login</button>

            <div class="register-link">
                <p>
                    Don't have an account?
                    <a href="registration-form.php">Register</a>
                </p>
            </div>

        </form>
    </div>

<script src="../js/caps-lock-login.js"></script>
<script src="../js/show-pass-login.js"></script>

</body>
</html>