<?php
include_once('data.php');
include_once('menu.php');
include_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
</head>

<body>
    <header>
        <hr />
        <?php echo menu(); ?>
        <hr />
    </header>
    <main>
        <h1>Statistics</h1>

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

            while ($oneRow = oci_fetch_array($statitics, OCI_ASSOC + OCI_RETURN_NULLS)) {
                // echo '<pre>';
                // print_r($oneRow);
                // echo '</pre>';
                echo '<tr>';
                echo '<td>' . $oneRow["NEV"] . '</td>';
                echo '<td>' . $oneRow["HELYES_V_SZAM"] . '</td>';
                echo '<td>' . $oneRow["MEGVAL_K_SZAM"] . '</td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            oci_free_statement($statitics);
            ?>
        </table>
    </main>
</body>

</html>