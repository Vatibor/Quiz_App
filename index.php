<?php
session_start();
include_once('data.php');
include_once ('functions.php');

if (!isset($_SESSION["user"])) {
  header('Location: login.php');
}
?>
<!DOCTYPE html>
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
  <main class="container">
    <h1 class="text-center p-3">Quiz App - Welcome <?php echo $_SESSION["user"] ?>!</h1>
    <?php 
    if ($_SESSION["admine"]) {
      echo '<p>You are logged in an Admin account!</p>';
    }
    if (!isset($_SESSION["pontszam"])){
      $_SESSION["pontszam"] = 0;
    }
    echo '<p>Your last Quiz result: ' .  $_SESSION["pontszam"] . '</p>';
    ?>
    <br>
    <form action="index.php" method="post">
      <!-- Choose category -->
      <label for="category">Category:</label>
      <select id="category" name="category">
        <?php
        $categories = getCategory();
        while ($oneRow = oci_fetch_array($categories, OCI_ASSOC + OCI_RETURN_NULLS)) {
          echo "<option value='" . strtolower($oneRow["NEV"]) . "'>" . $oneRow["NEV"] . "</option>";
        }
        ?>
      </select>

      <!-- Choose difficulty -->
      <label for="difficulty">Difficulty:</label>
      <select id="difficulty" name="difficulty">
        <?php
        $difficulties = getDifficulty();
        foreach ($difficulties as $difficulty) {
          echo "<option value='" . strtolower($difficulty) . "'>" . $difficulty . "</option>";
        }
        ?>
      </select>
      <br><br>
      <input type="submit" value="Start" name="questionButton">
    </form>
  </main>

  <!-- Game -->
  <div class="container">
    <?php

    if(isset($_POST["difficulty"]) && $_POST["difficulty"]=="easy"){
      $_SESSION["nehezseg"]=1;
    }
    if(isset($_POST["difficulty"]) && $_POST["difficulty"]=="medium"){
      $_SESSION["nehezseg"]=2;
    }
    if(isset($_POST["difficulty"]) && $_POST["difficulty"]=="hard"){
      $_SESSION["nehezseg"]=3;
    }

    if (isset($_POST["category"])){
      $_SESSION["kategoria"]= $_POST["category"];
    }

    $letterArray = ["A", "B", "C", "D"];
    if (isset($_POST['questionButton'])) {

      echo '<form method="post" action="answer_process.php">';

      $randomizedQuestions = randomizeQuestionArray();

      for ($i = 0; $i<count($randomizedQuestions); $i++){
        $questionarray = $randomizedQuestions[$i];
        echo '<br>';
        echo '<div>';
        echo '<p>' . $questionarray["KERDES"] . '<br></p>';

        $randomLetterKeys = array_rand($letterArray, count($letterArray));
        shuffle($randomLetterKeys);
        for ($j = 0; $j<count($randomLetterKeys); $j++){
          $currentKey = $randomLetterKeys[$j];
          printOptionsRandomly($letterArray[$currentKey], $i, $questionarray);
        }
        echo '<input type="hidden" name="valasz' . $i . '" value="' . $questionarray["helyes_v"] . '"><input type="hidden" name="sorszam" value="' . $i . '">';
        echo '</div>';
      }
      echo '<input class="mt-3 mb-5" type="submit" value="Let\'s Go">';
      echo '</form>';
    }

    ?>
  </div>
  <!--  legalján marad-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>