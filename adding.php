<?php
include_once('functions.php');

if (isset($_POST["submit"])) {
    $K_kerdes = $_POST["kerdes"];
    $K_A = $_POST["A_valasz"];
    $K_B = $_POST["B_valasz"];
    $K_C = $_POST["C_valasz"];
    $K_D = $_POST["D_valasz"];
    $K_H = $_POST["Helyes_v"];
    $K_szint = $_POST["szint"];
    $K_kaid=$_POST["category"];
    var_dump($_POST["category"]);

    if ($K_kaid && $K_kerdes && $K_A && $K_B && $K_C && $K_D && $K_H && $K_szint) {
        $sikeres = questionAdd($K_kaid,$K_kerdes, $K_A, $K_B, $K_C, $K_D, $K_H, $K_szint);
        if ($sikeres) {
            header('Location: index.php');
            exit;
        } else {
            echo 'Hiba történt a felvételnél';
        }
    } else {
        echo 'Hiányzó adat(ok)';
    }
}
?>
