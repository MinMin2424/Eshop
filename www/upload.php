<?php

    session_start();

    /**
     * Zkontroluje, zda je uživatel přihlášený. Pokud ne, přesměruje ho na login.php.
     */
    if (!isset($_SESSION["user"])) {
        header("Location: ./form/login-form.php");
        exit();
    }

    /**
     * Funkce pro čtení JSON dat ze souboru.
     * @param string $filePath Cesta k souboru.
     * @return array Pole dat nebo prázdné pole, pokud soubor není platný JSON.
     */
    function readJsonData($filePath) {
        $currentData = file_get_contents($filePath);
        return json_decode($currentData, true) ?: []; // Pokud je soubor prázdný, vracíme prázdné pole
    }

    /**
     * Funkce pro získání nového ID pro produkt.
     * @param array $data Pole produktů.
     * @return string Nové ID pro produkt.
     */
    function getNewProductId($data) {
        $highestId = 0;

        foreach ($data as $product) {
            preg_match('/\d+/', $product['productId'], $matches);
            $productId = intval($matches[0] ?? 0);

            if ($productId > $highestId) {
                $highestId = $productId;
            }
        }

        return "d" . ($highestId + 1);
    }

    /**
     * Funkce pro získání uživatelské jméno.
     * @return string Uživatelské jméno nebo prázdný řetězec.
     */
    function getUsername() {
        if (isset($_SESSION["user"])) {
            $userData = $_SESSION["user"];
            return $userData["username"] ?? "";
        }
        return "";
    }

    /**
     * Funkce pro získání telefonní číslo uživatele.
     * @return string Telefonní číslo nebo prázdný řetězec.
     */
    function getUserTel() {
        if (isset($_SESSION["user"])) {
            $userData = $_SESSION["user"];
            return $userData["phone-number"] ?? "";
        }
        return "";
    }

    /**
     * Funkce pro získání email uživatele.
     * @return string Email nebo prázdný řetězec.
     */
    function getUserEmail() {
        if (isset($_SESSION["user"])) {
            $userData = $_SESSION["user"];
            return $userData["email"] ?? "";
        }
        return "";
    }

    /**
     * Zpracování odeslaného formuláře pro nahrání produktu.
     * @return void
     */
    $imageError = "";
    if (isset($_POST["submit"])) {

        // Zápis nového produktu do JSON
        $category = $_POST["kategorie"] ?? "";

        switch ($category) {
            case "obleceni":
                $file = "../data-users-products/obleceni-data/obleceni.json";
                break;
            case "obuv":
                $file = "../data-users-products/obuv-data/obuv.json";
                break;
            case "tasky-a-doplnky":
                $file = "../data-users-products/tasky-a-doplnky-data/tasky-a-doplnky.json";
                break;
            case "bydleni":
                $file = "../data-users-products/bydleni-data/bydleni.json";
                break;
            case "deti":
                $file = "../data-users-products/deti-data/deti.json";
                break;
            case "zabava":
                $file = "../data-users-products/zabava-data/zabava.json";
                break;
            case "mazlicci":
                $file = "../data-users-products/mazlicci-data/mazlicci.json";
                break;
            default:
                break;
        }

        $imageName = $_FILES['obrazky']['name'];
        $imageTmpName = $_FILES['obrazky']['tmp_name'];
        $imageSize = $_FILES['obrazky']['size'];
        $imageError = $_FILES['obrazky']['error'];
        $imageType = $_FILES['obrazky']['type'];

        // Získání přípony souboru (např. jpg, png)
        $imageExt = explode('.', $imageName);
        $imageActualExt = strtolower(end($imageExt));

        // Povolené formáty obrázků
	    $allowed = array('jpg', 'jpeg', 'png');

        if($imageError === 0) {

        // je to ok, zadna chyba nenastala

        } else {

        // handle the error
        $descriptions =	array(

            0=>"There is no error, the file uploaded with success", 

            1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini", 

            2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",

            3=>"The uploaded file was only partially uploaded",

            4=>"No file was uploaded",

            6=>"Missing a temporary folder" 

        );

        echo "Chyba: Obrázek je příliš velký!"; //.$descriptions[$imageError];
        exit();

        }

    }

    /**
     * Zpracování nahrání produktu do JSON a přesměrování.
     */
    if (isset($file)) {
        $data = readJsonData($file);

        $newProductName = isset($_POST["product-name"]) ? $_POST["product-name"] : "";
        $newProductPrice = isset($_POST["cena"]) ? $_POST["cena"] . " Kč" : "" ;
        $productDescription = isset($_POST["popis"]) ? $_POST["popis"] : "";

        $newUsername = getUsername();
        $newUserTel = getUserTel();
        $newUserEmail = getUserEmail();
        $newProductId = getNewProductId($data);
        $newProductPage = "./" . $category . "/product-detail-" . $category . ".php";

        // Zkontrolovat, jestli je formát obrázku povolen
        if (in_array($imageActualExt, $allowed)) {
            if ($imageError === 0) {
                    $imageDestination = './images/' . $category . '/' . $imageName; // Cílová cesta, kam se obrázek uloží
    
                    list($originalWidth, $originalHeight) = getimagesize($imageTmpName);
                    $newWidth = 210;
                    $newHeight = 315;
                    $newImage = imagescale(imagecreatefromstring(file_get_contents($imageTmpName)), $newWidth, $newHeight);
                    imagejpeg($newImage, $imageDestination);
                    
                    // Přesun obrázku do cílové složky na serveru
                    //move_uploaded_file($imageTmpName, $imageDestination);
                    
                    $newProduct = array(
                        'productId' => $newProductId,
                        'productName' => $newProductName,
                        'username' => $newUsername,
                        'category' => $_POST["kategorie"] ?? "",
                        'productPrice' => $newProductPrice,
                        'productSize' => $_POST["velikost"] ?? "",
                        'productDescription' => $productDescription,
                        'userTel' => $newUserTel,
                        'userEmail' => $newUserEmail,
                        'productStatus' => "Dostupný",
                        'productImage' => $imageDestination,
                        'productPage' => $newProductPage
                    );

                    $data[] = $newProduct;
                    file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

                    header("Location: user-page.php");
                    exit();
                } else {
                    // Obrázek je příliš velký
                    echo "Obrázek je příliš velký!";
                }
        } else {
            // Nepovolený formát obrázku
            echo "Nepovolený formát obrázku!";
        }
    } else {
    // Kód pro jiné scénáře než odeslání formuláře
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Nahrát produktu k prodeji!</title>
    <link rel="stylesheet" href="./css/form-for-registrace.css">
    <link rel="stylesheet" href="./css/upload.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Space%20Grotesk">
</head>
<body>

    <header class="header-main-form">
        <nav>
            <a href="index.php" class="logo-form">
                <img src="./images/nav/logo.png" alt="website logo">
            </a>
        </nav>
    </header>

    <section class="container-form">

        <header>
            Nahrát produktu k prodeji
        </header>

        <form action="upload.php" method="post" enctype="multipart/form-data" class="form-registration" id="form-registration">

            <div class="input-box">
                <label for="product-name">Název produktu*:</label>
                <input type="text" id="product-name" name="product-name" placeholder="Napište sem název produktu" required="required"
                    value="<?php 
                            if (isset($_POST['product-name'])) {
                                echo htmlspecialchars($_POST['product-name']);
                                } 
                            ?>"
                >
            </div>

            <div class="input-box">
                <label for="kategorie">Kategorie*:</label><br>
                <select  class="select-box" name="kategorie" id="kategorie" required="required">
                    <option value="obleceni" <?php if (isset($_POST['kategorie']) && $_POST['kategorie'] === 'obleceni') echo 'selected="selected"'; ?> >Oblečení</option>
                    <option value="obuv"  <?php if (isset($_POST['kategorie']) && $_POST['kategorie'] === 'obuv') echo 'selected="selected"'; ?> >Obuv</option>
                    <option value="tasky-a-doplnky"  <?php if (isset($_POST['kategorie']) && $_POST['kategorie'] === 'tasky-a-doplnky') echo 'selected="selected"'; ?> >Tašky a doplňky</option>
                    <option value="bydleni"  <?php if (isset($_POST['kategorie']) && $_POST['kategorie'] === 'bydleni') echo 'selected="selected"'; ?> >Bydlení</option>
                    <option value="deti"  <?php if (isset($_POST['kategorie']) && $_POST['kategorie'] === 'deti') echo 'selected="selected"'; ?> >Děti</option>
                    <option value="zabava"  <?php if (isset($_POST['kategorie']) && $_POST['kategorie'] === 'zabava') echo 'selected="selected"'; ?> >Zábava</option>
                    <option value="mazlicci"  <?php if (isset($_POST['kategorie']) && $_POST['kategorie'] === 'mazlicci') echo 'selected="selected"'; ?> >Mazlíčci</option>
                </select>
            </div>

            <div class="input-file">
                <label for="obrazky">Obrázky*:
                    <div id="drop-area">
                        <input type="file" id="obrazky" name="obrazky" accept="image/*" hidden="hidden" required="required">
                        <div id="img-view">
                            <img src="./images/upload/upload.png" alt="upload image">
                            <p>Přetáhněte nebo klikněte sem<br>pro nahrání obrázku</p>
                            <span>Nahrajte jakékoliv obrázky z plochy</span>
                        </div>
                    </div>
                </label>
            </div>

            <div class="input-box">
                <label for="cena">Cena*:</label>
                <input type="number" id="cena" name="cena" min="0" required="required"
                    value="<?php 
                            if (isset($_POST['cena'])) {
                                echo htmlspecialchars($_POST['cena']);
                                } 
                            ?>"
                    >
            </div>

            <div class="input-box">
                <label for="velikost">Velikost*:</label>
                <select  class="select-box" name="velikost" id="velikost" required="required">
                    <option value="XS" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === 'XS') echo 'selected="selected"'; ?> >XS</option>
                    <option value="S" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === 'S') echo 'selected="selected"'; ?> >S</option>
                    <option value="M" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === 'M') echo 'selected="selected"'; ?> >M</option>
                    <option value="L" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === 'L') echo 'selected="selected"'; ?> >L</option>
                    <option value="XL" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === 'XL') echo 'selected="selected"'; ?> >XL</option>
                    <option value="XXL" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === 'XXL') echo 'selected="selected"'; ?> >XXL</option>
                    <option value="36" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '36') echo 'selected="selected"'; ?> >36</option>
                    <option value="37" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '37') echo 'selected="selected"'; ?> >37</option>
                    <option value="38" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '38') echo 'selected="selected"'; ?> >38</option>
                    <option value="39" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '39') echo 'selected="selected"'; ?> >39</option>
                    <option value="40" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '40') echo 'selected="selected"'; ?> >40</option>
                    <option value="41" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '41') echo 'selected="selected"'; ?> >41</option>
                    <option value="42" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '42') echo 'selected="selected"'; ?> >42</option>
                    <option value="43" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '43') echo 'selected="selected"'; ?> >43</option>
                    <option value="44" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '44') echo 'selected="selected"'; ?> >44</option>
                    <option value="45" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '45') echo 'selected="selected"'; ?> >45</option>
                    <option value="46" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '46') echo 'selected="selected"'; ?> >46</option>
                    <option value="47" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === '47') echo 'selected="selected"'; ?> >47</option>
                    <option value="onesize" <?php if (isset($_POST['velikost']) && $_POST['velikost'] === 'onesize') echo 'selected="selected"'; ?> >onesize</option>
                    <option value="none" <?php if ((!isset($_POST['velikost'])) || (isset($_POST['velikost']) && $_POST['velikost'] === 'none')) echo 'selected="selected"'; ?> >none</option>
                </select>
            </div>

            <div class="input-box">
                <label for="popis">Popis*:</label><br>
                <textarea name="popis" id="popis" placeholder="Napište sem popis produktu" required="required"
                    value="<?php 
                            if (isset($_POST['popis'])) {
                                echo htmlspecialchars($_POST['popis']);
                                } 
                            ?>"
                ></textarea>
            </div>

            <button type="submit" id="submit" name="submit">Upload</button>

            <?php
                if(isset($_POST["submit"]) && $imageError !== 0) {
                    echo "Nastala chyba při nahrávání obrázku. Obrázek nebyl nahrán nebo je příliš velký.";
                }
            ?>

        </form>

    </section>
    
</body>

<script src="./js/upload.js"></script>

</html>
