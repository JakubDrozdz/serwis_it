<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['good']);
session_destroy();
header("Location: http://127.0.0.1/serwis_it/site/php/index.php");
?>