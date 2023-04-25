<?php
session_start();
// include_once('menu.php');
include_once('functions.php');

$users = getUsernames();
$message = "";

if (isset($_POST["login"])) {
  if (!isset($_POST["name"]) || trim($_POST["name"]) === "" || !isset($_POST["password"]) || trim($_POST["password"]) === "") {
    $message = "<strong>Please provide all the required information!</strong>";
  } else {
    $name = $_POST["name"];
    $password = $_POST["password"];


    //  Username and pw check.
    while ($oneRow = oci_fetch_array($users, OCI_ASSOC + OCI_RETURN_NULLS)) {
      if ($oneRow["NEV"] === $name && $oneRow["JELSZO"] === $password) { // If the name provided in the form matches that of a registered user...
        $message = "Login successful!";
        $_SESSION["user"] = $oneRow["NEV"];
        $_SESSION["admine"] = $oneRow["ADMINE"];
        header("Location: index.php");
      } else {
        $message = "Login failed! The login credentials are incorrect!";
      }
    }
    oci_free_statement($users);
   
  }
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

  <title>Quiz App - Login</title>
</head>

<body>
  <header>
    <?php include 'menu.php'; ?>
  </header>
  <main>
    <div class="pt-3">
      <h1 class="text-center">Quiz App - Login</h1>
    </div>

    <?php
    // while ($oneRow = oci_fetch_array($users, OCI_ASSOC + OCI_RETURN_NULLS)) {
    //   echo '<pre>';
    //   print_r($oneRow);
    //   echo '</pre>';
    // }
    ?> 

    <div class="container p-5">
      <form action="login.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label">User Name</label>
          <input type="name" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button>
      </form>
      <?php echo $message . "<br/>"; ?>
    </div>

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>