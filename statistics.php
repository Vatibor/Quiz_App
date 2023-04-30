<?php
session_start();
// include_once('data.php');
// include_once('menu.php');
include_once('functions.php');
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
  <title>Quiz App - Statistics</title>
</head>

<body>
    <header>
        <?php include 'menu.php'; ?>
    </header>
    <main>
        <h1 class="text-center p-3">Statistics</h1>
        <div class="container">
        <table border="1">
            <tr>
                <th>Username</th>
                <th>Correct answers</th>
                <th>All answered questions</th>
                <th>Success rate</th>
                <th>Position</th>
            </tr>

            <?php
            $statitics = getStatistic();
            $succesrate = getSuccesrate($_SESSION["id"]);
            while ($oneRow = oci_fetch_array($statitics, OCI_ASSOC + OCI_RETURN_NULLS)) {
                // echo '<pre>';
                // print_r($oneRow);
                // echo '</pre>';
                echo '<tr>';
                echo '<td>' . $oneRow["NEV"] . '</td>';
                echo '<td>' . $oneRow["HELYES_V_SZAM"] . '</td>';
                echo '<td>' . $oneRow["MEGVAL_K_SZAM"] . '</td>';
                echo '<td>' . $succesrate . '%</td>';
                echo '<td></td>';
                echo '</tr>';
            }
            oci_free_statement($statitics);
            ?>
        </table>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>