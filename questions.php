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
    <form method="post">
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
      <input type="submit" value="Start">
    </form>
    <hr />
    <h1>Questions list</h1>
    <table border="1">
      <tr>
        <th>Question</th>
        <th colspan="4">Answers</th>
        <th>Category</th>
        <th>Difficulty</th>
      </tr>

      <?php

      $questions = getQuestions();

      while ($oneRow = oci_fetch_array($questions, OCI_ASSOC + OCI_RETURN_NULLS)) {
         //echo '<pre>';
         //print_r($oneRow);
         //echo '</pre>';
         //foreach ($oneRow as $item) {
         //echo $item." ";
         //}


        echo '<tr>';
        echo '<td>' . $oneRow["KERDES"] . '</td>';
        echo '<td>' . $oneRow["A_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["B_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["C_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["D_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["NEV"] . '</td>';
        echo '<td>' . $oneRow["SZINT"] . '</td>';
        echo '</tr>';
        echo '<td>' . $oneRow["SZINT"] . '</td>';
        echo '<td>';
        echo '<form action="questionDel.php" method="POST">';
        echo '<input type="hidden" name="kerdes" value="' . $oneRow['KERDES'] . '">';
        echo '<button type="submit">Törlés</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';

      }
      oci_free_statement($questions);
      ?>
    </table>
    <php? ?>
  </main>

</body>

</html>