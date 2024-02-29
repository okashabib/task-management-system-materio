<?php

include('../connection/db.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  try {
    if ($conn->query("DELETE FROM `users` WHERE `id`= $id")) {
      $response = ["message" => "User deleted successfully"];
    } else {
      $response = ["error" => "An error occurred while deleting the user."];
    }
  } catch (mysqli_sql_exception) {
    $response = ["error" => "You cannot delete this user because there are tasks assigned to them."];
  }

  echo json_encode($response);
}

?>
