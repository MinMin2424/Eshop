<?php
    /**
     * Spuštění nebo obnovení existující relaci.
     */
    session_start();

    /**
     * Projíždění celý HTML a nalezení všechny divy s třídou "produkt-popis".
     */
    $html = file_get_contents('obleceni.php');
    $dom = new DOMDocument();
    @$dom -> loadHTML($html);
    
    /**
     * Sebrání všechny ID těchto divů a uložení je do pole.
     * Uložení ID do proměnné $idHtml.
     */
    $idHtml = [];
    $divs = $dom -> getElementsByTagName('div');
    foreach ($divs as $div) {
        if ($div -> getAttribute('class') === 'produkt-popis') {
            $idHtml[] = $div -> getAttribute('id');
        }
    }

    /**
     * Načtení soubor a dekódovat jej.
     * Uložení data do proměnné $json.
     */
    $data = file_get_contents('../../data-users-products/obleceni-data/obleceni.json');
    $json = json_decode($data, true);

    /**
     * Načtení data ze souboru users.json a dekódování je.
     * Uložení je do proměnné $userJson.
     */
    $usersData = file_get_contents('../../data-users-products/users.json');
    $usersJson = json_decode($usersData, true);

    /**
     * Extrahování všechna productId z json a ukládání je do pole.
     * Uložení ID do proměnné $idJson.
     */
    $idJson = [];
    foreach ($json as $item) {
        $idJson[] = $item['productId'];
    }

    /**
     * Porovnávání obsah pole $idHtml a $idJson, hledání chybějící hodnoty.
     * Uložení chybějící hodnoty do pole $missingIds.
     */
    $missingIds = [];
    foreach ($idJson as $jsonId) {
        $found = false;
    
        foreach ($idHtml as $htmlId) {
            if ($jsonId === $htmlId) {
                $found = true;
                break;
            }
        }
    
        if (!$found) {
            $missingIds[] = $jsonId;
        }
    }

    $newHtmlContent = "";

    /**
     * Načtení productName, productPrice atd. u nově vloženého ID z json.
     * Procházení položky v poli $missingIds.
     */
    foreach ($missingIds as $newInsertId) {
        foreach ($json as $item) {
            if ($item['productId'] === $newInsertId) {
                $productPrice = $item['productPrice'];
                $productName = $item['productName'];
                $username = $item["username"];
                $productImage = $item["productImage"];
                $productPage = $item["productPage"];
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Oblečení</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/produkty.css">
    <link rel="stylesheet" href="../css/style_responsive.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Space%20Grotesk">
</head>
<body>
    
    <div class="mobile-menu-btn">
        <img src="../images/nav/burger.png" alt="mobile-menu-btn">
    </div>

    <img src="../images/nav/top.png" alt="button top" id="myBtn" title="Go to top">

    <header class="header-main">

        <nav>
            <a href="../index.php" class="logo">
                    <img src="../images/nav/logo.png" alt="website logo">
            </a>
            <ul>
                <li><a href="obleceni.php">Oblečení</a></li>
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
            <a href="../upload.php" id="upload"><img src="../images/nav/upload.png" alt="upload"></a>
            <a href="#" class="ins"><img src="../images/nav/instagram.png" alt="instagram link"></a>
            <a href="#" class="fb"><img src="../images/nav/facebook.png" alt="facebook link"></a>
            <?php
                if (isset($_SESSION['user'])) {
                    // Uživatel je přihlášen, zobrazení odkaz na user-page.php
                    echo '<a href="../user-page.php"><img src="../images/nav/user.png" alt="user" id="user"></a>';
                } else {
                    // Uživatel není přihlášen, zobrazení odkazy na přihlášení a registraci
                    echo '<a href="../form/login-form.php"><img src="../images/nav/user.png" alt="user" id="user"></a>';
                }
            ?>
        </div>

    </header>

    <div class="container">

        <?php 

            $currentPage = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
            $itemsPerPage = 12;
            $totalItems = count($json);
            $totalPages = ceil($totalItems / $itemsPerPage);

            $start = ($currentPage - 1) * $itemsPerPage;
            $end = $start + $itemsPerPage;
            $filteredData = array_slice($json, $start, $itemsPerPage);

            foreach ($filteredData as $item) {

                $gender = "";
                foreach ($usersJson as $user) {
                    if($user['username'] === $item["username"]) {
                        $gender = $user['gender'];
                        break;
                    }
                }

                echo '<div class="produkt-container">
                        <div class="user-update">
                            <img src="../images/nav/user-' . $gender . '.png" alt="img user ' . $gender . '">
                            <p>' . $item['username'] . '</p>
                        </div>
                        <div class="produkt-img">
                            <img src=".' . $item['productImage'] . '" alt="' . $item['productName'] . '" class="produkt">
                        </div>
                        <div class="produkt-popis" id="' . $item['productId'] . '">
                            <a href=".' . $item['productPage'] . '?productId=' . $item['productId'] . '"><p>' . $item['productName'] . '</p></a>
                            <img src="../images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                            <img src="../images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                            <p>' . $item['productPrice'] . '</p>
                        </div>
                    </div>';
            }
            
        ?>

    </div>

    <div class='page-container'>
            <?php
                for ($page = 1; $page <= $totalPages; $page++) {
                    echo "<span class='page'><a href='obleceni.php?page=$page'>$page</a></span>";
                }
            ?>
    </div>


<script src="../js/mobile-nav.js"></script>
<script src="../js/heart.js"></script>
<script src="../js/button-top.js"></script>

</body>
</html>