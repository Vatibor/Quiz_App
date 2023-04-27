<?php
session_start();
$valasz = $_POST["valasz"];
$kiv = $_POST["kivalasztott"];
if ($valasz == $kiv){
    $_SESSION["pontszam"] ++;
}
//echo $valasz;
//echo $kiv;

$_SESSION[$_POST["sorszam"]] = 0;
//echo "<pre>";
//print_r($_SESSION);

header("Location:index.php");
?>