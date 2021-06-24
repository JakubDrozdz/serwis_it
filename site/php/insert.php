<?php
if(isset($_POST['submit'])){
    include('db.php');
    $desc=$_POST['desc'];
    if(preg_match("/^[a-żA-Ż0-9 .,_-]+$/", $desc)==false){
        die("<script>alert('Wprowadzono nieprawidłowe dane!');window.location.replace('http://127.0.0.1/serwis_it/site/php/add_service.php');</script>");
    }
    $date=$_POST['date'];
    $fname=$_POST['fname'];
    $sname=$_POST['sname'];
    if(preg_match("/^[a-żA-Ż]+$/", $fname)==false||preg_match("/^[a-żA-Ż]+$/", $sname)==false){
        die("<script>alert('Wprowadzono nieprawidłowe dane!');window.location.replace('http://127.0.0.1/serwis_it/site/php/add_service.php');</script>");
    }
    $email=$_POST['email'];
    $email= filter_var($email, FILTER_SANITIZE_EMAIL);
    @$pass=$_POST['pass'];
    $password=password_hash($pass,PASSWORD_DEFAULT);
    $stan=0;
    $czy_dodane=false;
    $nowy_uzytkownik=false;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = mysqli_prepare($connection, "SELECT email,klient_id FROM klient;");
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_bind_result($stmt,$email_,$id_klient);
    while(mysqli_stmt_fetch($stmt)){
        if(@$email_db==$email){
            $id=$id_klient;
            $stmt1 = mysqli_prepare($connection, "INSERT INTO zlecenia(`opis`,`data_wizyty`,`klient_klient_id`) VALUES(?,?,?);");
            mysqli_stmt_bind_param($stmt1, 'sss', $desc, $date, $id);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);
            $stan=1;
            $czy_dodane=true;
        }
    } 
    mysqli_stmt_close($stmt);
    if($stan==0){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = mysqli_prepare($connection, "INSERT INTO klient(`imie`,`nazwisko`,`email`) VALUES(?,?,?);");
            mysqli_stmt_bind_param($stmt, 'sss', $fname, $sname, $email);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = mysqli_prepare($connection, "SELECT klient_id FROM klient WHERE email LIKE ?;");
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_bind_result($stmt, $id_klient);
        while(mysqli_stmt_fetch($stmt)) $id=$id_klient; 
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($connection, "INSERT INTO zlecenia(`opis`,`data_wizyty`,`klient_klient_id`) VALUES(?,?,?);");
        mysqli_stmt_bind_param($stmt, 'sss', $desc, $date, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if(strlen($pass)>0){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $stmt = mysqli_prepare($connection, "INSERT INTO uzytkownicy(`email`,`haslo`,`klient_klient_id`) VALUES(?,?,?);");
                mysqli_stmt_bind_param($stmt, 'sss', $email,$password,$id);
            }
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $nowy_uzytkownik=true;
        }
        $czy_dodane=true;
    }
    
    if($czy_dodane==true){
        $temat = "Potwierdzenie umówienia na wizytę w JTD COMP";
        $wiadomosc = "Potwierdzenie wizyty w dniu $date.\nOpis problemu: $desc.\n";
        if($nowy_uzytkownik==true){
            $wiadomosc.="Założyłeś również kont o użytkownika, od teraz możesz sprawdzać historię swoich wizyt. Twój unikatowy identufikator klienta to: $id";
        }
        $naglowek = "Wiadomość od:jtdcomp@gmail.com\nContent-Type:".'text/plain;charset="UTF-8"'."\nContent-Transfer-Encoding: 8bit";
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            mail($email,$temat,$wiadomosc,$naglowek);
            echo "<script>
                    var x=confirm('Wysłano potwierdzenie na twój adres email. Chcesz przejrzeć swoje wizyty?');
                    if(x) window.location.replace('http://127.0.0.1/serwis_it/site/php/show_services.php')
                    else window.location.replace('http://127.0.0.1/serwis_it/site/php/index.php');
                </script>";
        }
        
    }
    mysqli_close($connection);
}
?>