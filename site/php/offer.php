<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTD COMP</title>
    <meta name="description"
        content="Serwis IT, specjalizujący się w naprawie, modernizacji, diagnostyce laptopów i komputerów sracjonarnych!">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_main.css">
    <meta name='keywords' content='serwis,laptopy,komputery,IT,naprawa IT'>
    <meta name='robots' content='index,follow'>
    <link rel="icon" href="../images/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&amp;subset=latin-ext" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script>
        $(document).ready(function () {
            $('a[href^="#"]').on('click', function (event) {

                var target = $($(this).attr('href'));

                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 30
                    }, 1000);
                }
            });
        });
    </script>
</head>

<body>
    <nav>
        <div id="name">
            <a href="index.php">
                <h2>Serwis komputerowy JTD COMP</h2>
            </a>
        </div>
        <?php if(empty($_SESSION['user'])) : ?>
        <div id="logged" onclick="login()">
            <h2>NIE JESTEŚ ZALOGOWANY</h2>
        </div>
        <?php else : ?>
        <div id="logged" onmouseover="logout_button()" onmouseout="welcome_button()" onclick="logout_button()">
            <h2>Witaj, <?=$_SESSION['user']?></h2>
        </div>
        <?php endif; ?>
        <button class="hamburger" onclick="hamburger()">
            <span class="hamburger__box">
                <span class="hamburger__inner"></span>
            </span>
        </button>
        <div id="links" class="links">
            <a href="index.php">O nas - strona główna</a>
            <a href="offer.php">Oferta</a>
            <a href="login_form.php">Panel klienta</a>
            <a href="add_service.php">Umów się na wizytę</a>
            <a href="show_services.php">Sprawdź umówione wizyty</a>
            <a href="#contact">Kontakt</a>
        </div>
    </nav>
    <header>
        <h1>Profesjonalnie, dokładnie, na czas!</h1>
    </header>
    <main>
        <section class="about" id="about">
            <h2>Czym się zajmujemy?</h2>
            <p>
                Nasz serwis specjalizuje się we wszelkich czynnościach serwisowych laptopów oraz komputerów
                stacjonarnych. W niektórych przypadkach możemy
                zająć się również telefonem komórkowym lub tabletem. Wykonujemy zarówno prace konserwacyne: czyszczenie,
                wymiana past termoprzewodzących, termopadów
                oraz zajmujemy się poważnymi usterkami takimi jak uszkodzenia układów na płycie głownej, bądź samej
                płyty głownej. Zajmujemy się:
            </p>
            <ul>
                <li>diagnozoą i naprawą uszkodzonych elementów,</li>
                <li>wymianą elementów na nowe,</li>
                <li>ponownym programowaniem BIOSu,</li>
                <li>naprawą matrycy,</li>
                <li>konfiguracją systemu,</li>
                <li>czyszceniem zarówno systemu jak i samego urządzenia,</li>
                <li>i wieloma innymi nieczodzniennymi przypadkami.</li>
            </ul>
            <p>Dokonujemy też konfiguracji i składania komputerów stacjonarnych. Zapewniamy konkurencyjne ceny oraz
                najlepszą jakość wykonania usług.</p>
        </section>
        <section class="contact" id="contact">
            <h2>Skontaktuj się z nami</h2>
            <div class="socials">
                <div class="social clearfix"><a href="mailto:jtdcomp@gmail.com"><img src="../images/contact1.png"
                            alt="mail"><span>jtdcomp@gmail.com</span></a></div>
                <div class="social clearfix"><a href="tel:+48123123123"><img src="../images/contact2.png"
                            alt="telefon"><span>123123123</span></a></div>
                <div class="social clearfix"><a href="form_contact.php"><img src="../images/form.png"
                            alt="formularz"><span>Formularz kontaktowy</span></a></div>
            </div>
            <div style="text-align:center; margin-bottom:2%;">
                <h2>Godziny otwarcia</h2>
                <p style="font-size:3.5vh;">PN.-PT. 8:00-17:00<br> SOB. 10:00-17:00</p>
            </div>
            <div style="text-align:center; margin-bottom:2%;">
                <h2>Adres</h2>
                <p style="font-size:3.5vh;">Rzeszów, al. Powstańców Warszawy 123456</p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; Jakub Drożdż</p>
    </footer>


</body>
<script src="../script.js">
</script>
<script>
    function welcome_button() {
        var logged = document.getElementById("logged");
        logged.innerHTML = "<h2>Witaj, <?=$_SESSION['user']?></h2>";
    }
</script>

</html>