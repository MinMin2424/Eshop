<?php

$user_error = "";

if (isset($_POST['submit'])) {
    // Načtení obsahu souboru s informacemi o uživatelích
    $users_json = file_get_contents('../../data-users-products/users.json');
    $users = json_decode($users_json, true);

    // Získání dat z formuláře
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $errors = []; // Pole pro uchování chybových hlášek

    // Validace
    if (empty($username) || empty($email) || empty($password) || empty($password2)) {
        $errors[] = "All fields must be filled!";
    }

    if ($password !== $password2) {
        $errors[] = "Password values do not match!";
    }

    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password)) {
        $errors[] = "Password must contain at least 8 characters, 1 lowercase letter, 1 uppercase letter and 1 number!";
    }

    // Pokud nejsou chyby, pokračujeme s procesem změny hesla
    if (empty($errors)) {
        $userExists = false;
        foreach ($users as $key => $user) {
            if ($user['username'] === $username && $user['email'] === $email) {
                $userExists = true;
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $users[$key]['hashed-password'] = $hashed_password;
                break;
            }
        }

        if ($userExists) {
            file_put_contents('../../data-users-products/users.json', json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            header("Location: ./login-form.php");
            exit();
        } else {
            $user_error = "The user doesn't exist or the username or email entered isn't correct for the given user!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Change Password</title>
    <link rel="stylesheet" href="../css/change_password.css">
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

    <div class="change-pass-form">

        <form action="change_password.php" method="post">

            <h1>Change Password</h1>

            <div class="input-box">

                <label for="username">Username*:</label>
                <input type="text" id="username" name="username" <?php if(isset($_POST['submit']) && empty($_POST['username'])) { echo 'class="error"'; }?>
                    value="<?php 
                                if (isset($_POST['username'])) {
                                    echo htmlspecialchars($_POST['username']);
                                    } 
                            ?>"
                    placeholder="<?php
                                    if (isset($_POST['submit']) && empty($_POST['username'])) {
                                        echo 'Username has to be filled!';
                                    }
                                ?>"
                ><br>
                
            </div>

            <div class="input-box">

                <label for="email">Email*:</label>
                <input type="email" id="email" name="email" <?php if(isset($_POST['submit']) && empty($_POST['email'])) { echo 'class="error"'; }?>
                    value="<?php 
                                if (isset($_POST['email'])) {
                                    echo htmlspecialchars($_POST['email']);
                                    } 
                            ?>"
                    placeholder="<?php
                                    if (isset($_POST['submit']) && empty($_POST['email'])) {
                                        echo 'Email address has to be filled!';
                                    }
                                ?>"
                ><br>
                
            </div>
            <div class="input-box">

                <label for="password">Password*:</label>
                <input type="password" id="password" name="password" <?php if(isset($_POST['submit']) && empty($_POST['password'])) { echo 'class="error"'; }?>
                    placeholder="<?php
                                    if (isset($_POST['submit']) && empty($_POST['password'])) {
                                        echo 'Password has to be filled!';
                                    }
                                ?>"
                ><br>
                
            </div>
            <div class="input-box">

                <label for="password2">Put again password*:</label>
                <input type="password" id="password2" name="password2" <?php if(isset($_POST['submit']) && empty($_POST['password2'])) { echo 'class="error"'; }?>
                    placeholder="<?php
                                    if (isset($_POST['submit']) && empty($_POST['password2'])) {
                                        echo 'Password has to be filled!';
                                    }
                                ?>"
                ><br>
                
            </div>

            <input type="checkbox" id="show-pass">Show Password
            <p id="caps-lock">Warning! Caps lock is ON!!!</p>

            <button type="submit" class="btn" id="submit" name="submit">Change Password</button>

        </form>
        <div id="error_messages">
            <?php
                // Zobrazení chybových hlášek a označení polí s chybami
                if (!empty($errors)) {
                    echo '<div class="error_messages">';
                    foreach ($errors as $error) {
                        echo '<p>' . $error . '</p>';
                    }
                    echo '</div>';
                }
            ?>
        </div>

        <?php
            echo $user_error;
        ?>

    </div>

<script src="../js/caps-lock-change-pass.js"></script>
<script src="../js/show-password-change-pass.js"></script>
</body>
</html>