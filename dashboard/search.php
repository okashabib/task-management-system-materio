<?php

include('../connection/db.php');

if (isset($_POST['search'])) {
  $search = $_POST['search'];

  $query = "SELECT ct.title, u.name FROM `create_task` ct JOIN `users` u ON ct.user_id = u.id WHERE ct.title LIKE '%$search%' OR u.name LIKE '%$search%'";

  $execute = mysqli_query($conn, $query);

  if (mysqli_num_rows($execute) == 0) {
    echo "<div class='no-results'>No results found for <b>'$search'</b></div>";
  }
}

?>
