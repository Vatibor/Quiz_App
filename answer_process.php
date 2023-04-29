<?php
session_start();

for ($i = 0; $i < 5; $i++){
    $valasz = $_POST["valasz".$i];
    $kiv = $_POST["kivalasztott".$i]; //!
    if ($valasz == $kiv){
        $_SESSION["pontszam"] ++;
    }
}

header("Location:index.php");
?>