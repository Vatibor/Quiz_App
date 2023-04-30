<?php
session_start();
include_once('data.php');
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
    <title>Quiz App</title>
</head>

<body>
<header>
    <?php include 'menu.php'; ?>
</header>

<main>
    </form>
    <hr />
    <h1>Category's list</h1>
    <table border="1">
        <tr>
            <th>Category</th>
        </tr>

        <?php

        $category = getCategory();

        while ($oneRow = oci_fetch_array($category, OCI_ASSOC + OCI_RETURN_NULLS)) {
            //echo '<pre>';
            //print_r($oneRow);
            //echo '</pre>';
            //foreach ($oneRow as $item) {
            //echo $item." ";
            //}


            echo '<tr>';
            echo '<td>' . $oneRow["NEV"] . '</td>';
            echo '<td>';
            echo '<form action="categoryDel.php" method="POST">';
            echo '<input type="hidden" name="kat" value="' . $oneRow['NEV'] . '">';
            echo '<button type="submit">Törlés</button>';
            echo '</form>';
            echo '</td>';
            echo '<td>';
            echo '<form action="categoryModify.php" method="POST">';
            echo '<input type="hidden" name="kat" value="' . $oneRow['NEV'] . '">';
            echo '<label>New category name:         </label>';
            echo '<input type="text" name="new" value="' . $oneRow['NEV'] . '">';
            echo '<button type="submit" class="btn btn-warning">Modify</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';

        }
        oci_free_statement($category);
        ?>
    </table>
    <php? ?>
</main>

</body>

</html>