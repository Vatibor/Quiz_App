<?php
session_start();
include_once('data.php');
include_once('menu.php');
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
    <h1>Quiz App</h1>
    <?php if (isset($_SESSION["user"])) { 
       echo '<pre>';
       print_r($_SESSION["user"]);
       echo '</pre>';
    } 
    ?>
  </main>
</body>

</html>