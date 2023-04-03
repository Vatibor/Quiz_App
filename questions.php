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
        // echo '<pre>';
        // print_r($oneRow);
        // echo '</pre>';
        // foreach ($oneRow as $item) {
        //   echo $item." ";
        // }
    
        echo '<tr>';
        echo '<td>' . $oneRow["KERDES"] . '</td>';
        echo '<td>' . $oneRow["A_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["B_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["C_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["D_VALASZ"] . '</td>';
        echo '<td>' . $oneRow["NEV"] . '</td>';
        echo '<td>' . $oneRow["SZINT"] . '</td>';
        echo '</tr>';
      }
      oci_free_statement($questions);
      ?>
    </table>
    <php? ?>
  </main>

</body>

</html>