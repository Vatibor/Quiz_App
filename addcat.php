<?php
include_once('functions.php');

if (isset($_POST["category"])) {
    $K_nev = $_POST["nev"];
    if ($K_nev ) {
        $sikeres = categoryAdd($K_nev);
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