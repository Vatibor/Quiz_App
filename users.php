<?php
session_start();
// include_once('data.php');
include_once('functions.php');
?>
<!DOCTYPE html>

<head>
  <html lang="en">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <script src="jquery-3.6.4.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="style_users.css">
  <title>Quiz App - Users</title>
</head>

<body>
  <header>
    <?php include 'menu.php'; ?>
  </header>
  <main>
    <h1 class="text-center p-3">Quiz App - Users</h1>
    <div class="container w-75">
      <table border="1" class="table table-hover">
        <thead>
          <tr>
            <th colspan="3">Username</th>
          </tr>

        </thead>
        <tbody>
          <?php

          $users = getUsernames();

          while ($oneRow = oci_fetch_array($users, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo '<tr>';
            echo '<td class="align-middle">' . $oneRow["NEV"] . '</td>';
            echo '<td class="w-10"><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-username="' . $oneRow["NEV"] . '" data-id="' . $oneRow["FID"] . '" data-bs-target="#exampleModal">Modify</button></td>';
            echo '
              <td class="w-10">
                <form method="POST" action=deleteuser.php>
                  <input type="hidden" name="id" value="' . $oneRow["FID"] . '" />
                  <input type="submit" class="btn btn-danger" value="Delete"></input>
                </form>
              
              </td>';
            echo '</tr>';

          }
          oci_free_statement($users);
          ?>
        </tbody>
      </table>
      <php? ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- <input type="text" name="userName" id="userName" value=""/> -->
            
            <form method="POST" action=modifyuser.php>
              <input type="hidden" name="id" id="id" value="" />
              <input type="text" name="userName" id="userName" value=""/>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            
              <input type="submit" class="btn btn-primary" value="Save changes"></input>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

  <script>
    $(document).on("click", ".btn-warning", function () {
      var myUserName = $(this).data('username');
      var myID = $(this).data('id');
      $(".modal-body #userName").val(myUserName);
      $(".modal-body #id").val(myID);
    });
  </script>

</body>

</html>