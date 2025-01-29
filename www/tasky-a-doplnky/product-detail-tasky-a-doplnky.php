<?php

    session_start();

    // Získání productId z parametru URL.
    if (isset($_GET["productId"])) {
        $productId = $_GET["productId"];
        
        // Načtení dat uživatelů ze souboru users.json.
        $usersData = file_get_contents('../../data-users-products/users.json');
        $usersJson = json_decode($usersData, true);

        // Načtení dat produktů ze souboru.
        $data = file_get_contents("../../data-users-products/tasky-a-doplnky-data/tasky-a-doplnky.json");
        $json = json_decode($data, true);

        // Procházení dat produktů pro nalezení konkrétního produktu podle productId.
        foreach ($json as $item) {
            if ($item["productId"] === $productId) {
                $productPrice = $item['productPrice'];
                $productName = $item['productName'];
                $username = $item["username"];
                $productImage = $item["productImage"];
                $productSize = $item["productSize"];
                $productDescription = $item["productDescription"];
                $productStatus = $item["productStatus"];

                // Získání informací o pohlaví uživatele pro zobrazení ikony.
                $gender = "";
                foreach ($usersJson as $user) {
                    if($user['username'] === $username) {
                        $gender = $user['gender'];
                        $phoneNumber = $user["phone-number"];
                        $email = $user["email"];
                        break;
                    }
                }   
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - <?php echo htmlspecialchars($productName); ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_responsive.css">
    <link rel="stylesheet" href="../css/produkty-zvlast.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Space%20Grotesk">
</head>
<body>

    <div class="mobile-menu-btn">
        <img src="../images/nav/burger.png" alt="mobile-menu-btn">
    </div>

    <header class="header-main">

        <nav>
            <a href="../index.php" class="logo">
                    <img src="../images/nav/logo.png" alt="website logo">
            </a>
            <ul>
                <li><a href="../obleceni/obleceni.php">Oblečení</a></li>
                <li><a href="../obuv/obuv.php">Obuv</a></li>
                <li><a href="../tasky-a-doplnky/tasky-a-doplnky.php">Tašky a doplňky</a></li>
                <li><a href="../bydleni/bydleni.php">Bydlení</a></li>
                <li><a href="../deti/deti.php">Děti</a></li>
                <li><a href="../zabava/zabava.php">Zábava</a></li>
                <li><a href="../mazlicci/mazlicci.php">Mazlíčci</a></li>
                <li><a href="../o-nas.php">O nás</a></li>
                <li><a href="../nase-platforma.php">Naše platforma</a></li>
            </ul>
        </nav>
        <div class="sm-links">
            <a href="#"><img src="../images/nav/instagram.png" alt="instagram link"></a>
            <a href="#"><img src="../images/nav/facebook.png" alt="facebook link"></a>
            <?php
                if (isset($_SESSION['user'])) {
                    // Uživatel je přihlášen, zobrazíme odkaz na user-page.php
                    echo '<a href="../user-page.php"><img src="../images/nav/user.png" alt="user" id="user"></a>';
                } else {
                    // Uživatel není přihlášen, zobrazíme odkazy na přihlášení a registraci
                    echo '<a href="../form/login-form.php"><img src="../images/nav/user.png" alt="user" id="user"></a>';
                }
            ?>
        </div>

    </header>

    <section class="container">

        <div class="produkt-img">
            <img src="<?php echo "." . htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
        </div>

        <div class="produkt-informace">

            <div class="user-update">
                <div class="user">
                    <img src="<?php echo '../images/nav/user-' . htmlspecialchars($gender) . '.png'; ?>" alt="user icon">
                    <p> <?php echo htmlspecialchars($username); ?></p>
                </div>
                <div class="prodani-btn">
                    <button> <?php echo htmlspecialchars($productStatus); ?> </button>
                    <?php
                        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["username"])) {
                            $currentUser = $_SESSION["user"]["username"];
                            if ($currentUser === $username || $currentUser === "MinMin24") {
                                echo '<button class="edit-product"><a href="../edit-product.php?productId=' . htmlspecialchars($productId) . '">Editovat produkt</a></button>';
                            }
                        }
                        
                    ?>
                </div>
            </div>

            <div class="informace">
                <h2> <?php echo htmlspecialchars($productName); ?> </h2>
                <p>Cena: <?php echo htmlspecialchars($productPrice); ?> </p>
                <p>Velikost: <?php echo htmlspecialchars($productSize); ?> </p>
                <h3>Popis</h3>
                <p> <?php echo htmlspecialchars($productDescription); ?> </p>
            </div>

            <div class="kontaktni-udaje">
                <h3>Kontaktní údaje</h3>
                <p>Tel: <?php echo htmlspecialchars($phoneNumber); ?> </p>
                <p>E-mail: <?php echo htmlspecialchars($email); ?> </p>
            </div>

        </div>

    </section>
    
<script src="../js/mobile-nav.js"></script>

</body>
</html>