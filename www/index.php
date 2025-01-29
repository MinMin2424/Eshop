<?php
    session_start();

    // Seznam souborů k načtení.
    $files = [
        "obleceni.json",
        "obuv.json",
        "tasky-a-doplnky.json",
        "bydleni.json",
        "deti.json",
        "zabava.json",
        "mazlicci.json"
    ];

    $products = [];

    // Načtení dat z json souborů.
    foreach ($files as $file) {
        $category = pathinfo($file, PATHINFO_FILENAME);
        $content = file_get_contents("../data-users-products/$category-data/$file");
        $products[$category] = json_decode($content, true);
    }

    // Načtení dat o uživatelích.
    $usersContent = file_get_contents("../data-users-products/users.json");
    $users = json_decode($usersContent, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Nákup a prodej nepoužitých věcí</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_responsive.css">
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
            <!--<a href="./form/login-form.php"><img src="images/nav/user.png" alt="user" id="user"></a>-->
            <?php
                if (isset($_SESSION['user'])) {
                    // Uživatel je přihlášen, zobrazíme odkaz na user-page.php
                    echo '<a href="./user-page.php"><img src="images/nav/user.png" alt="user" id="user"></a>';
                } else {
                    // Uživatel není přihlášen, zobrazíme odkazy na přihlášení a registraci
                    echo '<a href="./form/login-form.php"><img src="images/nav/user.png" alt="user" id="user"></a>';
                }
            ?>
        </div>

    </header>

    <div class="main-container">
        
        <div>
            <img src="images/main-container/shopping.png" alt="online shopping">
        </div>
        <div class="main-container-div">
            <p>Nejsi si jisti, kam umístit své nepoužité věci a zároveň si z nich něco vydělat?</p>
            <p>Tady můžeš snadno prodat nebo nakupovat za výhodné ceny.</p>
        </div>

    </div>

    <div class="zbozi">

        <section class="obleceni">

                <a href="./obleceni/obleceni.php"><h2>OBLEČENÍ</h2></a>

                <?php
                    /**
                     * Zobrazuje produkty určité kategorie na stránce.
                     * @param array $products Pole produktů určité kategorie.
                     * @param array $users Pole uživatelů.
                     * @param int $counter Počítadlo pro sledování počtu zobrazených produktů.
                     */
                ?>
                <?php $counter = 0; ?>
                <?php foreach ($products["obleceni"] as $product): ?>
                    <?php
                        $productId = $product['productId'];
                        $productName = $product['productName'];
                        $productImage = $product['productImage'];
                        $productPage = $product['productPage'];
                        $productPrice = $product['productPrice'];

                        $gender = '';
                        foreach ($users as $user) {
                            if ($user['username'] === $product['username']) {
                                $gender = $user['gender'];
                                break;
                            }
                        }
                    ?>

                    <div class="products" id="<?php echo htmlspecialchars($productId); ?>">
                        <div class="user-update">
                            <img src="images/nav/user-<?php echo htmlspecialchars($gender); ?>.png" alt="img user <?php echo htmlspecialchars($gender); ?>">
                            <p><?php echo htmlspecialchars($product['username']); ?></p>
                        </div>
                        <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                        <a href="<?php echo htmlspecialchars($productPage) . '?productId=' . $product['productId']; ?>"><p><?php echo htmlspecialchars($productName); ?></p></a>
                        <img src="images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                        <img src="images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                        <p><?php echo htmlspecialchars($productPrice); ?></p>
                    </div>

                    <?php $counter++; ?>
                    <?php if ($counter === 5) break; ?>
                <?php endforeach; ?>
        
        </section>

        <section class="obuv">

                <a href="./obuv/obuv.php"><h2>OBUV</h2></a>

                <?php
                    /**
                     * Zobrazuje produkty určité kategorie na stránce.
                     * @param array $products Pole produktů určité kategorie.
                     * @param array $users Pole uživatelů.
                     * @param int $counter Počítadlo pro sledování počtu zobrazených produktů.
                     */
                ?>
                <?php $counter = 0; ?>
                <?php foreach ($products["obuv"] as $product): ?>
                    <?php
                        $productId = $product['productId'];
                        $productName = $product['productName'];
                        $productImage = $product['productImage'];
                        $productPage = $product['productPage'];
                        $productPrice = $product['productPrice'];

                        $gender = '';
                        foreach ($users as $user) {
                            if ($user['username'] === $product['username']) {
                                $gender = $user['gender'];
                                break;
                            }
                        }
                    ?>

                    <div class="products" id="<?php echo htmlspecialchars($productId); ?>">
                        <div class="user-update">
                            <img src="images/nav/user-<?php echo htmlspecialchars($gender); ?>.png" alt="img user <?php echo htmlspecialchars($gender); ?>">
                            <p><?php echo htmlspecialchars($product['username']); ?></p>
                        </div>
                        <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                        <a href="<?php echo htmlspecialchars($productPage) . '?productId=' . $product['productId']; ?>"><p><?php echo htmlspecialchars($productName); ?></p></a>
                        <img src="images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                        <img src="images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                        <p><?php echo htmlspecialchars($productPrice); ?></p>
                    </div>

                    <?php $counter++; ?>
                    <?php if ($counter === 5) break; ?>
                <?php endforeach; ?>

        </section>

        <section class="tasky-a-doplnky">

            <a href="./tasky-a-doplnky/tasky-a-doplnky.php"><h2>TAŠKY A DOPLŇKY</h2></a>

            <?php
                /**
                 * Zobrazuje produkty určité kategorie na stránce.
                 * @param array $products Pole produktů určité kategorie.
                 * @param array $users Pole uživatelů.
                 * @param int $counter Počítadlo pro sledování počtu zobrazených produktů.
                 */
            ?>
            <?php $counter = 0; ?>
            <?php foreach ($products["tasky-a-doplnky"] as $product): ?>
                <?php
                    $productId = $product['productId'];
                    $productName = $product['productName'];
                    $productImage = $product['productImage'];
                    $productPage = $product['productPage'];
                    $productPrice = $product['productPrice'];

                    $gender = '';
                    foreach ($users as $user) {
                        if ($user['username'] === $product['username']) {
                            $gender = $user['gender'];
                            break;
                        }
                    }
                ?>

                <div class="products" id="<?php echo htmlspecialchars($productId); ?>">
                    <div class="user-update">
                        <img src="images/nav/user-<?php echo htmlspecialchars($gender); ?>.png" alt="img user <?php echo htmlspecialchars($gender); ?>">
                        <p><?php echo htmlspecialchars($product['username']); ?></p>
                    </div>
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                    <a href="<?php echo htmlspecialchars($productPage) . '?productId=' . $product['productId']; ?>"><p><?php echo htmlspecialchars($productName); ?></p></a>
                    <img src="images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                    <img src="images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                    <p><?php echo htmlspecialchars($productPrice); ?></p>
                </div>

                <?php $counter++; ?>
                <?php if ($counter === 5) break; ?>
            <?php endforeach; ?>

        </section>

        <section class="bydleni">

            <a href="./bydleni/bydleni.php"><h2>BYDLENÍ</h2></a>

            <?php
                /**
                 * Zobrazuje produkty určité kategorie na stránce.
                 * @param array $products Pole produktů určité kategorie.
                 * @param array $users Pole uživatelů.
                 * @param int $counter Počítadlo pro sledování počtu zobrazených produktů.
                 */
            ?>
            <?php $counter = 0; ?>
            <?php foreach ($products["bydleni"] as $product): ?>
                <?php
                    $productId = $product['productId'];
                    $productName = $product['productName'];
                    $productImage = $product['productImage'];
                    $productPage = $product['productPage'];
                    $productPrice = $product['productPrice'];

                    $gender = '';
                    foreach ($users as $user) {
                        if ($user['username'] === $product['username']) {
                            $gender = $user['gender'];
                            break;
                        }
                    }
                ?>

                <div class="products" id="<?php echo htmlspecialchars($productId); ?>">
                    <div class="user-update">
                        <img src="images/nav/user-<?php echo htmlspecialchars($gender); ?>.png" alt="img user <?php echo htmlspecialchars($gender); ?>">
                        <p><?php echo htmlspecialchars($product['username']); ?></p>
                    </div>
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                    <a href="<?php echo htmlspecialchars($productPage) . '?productId=' . $product['productId']; ?>"><p><?php echo htmlspecialchars($productName); ?></p></a>
                    <img src="images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                    <img src="images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                    <p><?php echo htmlspecialchars($productPrice); ?></p>
                </div>

                <?php $counter++; ?>
                <?php if ($counter === 5) break; ?>
            <?php endforeach; ?>

        </section>

        <section class="deti">

            <a href="./deti/deti.php"><h2>DĚTI</h2></a>

            <?php
                /**
                 * Zobrazuje produkty určité kategorie na stránce.
                 * @param array $products Pole produktů určité kategorie.
                 * @param array $users Pole uživatelů.
                 * @param int $counter Počítadlo pro sledování počtu zobrazených produktů.
                 */
            ?>
            <?php $counter = 0; ?>
            <?php foreach ($products["deti"] as $product): ?>
                <?php
                    $productId = $product['productId'];
                    $productName = $product['productName'];
                    $productImage = $product['productImage'];
                    $productPage = $product['productPage'];
                    $productPrice = $product['productPrice'];

                    $gender = '';
                    foreach ($users as $user) {
                        if ($user['username'] === $product['username']) {
                            $gender = $user['gender'];
                            break;
                        }
                    }
                ?>

                <div class="products" id="<?php echo htmlspecialchars($productId); ?>">
                    <div class="user-update">
                        <img src="images/nav/user-<?php echo htmlspecialchars($gender); ?>.png" alt="img user <?php echo htmlspecialchars($gender); ?>">
                        <p><?php echo htmlspecialchars($product['username']); ?></p>
                    </div>
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                    <a href="<?php echo htmlspecialchars($productPage) . '?productId=' . $product['productId']; ?>"><p><?php echo htmlspecialchars($productName); ?></p></a>
                    <img src="images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                    <img src="images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                    <p><?php echo htmlspecialchars($productPrice); ?></p>
                </div>

                <?php $counter++; ?>
                <?php if ($counter === 5) break; ?>
            <?php endforeach; ?>

        </section>

        <section class="zabava">

            <a href="./zabava/zabava.php"><h2>ZÁBAVA</h2></a>

            <?php
                /**
                 * Zobrazuje produkty určité kategorie na stránce.
                 * @param array $products Pole produktů určité kategorie.
                 * @param array $users Pole uživatelů.
                 * @param int $counter Počítadlo pro sledování počtu zobrazených produktů.
                 */
            ?>
            <?php $counter = 0; ?>
            <?php foreach ($products["zabava"] as $product): ?>
                <?php
                    $productId = $product['productId'];
                    $productName = $product['productName'];
                    $productImage = $product['productImage'];
                    $productPage = $product['productPage'];
                    $productPrice = $product['productPrice'];

                    $gender = '';
                    foreach ($users as $user) {
                        if ($user['username'] === $product['username']) {
                            $gender = $user['gender'];
                            break;
                        }
                    }
                ?>

                <div class="products" id="<?php echo htmlspecialchars($productId); ?>">
                    <div class="user-update">
                        <img src="images/nav/user-<?php echo htmlspecialchars($gender); ?>.png" alt="img user <?php echo htmlspecialchars($gender); ?>">
                        <p><?php echo htmlspecialchars($product['username']); ?></p>
                    </div>
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                    <a href="<?php echo htmlspecialchars($productPage) . '?productId=' . $product['productId']; ?>"><p><?php echo htmlspecialchars($productName); ?></p></a>
                    <img src="images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                    <img src="images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                    <p><?php echo htmlspecialchars($productPrice); ?></p>
                </div>

                <?php $counter++; ?>
                <?php if ($counter === 5) break; ?>
            <?php endforeach; ?>

        </section>

        <section class="mazlicci">

            <a href="./mazlicci/mazlicci.php"><h2>MAZLÍČCI</h2></a>

            <?php
                /**
                 * Zobrazuje produkty určité kategorie na stránce.
                 * @param array $products Pole produktů určité kategorie.
                 * @param array $users Pole uživatelů.
                 * @param int $counter Počítadlo pro sledování počtu zobrazených produktů.
                 */
            ?>
            <?php $counter = 0; ?>
            <?php foreach ($products["mazlicci"] as $product): ?>
                <?php
                    $productId = $product['productId'];
                    $productName = $product['productName'];
                    $productImage = $product['productImage'];
                    $productPage = $product['productPage'];
                    $productPrice = $product['productPrice'];

                    $gender = '';
                    foreach ($users as $user) {
                        if ($user['username'] === $product['username']) {
                            $gender = $user['gender'];
                            break;
                        }
                    }
                ?>

                <div class="products" id="<?php echo htmlspecialchars($productId); ?>">
                    <div class="user-update">
                        <img src="images/nav/user-<?php echo htmlspecialchars($gender); ?>.png" alt="img user <?php echo htmlspecialchars($gender); ?>">
                        <p><?php echo htmlspecialchars($product['username']); ?></p>
                    </div>
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                    <a href="<?php echo htmlspecialchars($productPage) . '?productId=' . $product['productId']; ?>"><p><?php echo htmlspecialchars($productName); ?></p></a>
                    <img src="images/main-container/heart-before.png" alt="heart before click" class="heart-before">
                    <img src="images/main-container/heart-after.png" alt="heart after click" class="heart-after">
                    <p><?php echo htmlspecialchars($productPrice); ?></p>
                </div>

                <?php $counter++; ?>
                <?php if ($counter === 5) break; ?>
            <?php endforeach; ?>

        </section>

    </div>

    <footer>

        <div class="logo-footer">
            <img src="images/nav/logo.png" alt="logo">
        </div>

        <div class="produkty-footer">
            <h4>PRODUKTY</h4>
            <p><a href="./obleceni/obleceni.php">Oblečení</a></p>
            <p><a href="./obuv/obuv.php">Obuv</a></p>
            <p><a href="./tasky-a-doplnky/tasky-a-doplnky.php">Tašky a doplňky</a></p>
            <p><a href="./bydleni/bydleni.php">Bydlení</a></p>
            <p><a href="./deti/deti.php">Děti</a></p>
            <p><a href="./zabava/zabava.php">Zábava</a></p>
            <p><a href="./mazlicci/mazlicci.php">Mazlíčci</a></p>
        </div>

        <div class="informace-footer">
            <h4>INFORMACE</h4>
            <p><a href="o-nas.php">O nás</a></p>
            <p><a href="nase-platforma.php">Naše platforma</a></p>
            <div class="sm-links-footer">
                <a href="#" class="ins-footer"><img src="./images/nav/instagram.png" alt="instagram link"></a>
                <a href="#" class="fb-footer"><img src="./images/nav/facebook.png" alt="facebook link"></a>
            </div>
        </div>

    </footer>

<script src="js/mobile-nav.js"></script>
<script src="js/heart.js"></script>
<script src="js/button-top.js"></script>

</body>
</html>