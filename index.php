<?php
session_start();
include_once('data.php');
// include_once('menu.php');
include_once ('functions.php');
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
  <main>
    <h1>Quiz App</h1>
    <?php if (isset($_SESSION["user"])) {
      echo '<pre>';
      print_r($_SESSION["user"]);
      echo '</pre>';
      echo '<pre>';
      print_r($_SESSION["admine"]);
      echo '</pre>';

      if (!isset($_SESSION["pontszam"])){
        $_SESSION["pontszam"] = 0;
      }
      echo $_SESSION["pontszam"];
    }
    ?>
    <br>
    <form action="index.php" method="post">
      <!-- Choose category -->
      <label for="category">Category:</label>
      <select id="category" name="category">
        <?php
        $categories = getCategory();
        while ($oneRow = oci_fetch_array($categories, OCI_ASSOC + OCI_RETURN_NULLS)) {
//          echo '<pre>';
//          print_r($oneRow);
//          echo '</pre>';
//          foreach ($categories as $item) {
//            echo $item." ";}
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
  </main>

  <!-- Game -->
  <div>
    <?php

    //    print_r($_POST);
    if(isset($_POST["difficulty"]) && $_POST["difficulty"]=="easy"){
      $_SESSION["nehez"]=1;
    }
    if(isset($_POST["difficulty"]) && $_POST["difficulty"]=="medium"){
      $_SESSION["nehez"]=2;
    }
    if(isset($_POST["difficulty"]) && $_POST["difficulty"]=="hard"){
      $_SESSION["nehez"]=3;
    }


//    echo "$nehez"

    if (isset($_POST["category"])){
      $_SESSION["kategoria"]= $_POST["category"];
    }

    if (isset($_SESSION["kategoria"]) && isset($_SESSION["nehez"])) {
      $questions = setQuestions(ucfirst($_SESSION["kategoria"]), $_SESSION["nehez"]);
      //$questions = getQuestions();
      //if ($_POST["category"] === "music") { //$_POST["category"] === "music"
      $i = 0;
      $h_valasz = array();
      while ($questionarray = oci_fetch_array($questions, OCI_ASSOC + OCI_RETURN_NULLS)) {
        if (!isset($_SESSION["$i"]) ){
          //echo "hihi";
          $_SESSION["$i"] = 1;
        }

        if ($i == 5) {
          break;
        }
//        if ($questionarray["szint"] == 1){
        echo '<br>';
        echo '<div>';
          //echo $_SESSION[$i];
        if (isset($_SESSION["$i"]) && $_SESSION["$i"] != 0 ){
          echo '<p>' . $questionarray["KERDES"] . '<br></p>';
          echo '<form method="post" action="answer_process.php"><input type="submit" name="kivalasztott" value="' . $questionarray["A_VALASZ"] . '"><input type="hidden" name="valasz" value="' . $questionarray["helyes_v"] . '"><input type="hidden" name="sorszam" value="' . $i . '"></form><br>';
          echo '<form method="post" action="answer_process.php"><input type="submit" name="kivalasztott" value="' . $questionarray["B_VALASZ"] . '"><input type="hidden" name="valasz" value="' . $questionarray["helyes_v"] . '"><input type="hidden" name="sorszam" value="' . $i . '"></form><br>';
          echo '<form method="post" action="answer_process.php"><input type="submit" name="kivalasztott" value="' . $questionarray["C_VALASZ"] . '"><input type="hidden" name="valasz" value="' . $questionarray["helyes_v"] . '"><input type="hidden" name="sorszam" value="' . $i . '"></form><br>';
          echo '<form method="post" action="answer_process.php"><input type="submit" name="kivalasztott" value="' . $questionarray["D_VALASZ"] . '"><input type="hidden" name="valasz" value="' . $questionarray["helyes_v"] . '"><input type="hidden" name="sorszam" value="' . $i . '"></form><br>';
        //$h_valasz=[ $i => ];
        }
        $h_valasz[] = $questionarray["helyes_v"];
        echo '</div>';
        $i++;

//        }
      }
      print_r($h_valasz);

      oci_free_statement($questions);
    }
    //}

//    if (ucfirst($_POST["category"]) !== null) {
//      $kat = ucfirst($_POST["category"]);
//      var_dump($kat);
//    } else {
//      var_dump($_POST["category"]);
//      return;
//    }


    //var_dump($_POST["difficulty"]);
//    if (isset($_POST["difficulty"])) {
//      $szint=$_POST["difficulty"];
//      //var_dump($_POST["difficulty"]);
//    } else {
//      var_dump($_POST["difficulty"]);
//      return;
//    }
    //var_dump($_POST["difficulty"]);
//
//    if($szint=="easy"){
//      $szint=1;
//    }
//    if($szint=="medium"){
//      $szint=2;
//    }
//    if($szint=="hard"){
//      $szint=3;
//    }
    //var_dump($szint);
//
//    if (isset($_POST["submit"])) {
//      $beallitott = setQuestions($kat,$szint);
//      while ($questionarray = oci_fetch_array($beallitott, OCI_ASSOC + OCI_RETURN_NULLS)){
////        echo '<pre>';
////        print_r($questionarray);
////        echo '</pre>';
////        foreach ($questionarray as $item) {
////          echo $item." ";
////        }
//        echo '<br>';
//        echo '<div>';
//        echo '<p>' . $questionarray["KERDES"] . '<br></p>';
//        echo '<button>' . $questionarray["A_VALASZ"] . '<br></button>';
//        echo '<button>' . $questionarray["B_VALASZ"] . '<br></button>';
//        echo '<button>' . $questionarray["C_VALASZ"] . '<br></button>';
//        echo '<button>' . $questionarray["D_VALASZ"] . '<br></button>';
//        echo '</div>';
//      }
//      oci_free_statement($beallitott);
//    }

    ?>
  </div>
  <!--  legalján marad-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>
