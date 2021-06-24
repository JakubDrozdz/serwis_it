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
    <link rel="stylesheet" href="../css/style_add.css">
    <link rel="stylesheet" href="../css/style_table.css">
    <meta name='keywords' content='serwis,laptopy,komputery,IT,naprawa IT'>
    <meta name='robots' content='index,follow'>
    <link rel="icon" href="../images/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&amp;subset=latin-ext" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <style>
        main .form {
            margin: 0;
            padding: 0;
            margin-bottom: 30px;
            width: 80%;
        }

        main .form #submit {
            font-size: 26px;
            width: 40%;
        }

        @media(max-width:812px) {
            main .form #submit {
                font-size: 22px;
                width: 45%;
            }
        }

        @media(max-width:568px) {
            main .form #submit {
                font-size: 20px;
                width: 65%;
            }
        }
    </style>
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
        <div id="logged" onmouseover="logout_button()" onmouseout="welcome_button()">
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
    <main>
        <div id="service">
            <?php if(empty($_SESSION['user'])) : ?>
            <h2 id="find">Sprawdź swoje umówione wizyty:</h2>
            <div>
                <form action="" method="post">
                    <div class="button show">Podaj email, na który zostało wysłane potwierdzenie umówienia na wizytę:
                        <br> <input type="email" name="email" id="show_email" required></div>
                    <div class="form">
                        <input type="submit" value="Wyszukaj zlecenia" name="submit" id="submit">
                    </div>
                </form>
                <?php
                if(isset($_POST['submit'])){
                    echo "<h3>Lista umówionych wizyt dla ".$_POST['email']."</h3>";
                    include('select.php');
                }
                ?>
            </div>
            <?php else : include('get_data.php') ?>
            <h2>Witaj, <?=$imie." ".$nazwisko?>. Oto twoje umówione wizyty w naszym serwisie</h2>
            <?php
                $_POST['email']=$_SESSION['user'];
                include('select.php');
            ?>
            <?php endif; ?>
        </div>
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
<script src="../script.js"></script>
<script>
    function welcome_button() {
        var logged = document.getElementById("logged");
        logged.innerHTML = "<h2>Witaj, <?=$_SESSION['user']?></h2>";
    }
</script>

</html>