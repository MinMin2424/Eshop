<?php

    session_start();

    if(!isset($_SESSION["user"])) {
        header("Location: ../form/login-form.php");
        exit(0);
    }

    $files = [
        "obleceni.json",
        "obuv.json",
        "tasky-a-doplnky.json",
        "bydleni.json",
        "deti.json",
        "mazlicci.json",
        "zabava.json"
    ];

    /**
     * Načtení JSON soubory a jejich obsah jako pole.
     * @var array $allProducts Pole obsahující všechny produkty.
     */
    $allProducts = [];
    foreach ($files as $file) {
        $name = pathinfo($file, PATHINFO_FILENAME);
        $content = file_get_contents("../data-users-products/" . $name . "-data/" . $file);
        $products = json_decode($content, true);
        $allProducts = array_merge($allProducts, $products);
    }

    /**
     * Ukládá aktuálního uživatele a jeho pohlaví do proměnných pro použití v HTML obsahu.
     * @var string $username Uživatelské jméno aktuálního uživatele.
     * @var string $gender Pohlaví aktuálního uživatele.
     */
    $username = $_SESSION["user"]["username"];
    $gender = $_SESSION["user"]["gender"];

    /**
     * HTML obsah pro zobrazení produktů příslušících aktuálnímu uživateli.
     * @var string $htmlContent HTML obsah pro produkty uživatele.
     */
    $htmlContent = '';

    foreach ($allProducts as $product) {
        if (isset($product['username']) && $product['username'] === $username) {
            // Vytvoření HTML pro každý produkt
            $htmlContent .= '<div class="produkt-container">
                                <div class="user-update">
                                    <img src="./images/nav/user-' . $gender . '.png" alt="img user ' . $gender . '">
                                    <p>' . $product['username'] . '</p>
                                </div>
                                <div class="produkt-img">
                                    <img src="' . $product['productImage'] . '" alt="' . $product['productName'] . '" class="produkt">
                                </div>
                                <div class="produkt-popis" id="' . $product['productId'] . '">
                                    <a href="' . $product['productPage'] . '?productId=' . $product['productId'] . '"><p>' . $product['productName'] . '</p></a>
                                    <img src="./images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                                    <img src="./images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                                    <p>' . $product['productPrice'] . '</p>
                                </div>
                            </div>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - User Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_responsive.css">
    <link rel="stylesheet" href="css/user-page.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Space%20Grotesk">
</head>
<body>

    <div class="mobile-menu-btn">
        <img src="images/nav/burger.png" alt="mobile-menu-btn">
    </div>

    <img src="./images/nav/top.png" alt="button top" id="myBtn" title="Go to top">

    <header class="header-main">

        <nav>
            <a href="index.php" class="logo">
                    <img src="images/nav/logo.png" alt="website logo">
            </a>
            <ul>
                <li><a href="./obleceni/obleceni.php">Oblečení</a></li>
                <li><a href="./obuv/obuv.php">Obuv</a></li>
                <li><a href="./tasky-a-doplnky/tasky-a-doplnky.php">Tašky a doplňky</a></li>
                <li><a href="./bydleni/bydleni.php">Bydlení</a></li>
                <li><a href="./deti/deti.php">Děti</a></li>
                <li><a href="./zabava/zabava.php">Zábava</a></li>
                <li><a href="./mazlicci/mazlicci.php">Mazlíčci</a></li>
                <li><a href="o-nas.php">O nás</a></li>
                <li><a href="nase-platforma.php">Naše platforma</a></li>
            </ul>
        </nav>

        <div class="sm-links">
            <a href="upload.php" id="upload"><img src="./images/nav/upload.png" alt=""></a>
            <a href="#" class="ins"><img src="images/nav/instagram.png" alt="instagram link"></a>
            <a href="#" class="fb"><img src="images/nav/facebook.png" alt="facebook link"></a>
            <a href="#"><img src="images/nav/user.png" alt="user" id="user"></a>
        </div>

    </header>

    <section class="main-container-page">
        <div class="main-container-header">
            <div class="welcome">
                <p>
                    <?php echo htmlspecialchars($_SESSION["user"]["username"]); ?>
                </p>

                <div class="user-image">
                    <?php
                        if($_SESSION["user"]["gender"] == "female") {
                            echo '<img src="images/nav/user-female.png" alt="img user female">';
                        } elseif ($_SESSION["user"]["gender"] == "male") {
                            echo '<img src="images/nav/user-male.png" alt="img user male">';
                        } else {
                            echo '<img src="images/nav/user-Prefer not to say.png" alt="img user">';
                        }
                    ?>
                </div>
            </div>

            <div class="logout">
                <a href="./form/login-form.php?logout">Odhlásit</a><br>
            </div>
        </div>

        <div class="informace">
            <?php 
                if (isset($_SESSION["user"]) && isset($_SESSION["user"]["username"])) {
                    $currentUser = $_SESSION["user"]["username"];
                    if ($currentUser === "MinMin24") {
                        echo '<a href="./data/seznam.php">Seznam všech uživatelů</a>';
                    }
                }
            ?>
            <p>Informace</p>
            <p class="info">
                E-mail: <?php echo htmlspecialchars($_SESSION["user"]["email"]); ?>
            </p>
            <p class="info">
                Phone number: <?php echo htmlspecialchars($_SESSION["user"]["phone-number"]); ?>
            </p>
            <p class="info">
                Birth day: <?php echo htmlspecialchars($_SESSION["user"]["birth-date"]); ?>
            </p>
            <p class="info">
                Gender: <?php echo htmlspecialchars($_SESSION["user"]["gender"]); ?>
            </p>
            <p class="info">
                Address: <?php echo htmlspecialchars($_SESSION["user"]["address"]); ?>
            </p>
            <p class="info">
                City: <?php echo htmlspecialchars($_SESSION["user"]["city"]); ?>
            </p>
            <p class="info">
                Region: <?php echo htmlspecialchars($_SESSION["user"]["region"]); ?>
            </p>
            <p class="info">
                Country: <?php echo htmlspecialchars($_SESSION["user"]["country"]); ?>
            </p>
            <a href="edit.php" class="info" id="edit">Edit</a>
        </div>

        <div class="nahrane-produkty">

            <p class="nadpis">Nahrané produkty</p>

            <?php
                echo $htmlContent;
            ?>
            
        </div>
        
    </section>
    
</body>

<script src="./js/mobile-nav.js"></script>
<script src="./js/heart.js"></script>
<script src="./js/button-top.js"></script>

</html>