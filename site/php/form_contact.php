<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JTD COMP - Kontakt</title>
  <link rel="stylesheet" href="../css/style_form.css">
  <meta name="description"
    content="Serwis IT, specjalizujący się w naprawie, modernizacji, diagnostyce laptopów i komputerów sracjonarnych!">
  <meta name='keywords' content='serwis,laptopy,komputery,IT,naprawa IT'>
  <link rel="icon" href="../images/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&amp;subset=latin-ext" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>

<body>
  <h2>Formularz kontaktowy<br>JTD COMP</h2>
  <div id="wrapper">
    <table class="form">
      <form action="" method="post">
        <tr>
          <td>Imię:</td>
          <td><input type="text" name="imie" required></td>
        </tr>
        <tr>
          <td>Nazwisko:</td>
          <td><input type="text" name="nazwisko" required></td>
        </tr>
        <tr>
          <td>E-mail:</td>
          <td><input type="email" name="email" required></td>
        </tr>

        <tr>
          <td>Treść wiadomości:</td>
          <td><textarea name="wiadomosc" required></textarea></td>
        </tr>

        <tr>
          <td> </td>
          <td><input type="submit" name="submit" value="Wyślij wiadomość" id="submit"></td>
        </tr>
      </form>
    </table>
  </div>

  <?php 
    if(isset($_POST['submit'])){
      $adresat = "jtdcomp@gmail.com";
      $email = $_POST['email'];
      $nadawca= filter_var($email, FILTER_SANITIZE_EMAIL);
      if (filter_var($nadawca, FILTER_VALIDATE_EMAIL)) {
        $naglowek = "From:".$nadawca." \nContent-Type:".
        ' text/plain;charset="UTF-8"'.
        "\nContent-Transfer-Encoding: 8bit";
      }
      $imie = $_POST['imie'];
      $nazwisko = $_POST['nazwisko'];
      if(preg_match("/^[a-żA-Ż]+$/", $imie)==false||preg_match("/^[a-żA-Ż]+$/", $nazwisko)==false){
        die("<script>alert('Wprowadzono nieprawidłowe dane!');window.location.replace('http://127.0.0.1/serwis_it/site/php/form_contact.php');</script>");
      }
      $temat = "Formularz kontaktowy od $nadawca";
      $temat2 = "Potwierdzenie wysłania wiadomości do JTD COMP";
      //if(preg_match("/^[a-żA-Ż0-9 .,_-]+$/", $_POST['wiadomosc'])==false){
      //  die("<script>alert('Wprowadzono nieprawidłowe dane!');window.location.replace('http://127.0.0.1/Drożdż_Jakub_4i_aplikacja_serwisu/projekt_inf/php/form_contact.php');</script>");
      //}
      $wiadomosc = "Wiadomosć od ".$imie." ".$nazwisko." o treści:\n\n".$_POST['wiadomosc'];
      $wiadomosc2 = "Potwierdzenie wysłania wiadmości do ".$adresat."\n\nTreść wiadomości:\n".$_POST['wiadomosc'];
      $naglowek2 = "From:".$adresat." \nContent-Type:".
      ' text/plain;charset="UTF-8"'.
      "\nContent-Transfer-Encoding: 8bit";
      if(mail($adresat,$temat,$wiadomosc,$naglowek)){
        mail($nadawca,$temat2,$wiadomosc2,$naglowek2);
        echo "<script>
          alert('Udało się wysłać email');
        </script>";
      }
      else{
        echo "<script>
          alert('Nie udało się wysłać email');
        </script>";
      }
    }
  ?>
  <a href="index.php">
    <img src="../images/home.png" alt="strona_glowna" id="home">
  </a>
</body>

</html>