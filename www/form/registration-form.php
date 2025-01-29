<?php

$to_return = []; // Pole pro ukládání chyb při validaci.

/**
 * Funkce pro validaci formuláře.
 * @return array Pole chyb při validaci.
 */
function validate() {
    $to_return = array(); // Inicializace pole pro chyby.

    // USERNAME POLE
    $username = trim($_POST["username"]);
    if ($username === "") {
        $to_return['username'] = "Username has to be filled!";
    } else {
        $file = "../../data-users-products/users.json";
        $current_data = file_get_contents($file);
        $data_array = json_decode($current_data, true);

        foreach($data_array as $user) {
            if ($user["username"] === $username) {
                $to_return["username"] = "Username already exists!";
                break;
            }
        }
    }

    // EMAIL-ADDRESS POLE
    $email = trim($_POST["email-address"]);
    if ($email === "") {
        $to_return['email-address'] = "Email address has to be filled!";
    }

    // PHONE-NUMBER POLE
    $phone_number = trim($_POST["phone-number"]);
    if ($phone_number === "") {
        $to_return['phone-number'] = "Phone number has be to filled!";
    } elseif (!preg_match('/\d{3}\s*\d{3}\s*\d{3}/', $phone_number)) {
        $to_return['phone-number'] = "Phone number should be in the format 000 000 000!";
    }
    
    // BIRTH-DATE POLE
    $birth_date = trim($_POST["birth-date"]);
    if ($birth_date != "") {
        $min_date = strtotime("1923-11-24");
        $max_date = strtotime("2005-11-24");
        $user_date = strtotime($birth_date);
        if (!($user_date >= $min_date)) {
            $to_return['birth-date'] = "Birth date should be between November 24, 1923 until now!";
        } elseif (!($user_date <= $max_date)) {
            $to_return['birth-date'] = "You cannot make account, because you are not 18!";
        }
    }

    // ADDRESS POLE
    $address = trim($_POST["address"]);
    if ($address === "") {
        $to_return['address'] = "Address has to be filled!";
    }

    // CITY POLE
    $city = trim($_POST["city"]);
    if ($city === "") {
        $to_return['city'] = "City has to be filled!";
    }

    // PASSWORD1 POLE
    $password1 = trim($_POST["password1"]);
    if ($password1 === "") {
        $to_return['password1'] = "Password has to be filled!";
    }
    if (strlen($password1) < 8) {
        $to_return['password1'] = "Password must contain at least 8 characters!";
    }
    if (!preg_match('/[a-z]/', $password1)) {
        $to_return['password1'] = "Password must contain at least 1 lowercase letter!";
    }
    if (!preg_match('/[A-Z]/', $password1)) {
        $to_return['password1'] = "Password must contain at least 1 uppercase letter!";
    }
    if (!preg_match('/[0-9]/', $password1)) {
        $to_return['password1'] = "Password must contain at least 1 number!";
    }

    // PASSWORD2 POLE
    $password2 = trim($_POST["password2"]);
    if ($password2 === "") {
        $to_return['password2'] = "Password has to be filled!";
    }
    if ($password2 != $password1) {
        $to_return['password2'] = "Password values do not match!";
    }

    return $to_return; // Vrátí pole chyb.
}

/**
 * Funkce pro vypsání zprávy o chybě nebo prázdném řetězci.
 * @param string $dataName Název pole chyb.
 * @param array $to_return Pole chyb při validaci.
 * @return string Zpráva o chybě nebo prázdný řetězec.
 */
function printMessage ($dataName, $to_return) {
    if (isset($to_return[$dataName])) {
        return htmlspecialchars(($to_return[$dataName]));
    } else {
        return "";
    }
}

// Načtení existujících dat.
$file = '../../data-users-products/users.json';
$current_data = file_get_contents($file);
$data_array = json_decode($current_data, true);

/**
 * Funkce pro generování nového ID pro uživatele.
 * @param array $data_array Pole uživatelských dat.
 * @return int Nové ID pro uživatele.
 */
function generateNewUserId($data_array) {
    $max_id = 0;
    foreach ($data_array as $user) {
        if ($user["id"] > $max_id) {
            $max_id = $user["id"];
        }
    }
    return $max_id + 1;
}

/**
 * Funkce pro zjištění, zda byl formulář odeslán.
 */
function isSubmittedForm() {

    global $to_return; // Globální proměnná pro ukládání chyb.

    $file = '../../data-users-products/users.json';
    $current_data = file_get_contents($file);
    $data_array = json_decode($current_data, true);

    if (isset($_POST["submit"])) {
        // Zpracování odeslaného formuláře.
        $to_return = validate(
            $_POST["username"],
            $_POST["email-address"],
            $_POST["phone-number"],
            $_POST["birth-date"],
            $_POST["address"],
            $_POST["city"],
            $_POST["password1"],
            $_POST["password2"]
        );
        if (empty($to_return)) {
            // Příprava nového uživatele.
            $new_user = array(
                'id' => generateNewUserId($data_array),
                'username' => $_POST['username'],
                'email' => $_POST['email-address'],
                'phone-number' => $_POST["phone-number"],
                'birth-date' => $_POST["birth-date"],
                'gender' => $_POST["gender"],
                'address' => $_POST["address"],
                'city' => $_POST["city"],
                'country' => $_POST["country"],
                'region' => $_POST["region"],
                'postal-code' => $_POST["postal-code"],
                'hashed-password' => password_hash($_POST["password1"], PASSWORD_DEFAULT)
            );

            // Přidání nového uživatele do pole dat.
            $data_array[] = $new_user;

            // Převedení a uložení dat zpět do souboru.
            $json_data = json_encode($data_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents($file, $json_data);

            // Přejít na login-form.php.
            header('Location: ../form/login-form.php');
            exit();
        } 
    } else {
        // Při prvním zobrazení stránky.
    }
}

isSubmittedForm(); // Zavolání funkce pro ověření odeslaného formuláře.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Formulář pro registraci</title>
    <link rel="stylesheet" href="../css/form-for-registrace.css">
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

    <section class="container-form">

        <header>Registration Form</header>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-registration" id="form-registration">

            <input type="hidden" name="id" value="">

            <div class="input-box">
                <label for="username">Username*</label>
                <input type="text" placeholder="Enter your username" id="username" name="username"
                    class="<?php echo isset($to_return['username']) ? 'error' : ''; ?>"
                    value="<?php 
                            if (isset($_POST['username'])) {
                                echo htmlspecialchars($_POST['username']);
                                } 
                            ?>"
                >
                <img src="../images/register-form/user.png" alt="user icon">
            </div>
            <span id="username-error"></span><br>
            <?php echo printMessage("username", $to_return); ?>

            <div class="input-box">
                <label for="email-address">Email Address*</label>
                <input type="email" placeholder="Enter email address - example@gmail.com" id="email-address" name="email-address"
                    class="<?php echo isset($to_return['email-address']) ? 'error' : ''; ?>"
                    value="<?php 
                            if (isset($_POST['email-address'])) {
                                echo htmlspecialchars($_POST['email-address']);
                                } 
                            ?>"
                >
                <img src="../images/register-form/mail.png" alt="mail icon">
            </div>
            <span id="email-error"></span><br>
            <?php echo printMessage("email-address", $to_return); ?>

            <div class="column-form">

                <div class="input-box">
                    <label for="phone-number">Phone Number*</label>
                    <input type="tel" placeholder="Enter phone number 000 000 000" id="phone-number" pattern="[0-9]{3} [0-9]{3} [0-9]{3}" name="phone-number"
                        class="<?php echo isset($to_return['phone-number']) ? 'error' : ''; ?>"
                        value="<?php 
                                if (isset($_POST['phone-number'])) {
                                    echo htmlspecialchars($_POST['phone-number']);
                                    } 
                                ?>"
                    >
                    <img src="../images/register-form/telephone.png" alt="tel icon">
                </div>

                <div class="input-box">
                    <label for="birth-date">Birth Date</label>
                    <input type="date" id="birth-date" name="birth-date"
                        class="<?php echo isset($to_return['birth-date']) ? 'error' : ''; ?>"
                        value="<?php 
                                if (isset($_POST['birth-date'])) {
                                    echo htmlspecialchars($_POST['birth-date']);
                                    } 
                                ?>"
                    >
                </div>

            </div>
            <?php echo printMessage("phone-number", $to_return) ?> <br>
            <?php echo printMessage("birth-date", $to_return); ?>
            <span id="phone-error"></span>

            <div class="input-box">
                <label>Gender</label>
                <div class="select-box">
                    <select id="gender" name="gender">
                        <option value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'male') echo 'selected="selected"'; ?> >Male</option>
                        <option value="female" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'female') echo 'selected="selected"'; ?> >Female</option>
                    </select>
                </div>
            </div>

            <div class="input-box address">
                <label for="address">Address*</label>
                <input type="text" placeholder="Enter street address*" id="address" name="address"
                    class="<?php echo isset($to_return['address']) ? 'error' : ''; ?>"
                    value="<?php 
                            if (isset($_POST['address'])) {
                                echo htmlspecialchars($_POST['address']);
                                } 
                            ?>"
                >
                <span id="address-error"></span>
                <?php echo printMessage("address", $to_return); ?>
                <div class="input-box">
                    <div class="select-box">
                        <select name="country" id="countrySelect">
                            <option value="country" <?php if ((!isset($_POST['country'])) || (isset($_POST['country']) && $_POST['country'] === 'country')) echo 'selected="selected"'; ?> >Country</option>
                            <option value="Argentina" <?php if (isset($_POST['country']) && $_POST['country'] === 'Argentina') echo 'selected="selected"'; ?> >Argentina</option>
                            <option value="Australia" <?php if (isset($_POST['country']) && $_POST['country'] === 'Australia') echo 'selected="selected"'; ?> >Australia</option>
                            <option value="Austria" <?php if (isset($_POST['country']) && $_POST['country'] === 'Austria') echo 'selected="selected"'; ?> >Austria</option>
                            <option value="Belgium" <?php if (isset($_POST['country']) && $_POST['country'] === 'Belgium') echo 'selected="selected"'; ?> >Belgium</option>
                            <option value="Brazil" <?php if (isset($_POST['country']) && $_POST['country'] === 'Brazil') echo 'selected="selected"'; ?> >Brazil</option>
                            <option value="Canada" <?php if (isset($_POST['country']) && $_POST['country'] === 'Canada') echo 'selected="selected"'; ?> >Canada</option>
                            <option value="Central African Republic" <?php if (isset($_POST['country']) && $_POST['country'] === 'Central African Republic') echo 'selected="selected"'; ?> >Central African Republic</option>
                            <option value="Chile" <?php if (isset($_POST['country']) && $_POST['country'] === 'Chile') echo 'selected="selected"'; ?> >Chile</option>
                            <option value="China" <?php if (isset($_POST['country']) && $_POST['country'] === 'China') echo 'selected="selected"'; ?> >China</option>
                            <option value="Croatia" <?php if (isset($_POST['country']) && $_POST['country'] === 'Croatia') echo 'selected="selected"'; ?> >Croatia</option>
                            <option value="Cuba" <?php if (isset($_POST['country']) && $_POST['country'] === 'Cuba') echo 'selected="selected"'; ?> >Cuba</option>
                            <option value="Czech Republic" <?php if (isset($_POST['country']) && $_POST['country'] === 'Czech Republic') echo 'selected="selected"'; ?> >Czech Republic</option>
                            <option value="Denmark" <?php if (isset($_POST['country']) && $_POST['country'] === 'Denmark') echo 'selected="selected"'; ?> >Denmark</option>
                            <option value="Egypt" <?php if (isset($_POST['country']) && $_POST['country'] === 'Egypt') echo 'selected="selected"'; ?> >Egypt</option>
                            <option value="Finland" <?php if (isset($_POST['country']) && $_POST['country'] === 'Finland') echo 'selected="selected"'; ?> >Finland</option>
                            <option value="France" <?php if (isset($_POST['country']) && $_POST['country'] === 'France') echo 'selected="selected"'; ?> >France</option>
                            <option value="German" <?php if (isset($_POST['country']) && $_POST['country'] === 'German') echo 'selected="selected"'; ?> >Germany</option>
                            <option value="India" <?php if (isset($_POST['country']) && $_POST['country'] === 'India') echo 'selected="selected"'; ?> >India</option>
                            <option value="Italy" <?php if (isset($_POST['country']) && $_POST['country'] === 'Italy') echo 'selected="selected"'; ?> >Italy</option>
                            <option value="Japan" <?php if (isset($_POST['country']) && $_POST['country'] === 'Japan') echo 'selected="selected"'; ?> >Japan</option>
                            <option value="Luxembourg" <?php if (isset($_POST['country']) && $_POST['country'] === 'Luxembourg') echo 'selected="selected"'; ?> >Luxembourg</option>
                            <option value="Mexico" <?php if (isset($_POST['country']) && $_POST['country'] === 'Mexico') echo 'selected="selected"'; ?> >Mexico</option>
                            <option value="New Zealand" <?php if (isset($_POST['country']) && $_POST['country'] === 'New Zealand') echo 'selected="selected"'; ?> >New Zealand</option>
                            <option value="Norway" <?php if (isset($_POST['country']) && $_POST['country'] === 'Norway') echo 'selected="selected"'; ?> >Norway</option>
                            <option value="Poland" <?php if (isset($_POST['country']) && $_POST['country'] === 'Poland') echo 'selected="selected"'; ?> >Poland</option>
                            <option value="Russia" <?php if (isset($_POST['country']) && $_POST['country'] === 'Russia') echo 'selected="selected"'; ?> >Russia</option>
                            <option value="Singapore" <?php if (isset($_POST['country']) && $_POST['country'] === 'Singapore') echo 'selected="selected"'; ?> >Singapore</option>
                            <option value="Slowakia" <?php if (isset($_POST['country']) && $_POST['country'] === 'Slowakia') echo 'selected="selected"'; ?> >Slowakia</option>
                            <option value="South Korea" <?php if (isset($_POST['country']) && $_POST['country'] === 'South Korea') echo 'selected="selected"'; ?> >South Korea</option>
                            <option value="Sweden" <?php if (isset($_POST['country']) && $_POST['country'] === 'Sweden') echo 'selected="selected"'; ?> >Sweden</option>
                            <option value="Switzerland" <?php if (isset($_POST['country']) && $_POST['country'] === 'Switzerland') echo 'selected="selected"'; ?> >Switzerland</option>
                            <option value="Thailand" <?php if (isset($_POST['country']) && $_POST['country'] === 'Thailand') echo 'selected="selected"'; ?> >Thailand</option>
                            <option value="The United State of America" <?php if (isset($_POST['country']) && $_POST['country'] === 'The United State of America') echo 'selected="selected"'; ?> >The United State of America</option>
                            <option value="The United Kingdom of GB and Northern Ireland" <?php if (isset($_POST['country']) && $_POST['country'] === 'The United Kingdom of GB and Northern Ireland') echo 'selected="selected"'; ?> >The United Kingdom of GB and Northern Ireland</option>
                            <option value="Ukraine" <?php if (isset($_POST['country']) && $_POST['country'] === 'Ukraine') echo 'selected="selected"'; ?> >Ukraine</option>
                            <option value="Vietnam" <?php if (isset($_POST['country']) && $_POST['country'] === 'Vietnam') echo 'selected="selected"'; ?> >Vietnam</option>
                        </select>
                    </div>
                    <input type="text" placeholder="Enter your city*" id="city" name="city"
                        onkeyup="showHint(this.value)"
                        class="<?php echo isset($to_return['city']) ? 'error' : ''; ?>"
                        value="<?php 
                                if (isset($_POST['city'])) {
                                    echo htmlspecialchars($_POST['city']);
                                    } 
                                ?>"
                    >
                    <span id="city-error"></span>
                    <span id="txtHint"></span>
                    <?php echo printMessage("city", $to_return); ?>
                </div>

                <div class="column-form">
                    <input type="text" placeholder="Enter your region" id="region" name="region"
                        value="<?php 
                                if (isset($_POST['region'])) {
                                    echo htmlspecialchars($_POST['region']);
                                }
                        ?>"
                    >
                    <input type="number" placeholder="Enter postal code" id="postal-code" name="postal-code"
                        value="<?php 
                                if (isset($_POST['postal-code'])) {
                                    echo htmlspecialchars($_POST['postal-code']);
                                }
                        ?>"
                    >
                </div>

                <div class="password">
                    <label>Password*</label>
                    <p>It must contain at least 1 number, 1 uppercase and 1 lowercase letter and at least 8 characters</p>
                    <div class="column-form">
                        <input type="password" placeholder="Put your password" id="password1" name="password1" class="<?php echo isset($to_return['password1']) ? 'error' : ''; ?>"><br>
                        <input type="password" placeholder="Put again your password" id="password2" name="password2" class="<?php echo isset($to_return['password2']) ? 'error' : ''; ?>"><br>
                    </div>
                    <input type="checkbox" id="show-pass">Show Password
                    <p id="caps-lock">Warning! Caps lock is ON!!!</p>
                    <span id="error1"></span>
                    <?php echo printMessage("password1", $to_return); ?>
                    <span id="error2"></span>
                    <?php echo printMessage("password2", $to_return); ?>
                    <div id="message">
                        <h3>Password must contain the following:</h3>
                        <p id="letter" class="invalid">A lowercase letter</p>
                        <p id="capital" class="invalid">A capital (uppercase) letter</p>
                        <p id="number" class="invalid">A number</p>
                        <p id="length" class="invalid">Minimum 8 characters</p>
                    </div>
                    <div id="error3"></div>
                </div>
            </div>

            <button type="submit" id="submit" name="submit">Submit</button>

        </form>

    </section>

<script src="../js/show-password.js"></script>
<script src="../js/pass-validate.js"></script>
<script src="../js/caps-lock-register.js"></script>
<script src="../js/form-register-error.js"></script>
<script src="../js/show-hint.js"></script>

</body>
</html>