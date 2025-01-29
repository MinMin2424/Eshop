<?php

/**
 * Zpracování editace
 */

 // Spuštění session pro ukládání dat o uživateli.
session_start();

if (isset($_GET["id"])) {
    $userId = $_GET["id"];

    $data = file_get_contents("../../data-users-products/users.json");
    $json = json_decode($data, true);

    foreach ($json as $user) {
        if ($user["id"] == $userId) {
            $username = $user['username'];
            $email = $user['email'];
            $phoneNumber = $user["phone-number"];
            $birthDate = $user["birth-date"];
            $gender = $user["gender"];
            $address = $user['address'];
            $city = $user['city'];
            $country = $user['country'];
            $region = $user['region'];
            $postalCode = $user['postal-code'];
            break;
        }
    }
} else {
    
}

// Zpracování POST po odeslání formuláře.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {
        $userId = $_POST['userId'];
        $newUsername = $_POST['username'];
        $newEmail = $_POST['email'];
        $newPhoneNumber = $_POST['phoneNumber'];
        $newBirthDate = $_POST['birthDate'];
        $newGender = $_POST['gender'];
        $newAddress = $_POST['address'];
        $newCity = $_POST['city'];
        $newCountry = $_POST['country'];
        $newRegion = $_POST['region'];
        $newPostalCode = $_POST['postalCode'];

        $data = file_get_contents("../../data-users-products/users.json");
        $json = json_decode($data, true);

        foreach ($json as &$user) {
            if ($user["id"] == $userId) {
                $user['username'] = $newUsername;
                $user['email'] = $newEmail;
                $user['phone-number'] = $newPhoneNumber;
                $user['birth-date'] = $newBirthDate;
                $user['gender'] = $newGender;
                $user['address'] = $newAddress;
                $user['city'] = $newCity;
                $user['country'] = $newCountry;
                $user['region'] = $newRegion;
                $user['postal-code'] = $newPostalCode;
                break;
            }
        }

        // Uložení změn do souboru specifické kategorie.
        file_put_contents("../../data-users-products/users.json", json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        
        // Přesměřování zpět na detail produktu po editaci.
        header("Location: ./seznam.php");
        exit();
    }

    if (isset($_POST['delete'])) {
        $userId = $_POST['userId'];

        $data = file_get_contents("../../data-users-products/users.json");
        $json = json_decode($data, true);

        foreach ($json as $key => $user) {
            if ($user["id"] == $userId) {
                unset($json[$key]);
                break;
            }
        }

        file_put_contents("../../data-users-products/users.json", json_encode(array_values($json), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        
        header("Location: ./seznam.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Edit produktu</title>
    <link rel="stylesheet" href="../css/edit-product.css">
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

        <header>
            Edit
        </header>

        <form method="post" action="edit-data.php"  class="edit-product" id="edit-data">

            <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">

            <div class="input-box">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo isset($phoneNumber) ? htmlspecialchars($phoneNumber) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="birthDate">Birth Date:</label>
                <input type="text" id="birthDate" name="birthDate" value="<?php echo isset($birthDate) ? htmlspecialchars($birthDate) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo isset($gender) ? htmlspecialchars($gender) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo isset($address) ? htmlspecialchars($address) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo isset($city) ? htmlspecialchars($city) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" value="<?php echo isset($country) ? htmlspecialchars($country) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="region">Region:</label>
                <input type="text" id="region" name="region" value="<?php echo isset($region) ? htmlspecialchars($region) : ''; ?>"><br><br>
            </div>

            <div class="input-box">
                <label for="postalCode">Postal Code:</label>
                <input type="text" id="postalCode" name="postalCode" value="<?php echo isset($postalCode) ? htmlspecialchars($postalCode) : ''; ?>"><br><br>
            </div>

            <input name="submit" type="submit" class="submit" value="Save">

        </form>
        <form method="post" action="edit-data.php"  class="edit-product" id="edit-data">
            <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">
            <input type="submit" name="delete" id="delete" class="submit" value="Delete">
        </form>

    </section>
    </form>
</body>
</html>

