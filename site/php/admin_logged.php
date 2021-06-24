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
    <style>
        h2 {
            position: relative;
            font-size: 250%;
        }

        #logged {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }

        #logged h2 {
            font-size: 300%;
        }

        #wrapper {
            height: 85%;
            width: 70%;
        }

        #tab {
            width: 90%;
            font-size: 160%;
        }

        #tab_wrapper {
            height: 35%;
            overflow: auto;
        }

        #update {
            text-align: center;
            font-size: 150%;
        }

        #update input {
            font-size: 90%;
        }

        #update .button {
            margin: 2% 0;
            padding: 1.5%;
            width: 25%;
        }

        @media(max-width:1024px) {
            #tab {
                font-size: 110%;
            }

            #wrapper {
                width: 85%;
                height: 70%;
            }

            #logged h2 {
                font-size: 220%;
            }

            h2 {
                font-size: 180%;
            }

            #update {
                font-size: 120%;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php if($_SESSION['user']!="jtdcomp@gmail.com") : header("Location: http://127.0.0.1/serwis_it/site/php/admin.php");?>
        <?php else : ?>
        <div id="logged" onmouseover="logout_button()" onmouseout="welcome_button()" onclick="logout_button()">
            <h2>Witaj, jtdcomp@gmail.com</h2>
        </div>
        <h2>Oto wszystkie wizyty umówione w serwisie:</h2>
        <?php
    include('db.php');
    $stmt = mysqli_prepare($connection, "SELECT opis,data_wizyty,klient.email,czy_wykonane FROM zlecenia JOIN klient ON(zlecenia.klient_klient_id=klient.klient_id);");
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $desc_db,$date_db,$email_db,$is_done_db);
    echo "<div id='tab_wrapper'><table id='tab'>
            <tr id='first_row'>
                <th>Lp.</th>
                <th>Opis wizyty</th>
                <th>Data wizyty</th>
                <th>E-mail klienta</th>
                <th>Czy wykonane</th>
            </tr>";
    $i=1;
    while(mysqli_stmt_fetch($stmt)){
        $desc=$desc_db;
        $date=$date_db;
        $email=$email_db;
        $is_done=$is_done_db;
        if($is_done==1) $is_done="TAK";
        else $is_done="NIE";
        echo "<tr>";
        echo "<td>$i</td><td>$desc</td><td>$date</td><td>$email</td><td>$is_done</td>";
        echo "</tr>";
        $i++;
    }
    echo "</table></div>";
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    ?>
        <div id="update">
            <h3>Zaktualizuj status zlecenia</h3>
            <form action="" method="POST">
                ID zlecenia (lp.): <input type="number" name="id" id="id">
                <br>
                <input type="submit" value="Aktualizuj" name="submit" class="button">
            </form>
        </div>
        <?php
    if(isset($_POST['submit'])){
        $id=$_POST['id'];
        include('db.php');
        $stmt = mysqli_prepare($connection, "CALL zlecenie_wykonane(?);");
        mysqli_stmt_bind_param($stmt,'i',$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Refresh:0");
        mysqli_close($connection);
    }
    ?>
        <?php endif; ?>
    </div>
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