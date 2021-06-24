<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<?php
include('db.php');
$email=$_POST['login'];
$email= filter_var($email, FILTER_SANITIZE_EMAIL);
$pass=$_POST['pass'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = mysqli_prepare($connection, "SELECT haslo FROM uzytkownicy WHERE email LIKE ?;");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
}
mysqli_stmt_bind_result($stmt, $haslo_db);
mysqli_stmt_store_result($stmt);
$rows=mysqli_stmt_num_rows($stmt);
if($rows!=0){
    while(mysqli_stmt_fetch($stmt))$password=$haslo_db;
    $pass_verified=password_verify($pass,$password);
    if($pass_verified){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['user'] = htmlspecialchars($email);
        }
    }
    else $_SESSION['good'] = 1;
}
else $_SESSION['good'] = 1;
mysqli_stmt_close($stmt);
mysqli_close($connection);
header("Location: http://127.0.0.1/serwis_it/site/php/login_form.php");
exit();
?>