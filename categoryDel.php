<?php
include_once('functions.php');
if (!empty($_POST['kat'])) {
    $nev= $_POST['kat'];
    var_dump($_POST['kat']);

    // Adatbázis kapcsolat létrehozása
    $conn = connect_db();
    if (!$conn) {
        die("Sikertelen kapcsolódás az adatbázishoz.");
    }

    // Lekérdezés összeállítása a törléshez
    $sql = "DELETE FROM Kategoria WHERE nev = :nev";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":nev", $nev);
    $result = oci_execute($stmt);

    if ($result) {
        echo "Sikeresen törölted a kategóriát!";
        header('Location: category.php');
    } else {
        echo "Hiba történt a törlés során.";
    }

    oci_free_statement($stmt);
    oci_close($conn);
}
?>