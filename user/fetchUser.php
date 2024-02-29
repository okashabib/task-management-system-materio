<?php
include('../connection/db.php');

$select = $conn->query("SELECT * FROM `users`");
$i = 1;
if ($select) {
  while ($row = $select->fetch_assoc()) {
    $id = $row['id'];
    $name = $row['name'];
    $username = $row['username'];

    ?>
    <tr class="data-tr" id="<?php echo $id ?>">
      <td>
        <?php echo $i++; ?>
      </td>
      <td>
        <?php echo $name; ?>
      </td>
      <td>
        <?php echo $username; ?>
      </td>
      <td>
        <button onclick="deleteRow(this, <?= $id ?>)" type="button"
          class="btn rounded-pill btn-icon btn-outline-danger btn-sm">
          <span class="tf-icons mdi mdi-trash-can"></span>
        </button>
        <button onclick="editRow(<?= $id ?>)" type="button" class="btn rounded-pill btn-icon btn-outline-primary btn-sm">
          <span class="tf-icons mdi mdi-pencil"></span>
        </button>
      </td>
    </tr>

    <?php
  }
}
?>
