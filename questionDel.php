<?php
include_once('functions.php');
if (!empty($_POST['kerdes'])) {
    $kerdes = $_POST['kerdes'];
    var_dump($_POST['kerdes']);

    // Adatbázis kapcsolat létrehozása
    $conn = connect_db();
    if (!$conn) {
        die("Sikertelen kapcsolódás az adatbázishoz.");
    }

    // Lekérdezés összeállítása a törléshez
    $sql = "DELETE FROM Kerdes WHERE kerdes = :kerdes";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":kerdes", $kerdes);
    $result = oci_execute($stmt);

    if ($result) {
        echo "Sikeresen törölted a kérdést!";
        header('Location: questions.php');
    } else {
        echo "Hiba történt a törlés során.";
    }

    oci_free_statement($stmt);
    oci_close($conn);
}
?>