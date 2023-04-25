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
<div>
    <form method="POST" action="addcat.php" accept-charset="utf-8">
        <label>Category name:</label>
        <input type="text" name="nev">
        <br>
        <input type="submit" name="category" value="Category adding...">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>
