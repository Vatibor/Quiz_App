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
    <link type="text/css" href="style.css" rel="stylesheet" />
</head>

<body>
    <header>
        <hr />
        <?php echo menu(); ?>
        <hr />
    </header>
    <div>
        <form method="POST" action="adding.php" accept-charset="utf-8">
            <label>Question ID: </label>
            <input type="text" name="Keid">
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
            <label>Question difficulty (1-easy, 2-common, 3-hard):</label>
            <input type="number" min="1" max="3" name="szint">
            <br>
            <input type="submit" name="submit" value="Question adding...">
        </form>
    </div>
</body>
