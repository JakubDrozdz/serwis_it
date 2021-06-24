<?php
if (!isset($_SESSION)) {
    session_start();
}
if(isset($_POST['submit'])){
    include('db.php');
    $fname=$_POST['fname'];
    $sname=$_POST['sname'];
    if(preg_match("/^[a-żA-Ż]+$/", $fname)==false||preg_match("/^[a-żA-Ż]+$/", $sname)==false){
        die("<script>alert('Wprowadzono nieprawidłowe dane!');window.location.replace('http://127.0.0.1/serwis_it/site/php/add_service.php');</script>");
    }
    $email=$_POST['email'];
    $email= filter_var($email, FILTER_SANITIZE_EMAIL);
    @$pass=$_POST['pass'];
    $password=password_hash($pass,PASSWORD_DEFAULT);
    $czy_dodane=false;
    if($czy_dodane==false){
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
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = mysqli_prepare($connection, "INSERT INTO uzytkownicy(`email`,`haslo`,`klient_klient_id`) VALUES(?,?,?);");
            mysqli_stmt_bind_param($stmt, 'ssi', $email, $password, $id);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        $czy_dodane=true;
    }
    if($czy_dodane==true){
        $temat = "Potwierdzenie rejestracji w JTD COMP";
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = mysqli_prepare($connection, "SELECT klient_id FROM klient WHERE email LIKE ?;");
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_bind_result($stmt, $id_klient);
        while(mysqli_stmt_fetch($stmt)) $id=$id_klient; 
        mysqli_stmt_close($stmt);
        $wiadomosc="Założyłeś konto użytkownika, od teraz możesz sprawdzać historię swoich wizyt. Twój unikatowy identyfikator klienta to: $id";
        $naglowek = "From: jtdcomp@gmail.com \nContent-Type:".
        ' text/plain;charset="UTF-8"'.
        "\nContent-Transfer-Encoding: 8bit";
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            mail($email,$temat,$wiadomosc,$naglowek);
            $_SESSION['user']=$email;
            echo "<script>
                    var x=confirm('Wysłano potwierdzenie na twój adres email. Chcesz dodać wizytę?');
                    if(x) window.location.replace('http://127.0.0.1/serwis_it/site/php/add_service.php')
                    else window.location.replace('http://127.0.0.1/serwis_it/site/php/index.php');
                </script>";
        }
        
    }
    
    mysqli_close($connection);
}
?>