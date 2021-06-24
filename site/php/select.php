<?php
include('db.php');
$email=$_POST['email'];
$email= filter_var($email, FILTER_SANITIZE_EMAIL);
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = mysqli_prepare($connection, "SELECT opis,data_wizyty,czy_wykonane FROM zlecenia JOIN klient ON(zlecenia.klient_klient_id=klient.klient_id) WHERE klient.email=?");
    mysqli_stmt_bind_param($stmt, 's', $email);
}
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $desc_db,$date_db,$is_done_db);
echo "<div id='tab_wrapper'><table id='tab'>
        <tr id='first_row'>
            <th>Lp.</th>
            <th>Opis wizyty</th>
            <th>Data wizyty.</th>
            <th>Czy wykonane</th>
        </tr>";
$i=1;
while(mysqli_stmt_fetch($stmt)){
    $desc=$desc_db;
    $date=$date_db;
    $is_done=$is_done_db;
    if($is_done==1) $is_done="TAK";
    else $is_done="NIE";
    echo "<tr>";
    echo "<td>$i</td><td>$desc</td><td>$date</td><td>$is_done</td>";
    echo "</tr>";
    $i++;
}
echo "</table></div>";
?>