<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - O nás</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/o-nas.css">
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
            <a href="upload.php" id="upload"><img src="./images/nav/upload.png" alt="upload"></a>
            <a href="#" class="ins"><img src="images/nav/instagram.png" alt="instagram link"></a>
            <a href="#" class="fb"><img src="images/nav/facebook.png" alt="facebook link"></a>
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

    <section class="o-nas-container">
        <div>
            <h1>Vítejte v MANIE!</h1>
            <P>Zde věříme, že každý věc může najít svou druhou šanci a nového majitele.</P>
            <p>Naše platforma je založena na udržitelnosti, recyklaci a sdílení, což umožňuje našim zákazníkům ušetřit peníze, prostor a přírodní zdroje.</p>
        </div>
        <div>
            <h2>Co nabízíme</h2>
            <p>Naše obchodní prostředí je zároveň trhem a komunitním místem pro lidi, kteří chtějí prodat věci, které již nepotřebují, a pro ty, kteří hledají cenově dostupné a kvalitní alternativy.</p>
            <p>Nabízíme širokou škálu kategorií, včetně oblečení, obuvy, domácích spotřebičů, nábytku, hraček apod. </p>
            <p>Bez ohledu na to, zda hledáte módní kousky, praktické spotřebiče nebo sbírky, naše platforma vám poskytne rozmanité možnosti.</p>
        </div>
        <div>
            <h2>Jak to funguje</h2>
            <P>Prodejci mohou snadno vytvořit účet a inzerovat své nepoužité věci s podrobnými popisy, fotografiemi a cenami.</P>
            <p>Zákazníci mohou procházet nabídky, komunikovat s prodejci a získat věci, které potřebují za rozumné ceny.</p>
            <p>Věříme v transparentnost a spolehlivost, a proto nabízíme hodnocení uživatelů, což pomáhá zajistit spokojenost obou stran</p>
        </div>
        <div>
            <h2>Výhody pro zákazníky</h2>
            <p>Ušetřete peníze na věcech, které potřebují, a objevte unikátní poklady.</p>
            <p>Zmírněte svůj ekologický otisk tím, že dáte věcem druhou šanci místo jejich vyhození.</p> 
        </div>
        <div>
            <h2>Výhody pro prodejce</h2>
            <p>Uvolněte místo v domácnosti a získejte finanční prostředky za nepotřebné věci.</p>
            <p>Přispějte k udržitelnosti tím, že pomůžete prodloužit životnost věcem.</p>
        </div>
        <div>
            <h2>Garance kvality</h2>
            <p>Chceme, aby každý nákup a prodej byl spokojený, proto dbáme na to, aby všechny věci byly popsané co nejpřesněji a aby vše probíhalo hladce.</p>
        </div>
        <div>
            <h2>Kontakt</h2>
            <p>Pro další informace a registraci můžete připojit v kontaktu na sociálních sítích a buďte součastí naší udržitelné komunity.</p>
        </div>
    </section>

<script src="js/mobile-nav.js"></script>
<script src="js/button-top.js"></script>

</body>
</html>