<?php

    /**
     * Spustí nebo obnoví existující relaci.
     */
    session_start();

    // Přesměřování na přihlašovací formulář, pokud uživatel není přihlášen.
    if (!isset($_SESSION['user'])) {
        header("Location: ./form/login-form.php");
        exit();
    }

    // Získání ID uživatele a všechna uživatelská data.
    $userId = $_SESSION['user']['id'];
    $usersData = file_get_contents('../data-users-products/users.json');
    $users = json_decode($usersData, true);

    // Proměnná pro aktualizaci uživatele.
    $userToUpdate = null;

    // Najít uživatele v poli uživatelů pro aktualizaci.
    foreach ($users as $index => $user) {
        if ($user['id'] === $userId) {
            $userToUpdate = &$users[$index];
            break;
        }
    }

    // Zastavit se s chybou, pokud uživatel není nalezen.
    if (!$userToUpdate) {
        die('Uživatel nenalezen.');
    }

    /**
     * Funkce pro validaci vstupní data.
     * @param mixed[] $inputData Vstupní data z formuláře.
     * @param mixed[] $users Pole uživatelů.
     * @return mixed[] Pole chyb.
     */
    function validate($inputData, $users) {
        $errors = [];

        // Kontrolovat prázdná pole.
        foreach ($inputData as $key => $value) {
            if (empty($value)) {
                $errors[$key] = "Pole " . $key . " musí být vyplněno.";
            }
        }

        // Kontrolovat správnost pole pohlaví.
        $validGenders = ["female", "male", "Prefer not to say"];
        $gender = $inputData["gender"];
        if (!in_array($gender, $validGenders)) {
            $errors["gender"] = "Nesprávně vyplněné pole pro pohlaví (female / male / Prefer not to say).";
        }

        return $errors;
    }

    // Pole pro chyby
    $errors = [];

    // Pokud je použita metoda POST.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Validace stupních dat.
        $errors = validate($_POST, $users);

        // Pokud nejsou žádné chyby, aktualizuje informace o uživateli.
        if (empty($errors)) {
            $_SESSION['user']['email'] = $_POST['email'];
            $_SESSION['user']['phone-number'] = $_POST['phone-number'];
            $_SESSION['user']['birth-date'] = $_POST['birth-date'];
            $_SESSION['user']['gender'] = $_POST['gender'];
            $_SESSION['user']['address'] = $_POST['address'];
            $_SESSION['user']['country'] = $_POST['country'];
            $_SESSION['user']['city'] = $_POST['city'];
            $_SESSION['user']['region'] = $_POST['region'];
            $_SESSION['user']['postal-code'] = $_POST['postal-code'];

            // Přepsání pole $users aktualizovanými daty z session proměnných
            foreach ($users as $index => $user) {
                if ($user['id'] === $userId) {
                    $users[$index] = $_SESSION['user'];
                    break;
                }
            }

            // Zapíše změny zpět do souboru.
            file_put_contents('../data-users-products/users.json', json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            header("Location: user-page.php");
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User Information</title>
    <link rel="stylesheet" href="./css/edit.css">
</head>
<body>

<div class="edit-form">

<h1>Edit User Information</h1>

<form action="edit.php" method="post">

    <div class="column-form">

        <div class="input-box">
            <label for="email">Email*:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userToUpdate['email']); ?>"
                        class="<?php echo isset($errors['email']) ? 'error' : ''; ?>">
                <?php
                    if (isset($errors["email"])) {
                        echo $errors['email'];
                    }
                ?>
        </div>

        <div class="input-box">
            <label for="phone">Phone Number*:</label>
            <input type="text" id="phone" name="phone-number" value="<?php echo htmlspecialchars($userToUpdate['phone-number']); ?>"
                        class="<?php echo isset($errors['phone-number']) ? 'error' : ''; ?>">
                <?php
                    if (isset($errors["phone-number"])) {
                        echo $errors['phone-number'];
                    }
                ?>
        </div>

    </div>

    <div class="column-form">

        <div class="input-box">
            <label for="birth-date">Birth Date:</label>
            <input type="date" id="birth-date" name="birth-date" value="<?php echo htmlspecialchars($userToUpdate['birth-date']); ?>"
                        class="<?php echo isset($errors['birth-date']) ? 'error' : ''; ?>">
                <?php
                    if (isset($errors["birth-date"])) {
                        echo $errors['birth-date'];
                    }
                ?>
        </div>

        <div class="input-box">
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($userToUpdate['gender']); ?>"
                        class="<?php echo isset($errors['gender']) ? 'error' : ''; ?>">
                <?php
                    if (isset($errors["gender"])) {
                        echo $errors['gender'];
                    }
                ?>
        </div>

    </div>

    <div class="input-box">
        <label for="address">Address*:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userToUpdate['address']); ?>"
                    class="<?php echo isset($errors['address']) ? 'error' : ''; ?>">
            <?php
                if (isset($errors["address"])) {
                    echo $errors['address'];
                }
            ?>
    </div>

    <div class="column-form">

        <div class="input-box">
            <label for="city">City*:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($userToUpdate['city']); ?>"
                        class="<?php echo isset($errors['city']) ? 'error' : ''; ?>">
                <?php
                    if (isset($errors["city"])) {
                        echo $errors['city'];
                    }
                ?>
        </div>

        <div class="input-box">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($userToUpdate['country']); ?>"
                            class="<?php echo isset($errors['country']) ? 'error' : ''; ?>">
                    <?php
                        if (isset($errors["country"])) {
                            echo $errors['country'];
                        }
                    ?>
        </div>

    </div>

    <div class="column-form">

        <div class="input-box">
                <label for="region">Region:</label>
                <input type="text" id="region" name="region" value="<?php echo htmlspecialchars($userToUpdate['region']); ?>"
                            class="<?php echo isset($errors['region']) ? 'error' : ''; ?>">
                    <?php
                        if (isset($errors["region"])) {
                            echo $errors['region'];
                        }
                    ?>
        </div>

        <div class="input-box">
                <label for="postal-code">Postal Code:</label>
                <input type="number" id="postal-code" name="postal-code" value="<?php echo htmlspecialchars($userToUpdate['postal-code']); ?>"
                            class="<?php echo isset($errors['postal-code']) ? 'error' : ''; ?>">
                    <?php
                        if (isset($errors["postal-code"])) {
                            echo $errors['postal-code'];
                        }
                    ?>
        </div>

    </div>

    <input type="submit" id="submit" name="submit" value="Save">
</form>

</div>

</body>
</html>