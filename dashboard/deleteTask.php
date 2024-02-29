<?php

include('../connection/db.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $select = $conn->query("DELETE FROM `create_task` WHERE `id`= $id");

  if ($select === TRUE) {
    echo json_encode(array("message" => "Task deleted successfully"));
  } else {
    echo json_encode(array("error" => $conn->error));
  }
}

?>
