<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
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
    <link rel="stylesheet" href="../css/style_form.css">
    <meta name='keywords' content='serwis,laptopy,komputery,IT,naprawa IT'>
    <meta name='robots' content='index,follow'>
    <link rel="icon" href="../images/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&amp;subset=latin-ext" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>

<body>
    <div class="form">
        <form action="" method="post">
            <div>
                Podaj email: <input type="email" name="login" id="login" required> <br>
            </div>
            <div>
                Podaj hasło: <input type="password" name="pass" id="pass" required> <br>
            </div>
            <div>
                <input type="submit" value="Zaloguj się" name="submit" id="submit">
            </div>
        </form>
    </div>
    <?php
if(isset($_POST['submit'])){
    include('db.php');
    $email=$_POST['login'];
    $email= filter_var($email, FILTER_SANITIZE_EMAIL);
    $pass=$_POST['pass'];
    if($email=="jtdcomp@gmail.com"){
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
                    header("Location: http://127.0.0.1/serwis_it/site/php/admin_logged.php");
                }
            }
            else echo "<script>alert('Nieprawidłowy login lub hasło!');</script>";
        }
        else echo "<script>alert('Nieprawidłowy login lub hasło!');</script>";
        mysqli_stmt_close($stmt);
    }
    else echo "<script>alert('Nieprawidłowy login lub hasło!');</script>";
    mysqli_close($connection);
}
?>
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