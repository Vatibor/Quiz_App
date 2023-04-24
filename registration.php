<?php
include_once('menu.php');
include_once('functions.php');

$users = getUsernames();

$success = FALSE;
$errors = [];


if (isset($_POST["submit"])) { // submit pressed
  // name validation
  if (!isset($_POST["name"]) || trim($_POST["name"]) === "") {
    $errors[] = "Providing the Username is mandatory!";
  } else if (!ctype_alnum($_POST["name"])) {
    $hibak[] = "The username can only contain letters and numbers!";
  }

  // password validation
  if (!isset($_POST["password"]) || trim($_POST["password"]) === "" || !isset($_POST["password2"]) || trim($_POST["password2"]) === "") {
    $errors[] = "The password and verification password are mandatory to provide!";
  }
  if (strlen($_POST["password"]) < 8) {
    $errors[] = "The password must be at least 8 characters long!";
  }
  if (!preg_match('@[A-Z]@', $_POST["password"]) && !preg_match('@[0-9]@', $_POST["password"])) {
    $errors[] = "The password must contain at least one uppercase letter and one number!";
  }
  if ($_POST["password"] !== $_POST["password2"]) {
    $errors[] = "The password and verification password do not match!";
  }

  $name = $_POST["name"];
  $password = $_POST["password"];
  $password2 = $_POST["password2"];
  $id = 1;
  //  Username check.
  while ($oneRow = oci_fetch_array($users, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $id++;
    if ($oneRow["NEV"] === $name) // If the name provided in the form matches that of a registered user...
      $errors[] = "The username is already taken!";
  }
  oci_free_statement($users);
  
  if(count($errors) === 0){
    addNewUser($id, $name, $password);
    $success = TRUE;
  } else {
    $success = FALSE;
  }
}






?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz App - Registration</title>
</head>

<body>
  <header>
    <hr />
    <?php echo menu(); ?>
    <hr />
  </header>
  <main>
    <div>
      <h1>Quiz App - Registration</h1>
    </div>


    <div class="panel">
      <br>
      <?php
      if (isset($siker) && $siker === TRUE) { // ha nem volt hiba, akkor a regisztráció sikeres
        echo "<p>Sikeres regisztráció! Átirányítás...</p>";

        header("Location: index.php");
      } else { // az esetleges hibákat kiírjuk egy-egy bekezdésben
        foreach ($errors as $error) {
          echo "<p>" . $error . "</p>";
        }
      }
      ?>


      <div class="container p-5">
        <form action="registration.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="name" class="form-label">User Name</label>
            <input type="name" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="re-password" class="form-label">Re-Password</label>
            <input type="password" class="form-control" id="re-password" name="password2" required>
          </div>
          <!-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div> -->
          <button type="submit" class="btn btn-primary" name="submit">Registration</button>
        </form>
      </div>

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>