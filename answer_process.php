<?php
session_start();
include_once('functions.php');

$_SESSION["pontszam"] = 0;

for ($i = 0; $i < 5; $i++){
    $valasz = $_POST["valasz".$i];
    $kiv = $_POST["kivalasztott".$i]; //!
    if ($valasz == $kiv){
        $_SESSION["pontszam"] ++;
    }
}

update_statistics($_SESSION["id"], $_SESSION["pontszam"]);



header("Location:index.php");
?>