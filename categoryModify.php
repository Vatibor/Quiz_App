<script>
    // Az űrlap elküldése AJAX kérésként
    const form = document.querySelector('#modify-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(form);
        const response = await fetch('categoryModify.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.success) {
            alert('Sikeres módosítás!');
            window.location.href = 'questions.php';
        } else {
            alert('Hiba történt!');
        }
    });
</script>
<?php
include_once('data.php');
include_once('functions.php');

$conn = connect_db();
if (!$conn) {
    die("Sikertelen kapcsolódás az adatbázishoz.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kat=$_POST['kat'];
    $new = $_POST['new'];

    // SQL utasítás előkészítése
    $sql = "UPDATE kategoria SET nev = :new WHERE nev = :kat";

    // Utasítás előkészítése az adatbázis számára
    $stmt = oci_parse($conn, $sql);

    // Adatok kötése a helyettesítő jelölőkhöz
    oci_bind_by_name($stmt, ":kat", $kat);
    oci_bind_by_name($stmt, ":new", $new);

    // Utasítás végrehajtása
    oci_execute($stmt);

    // Sikeres módosítás üzenet megjelenítése
    echo "<script>alert('Sikeres módosítás!');</script>";

    // Átirányítás az előző oldalra
    echo "<script>window.history.back();</script>";
}

// Kapcsolat bezárása
oci_close($conn);
?>