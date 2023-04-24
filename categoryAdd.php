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
        <label>Category ID: </label>
        <input type="text" name="Kaid">
        <br>
        <label>Category name:</label>
        <input type="text" name="nev">
        <br>
        <input type="submit" name="submit" value="Category adding...">
    </form>
</div>
</body>
