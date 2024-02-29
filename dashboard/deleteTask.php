<?php

include('../connection/db.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $select = $conn->query("DELETE FROM `create_task` WHERE `id`= $id");

  if ($select === TRUE) {
    $response = ["message" => "Task deleted successfully"];
  } else {
    $response = ["error" => $conn->error];
  }
  echo json_encode($response);
}

?>
