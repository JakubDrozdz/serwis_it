<?php
if (!isset($_SESSION)) {
    session_start();
}
$email=$_SESSION['user'];
$email= filter_var($email, FILTER_SANITIZE_EMAIL);
include('db.php');
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = mysqli_prepare($connection, "SELECT imie,nazwisko FROM klient WHERE email=?;");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
}
mysqli_stmt_bind_result($stmt, $imie_db,$nazwisko_db);
while(mysqli_stmt_fetch($stmt)){
    $imie=$imie_db;
    $nazwisko=$nazwisko_db;
}
mysqli_stmt_close($stmt);
?>