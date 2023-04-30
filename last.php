<?php
session_start();
include_once('data.php');
include_once('functions.php');

$conn = connect_db();
if (!$conn) {
    die("Sikertelen kapcsolódás az adatbázishoz.");
}
$stmt = oci_parse($conn, "BEGIN :cursor := get_last_10_users(); END;");
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);

oci_execute($cursor);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Quiz App</title>
</head>

<body>
<header>
    <?php include 'menu.php'; ?>
</header>

<div class="container">
    <h1>Last 10 registered User. Thank you for joining!</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while (($row = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
            echo "<tr>";
            echo "<td>" . $row['NEV'] . "</td>";
            echo "</tr>";
        }
        oci_free_statement($stmt);
        oci_close($conn);
        ?>
        </tbody>
    </table>
</div>

</html>