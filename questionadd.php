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
  <title>Quiz App</title>
</head>

<body>
    <header>
        <?php include 'menu.php'; ?>
    </header>
    <div class="format">
        <form method="POST" action="adding.php" accept-charset="utf-8">
            <label for="category">Category:</label>
            <select id="category" name="category">
                <?php
                $categories = getCategory();
                while ($oneRow = oci_fetch_array($categories, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<option value='" . $oneRow["NEV"] . "'>" . $oneRow["NEV"] . "</option>";
                }
                ?>

            </select>
            <br>
            <label>Question:</label>
            <input type="text" name="kerdes">
            <br>
            <label>A answer:</label>
            <input type="text" name="A_valasz">
            <br>
            <label>B answer: </label>
            <input type="text" name="B_valasz">
            <br>
            <label>C answer:</label>
            <input type="text" name="C_valasz">
            <br>
            <label>D answer:</label>
            <input type="text" name="D_valasz">
            <br>
            <label>Right answer:</label>
            <input type="text" name="Helyes_v">
            <br>
            <label>Question difficulty (1-easy, 2-medium, 3-hard):</label>
            <input type="number" min="1" max="3" name="szint">
            <br>
            <input type="submit" name="submit" value="Question adding...">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>
