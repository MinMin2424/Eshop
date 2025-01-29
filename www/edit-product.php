<?php

/**
 * Zpracování editace produktu a ukládání změn.
 */

 // Spuštění session pro ukládání dat o uživateli.
session_start();

// Pokud je v adrese získán parametr 'productID', ančte se produktové informace podle ID.
if (isset($_GET["productId"])) {
    $productId = $_GET["productId"];

    // Pole souborů kategorií, ve kterých se hledá produkt podle ID.
    $files = [
        "obleceni.json",
        "obuv.json",
        "tasky-a-doplnky.json",
        "bydleni.json",
        "deti.json",
        "mazlicci.json",
        "zabava.json"
    ];

    // Procházení soubory kategorií a hledání produkt podle ID.
    foreach ($files as $file) {
        $data = file_get_contents("../data-users-products/" . pathinfo($file, PATHINFO_FILENAME) . "-data/" . $file);
        $json = json_decode($data, true);

        foreach ($json as $item) {
            if ($item["productId"] === $productId) {
                $category = pathinfo($file, PATHINFO_FILENAME);
                break 2; // Ukončení oba cykly po nalezení kategorie produktu.
            }
        }
    }

    // Načtení produkty z vybrané kategorie.
    $categoryData = file_get_contents("../data-users-products/$category-data/$category.json");
    $categoryJson = json_decode($categoryData, true);

    // Nalezení konkrétní produkt prodle ID v určené kategorií.
    foreach ($categoryJson as $item) {
        if ($item["productId"] === $productId) {
            $productPrice = $item['productPrice'];
            $productName = $item['productName'];
            $productSize = $item["productSize"];
            $productDescription = $item["productDescription"];
            $productStatus = $item["productStatus"];
            $category = $item['category'];
            break;
        }
    }
}

// Zpracování POST po odeslání formuláře.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získání nových hodnot produktu z formuláře.

    $productId = $_POST['productId'];
    $category = $_POST['category'];
    $newProductName = $_POST['productName'];
    $newProductPrice = $_POST['productPrice'];
    $newProductSize = $_POST['productSize'];
    $newProductDescription = $_POST['productDescription'];
    $newProductStatus = $_POST['productStatus'];

    $data = file_get_contents("../data-users-products/$category-data/$category.json");
    $json = json_decode($data, true);

    // Aktualizace produktu v kolekci podle jeho ID.
    foreach ($json as &$item) {
        if ($item["productId"] === $productId) {
            // Přiřazení nových hodnot do kolekce produktů.
            $item['productName'] = $newProductName;
            $item['productPrice'] = $newProductPrice;
            $item['productSize'] = $newProductSize;
            $item['productDescription'] = $newProductDescription;
            $item['productStatus'] = $newProductStatus;
            break;
        }
    }

    // Uložení změn do souboru specifické kategorie.
    file_put_contents("../data-users-products/$category-data/$category.json", json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    
    // Přesměřování zpět na detail produktu po editaci.
    header("Location: ./$category/product-detail-$category.php?productId=$productId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Edit produktu</title>
    <link rel="stylesheet" href="./css/edit-product.css">
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
            Edit produktu
        </header>

        <form method="post" action="edit-product.php"  class="edit-product" id="edit-product">

            <input type="hidden" name="productId" value="<?php echo htmlspecialchars($productId); ?>">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">

            <div class="input-box">
                <label for="productName">Název produktu:</label>
                <input type="text" id="productName" name="productName" value="<?php echo isset($productName) ? htmlspecialchars($productName) : ''; ?>" required="required"><br><br>
            </div>

            <div class="input-box">
                <label for="productPrice">Cena:</label>
                <input type="text" id="productPrice" name="productPrice" value="<?php echo isset($productPrice) ? htmlspecialchars($productPrice) : ''; ?>" required="required"><br><br>
            </div>

            <div class="input-box">
                <label for="productSize">Velikost:</label>
                <input type="text" id="productSize" name="productSize" value="<?php echo isset($productSize) ? htmlspecialchars($productSize) : ''; ?>" required="required"><br><br>
            </div>

            <div class="input-box">
                <label for="productDescription">Popis:</label><br>
                <textarea id="productDescription" name="productDescription" rows="10" cols="80" required="required"><?php echo isset($productDescription) ? htmlspecialchars($productDescription) : ''; ?></textarea><br><br>
            </div>

            <div class="input-box">
                <label for="productStatus">Status: (Dostupný/Nedostupný)</label>
                <input type="text" id="productStatus" name="productStatus" value="<?php echo isset($productStatus) ? htmlspecialchars($productStatus) : ''; ?>" required="required"><br><br>
            </div>

            <input name="submit" type="submit" class="submit" value="Save">
        </form>

    </section>
    </form>
</body>
</html>

