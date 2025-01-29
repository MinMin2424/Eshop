<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manie - Naše platforma</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/style_responsive.css">
    <link rel="stylesheet" href="./css/o-nas.css">
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
                <li><a href="./deti/deti.php">Zábava</a></li>
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
        <div class="nase-platforma">
            <h2>Co je Manie?</h2>
            <p>Manie je online zprostředkovatelskou platformou, která uživatelům umožňuje prodávat a kupovat určité předměty.</p>
            <p>Společnost Manie neprodává ani nekupuje žádné předměty zobrazené na webových stránkách a není zapojena do žádných transakcí mezi uživateli.</p>
        </div>

        <div class="nase-platforma">
            <h2>Kdo může používat naše webové stránky?</h2>
            <p>Manie si zakládá na poskytování uživatelům přátelského a bezpečného prostředí. </p>
            <p>Abychom to zajistili, platí určitá pravidla ohledně toho, co můžete prodávat na naší platformě. </p>
            <p>Před vystavením předmětu na prodej byste měli zkontrolovat, zda splňuje naše Pravidla katalogu, která stanovují, co je možné a co není možné prodávat na našich stránkách.</p>
        </div>

        <div class="nase-platforma">
            <h2>Pravidla katalogu Manie</h2>
            <p>Naším cílem je poskytovat na Manii přátelské a bezpečné prostředí pro obchodování s použitými věcmi.</p>
            <p>Proto žádáme naše uživatele, aby dodržovali následující Pravidla katalogu při nahrávání předmětů.</p>
            <div>
                <h3>Povolené předměty</h3>
                <ul>
                    <li>dámské, pánské a dětské oblečení, obuv a doplňky</li>
                    <li>dětské hračky, nábytek a vybavení k péči o děti</li>
                    <li>novou dekorativní a pečující kosmetiku a zkrášlovací pomůcky</li>
                    <li>doplňky k elektronice, tedy například sluchátka, chytré hodinky, pouzdra telefony a podobně</li>
                    <li>domácí potřeby jako textil, nádobí a bytové doplňky</li>
                    <li>zboží pro zábavu a volný čas: sem spadají počítačové hry, konzole příslušenství, knihy, deskové a společenské hry, hlavolamy, puzzle, hudba a video</li>
                    <li>domácí mazlíčky</li>
                    <li>vybavení pro ochovatele, například zvířecí oblečení, doplňky, pelíšky a deky, vybavení na převoz, hračky</li>
                </ul>
                <p>Vyhazujeme si právo přehodnotit, které předměty se na Manii prodávat smějí a které ne.</p>
                <p>Pokud zjistíme, že určité předměty porušují naše podmínky, můžeme je odstranit, přestože nejsou vyjmenované níže.</p>
            </div>
            <div>
                <h3>Zakázené předměty</h3>
                <p>Na Manii nesmíš prodávat (upozorňujeme, že tento seznam není vyčerpávající a měl by být chápán pouze jako vodítko):</p>
                <ul>
                    <li>Protiprávní předměty: Jakékoliv zboží nebo materiál, které je podle platných zákonů, pravidel nebo regulace zakázáno vlastnit, obchodovat s nimi, prodávat je, zasílat je, mít je v držení nebo je vytvářet.</li>
                    <li>Zakázané předměty: Předměty, které nespadají do oblečení, netýkají se módy, vzhledu, doplňků, dětí nebo vybavení domácnosti, případně zkrátka neodpovídají vizi, kterou Manie má.</li>
                    <li>Nebezpečné předměty: Předměty, které nevyhovují hygienickým standardům nebo by mohly představovat hrozbu pro zdraví či bezpečnost.</li>
                </ul>
            </div>
        </div>

        <div class="nase-platforma">
            <h2>Jak může kupující za předmět koupit a zaplatit?</h2>
            <p>Manie funguje jako prostředník a poskytuje platformu pro prodávající a kupující.</p>
            <p>Když se kupující zajímají o nabízené produkty, mají možnost kontaktovat přímo prodejce prostřednictvím uvedených telefonních čísel nebo e-mailových adres u popisu produktu.</p>
            <p>Manie není zapojena do těchto transakcí a neslouží jako prostředník při provádění plateb či organizaci dopravy.</p>
        </div>    
    </section>
    
<script src="js/mobile-nav.js"></script>
<script src="js/button-top.js"></script>

</body>
</html>