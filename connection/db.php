<?php

$conn = mysqli_connect('localhost', 'root', '', 'tms');
if ($conn->connect_error) {
  die('<div class="alert alert-danger mb-10" role="alert">Connection failed: ' . $conn->connect_error . '</div>');
}
// echo '<div class="alert alert-info alert-dismissible mt-5 w-20" role="alert">
// DataBase Connected successfully!
// <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
// </div>';

