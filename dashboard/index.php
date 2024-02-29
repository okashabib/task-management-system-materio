<?php
include('../connection/db.php');

$select = $conn->query("
    SELECT
        ct.id,
        ct.title,
        ct.description,
        u.name,
        s.name as status,
        ct.start_date,
        ct.end_date
    FROM
        create_task as ct
    JOIN
        users as u ON ct.user_id = u.id
    JOIN
        status as s ON ct.status_id = s.id
  ");
$users = $conn->query("SELECT * FROM  `users`");
$status = $conn->query("SELECT * FROM  `status`");
?>

<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
  data-assets-path="../assets/" data-template="vertical-menu-template-free">

<?php include('../includes/header.html'); ?>

<body>

  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php include('../includes/sideBar.php'); ?>
      <div class="layout-page">
        <?php include('../includes/navBar.html'); ?>

        <div class="content-wrapper">

          <main>
            <div class="container-fluid px-4">
              <h1 class="mt-4">Dashboard</h1>
              <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>

              <div class="d-flex justify-content-end p-1 mb-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                  data-bs-whatever="@mdo">Add task</button>
              </div>

              <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Task</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body" method="POST" id="taskForm">
                      <div class="form-floating form-floating-outline mb-4">
                        <input type="hidden" name="id" id="taskId">

                        <input type="text" class="form-control" id="floatingInput" placeholder="Enter title here"
                          name="title" required>
                        <label for="floatingInput">Title</label>
                      </div>
                      <div class="form-floating form-floating-outline mb-4">
                        <textarea class="form-control" placeholder="Leave a description here" id="floatingTextarea"
                          name='description' required></textarea>
                        <label for="floatingTextarea">Description</label>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <div class="form-floating form-floating-outline mb-4">
                            <input type="date" class="form-control" id="startDate" placeholder="Start Date"
                              name="start_date" required>
                            <label for="startDate">Start Date</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating form-floating-outline mb-4">
                            <input type="date" class="form-control" id="endDate" placeholder="End Date" name="end_date"
                              required>
                            <label for="endDate">End Date</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                              name='status' required>
                              <option value="" disabled selected>Select Status</option>
                              <?php
                              if ($status) {
                                while ($row = $status->fetch_assoc()) {
                                  $name = $row['name'];
                                  $id = $row['id'];
                                  ?>
                                  <option value='<?php echo $id; ?>'>
                                    <?php echo $name; ?>
                                  </option>
                                  <?php
                                }
                              } else {
                                echo "Status not found!";
                              }
                              ?>
                            </select>
                            <label for="floatingSelect">Status</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="floatingSelectAssign"
                              aria-label="Floating label select example" name='assign' required>
                              <option value="" disabled selected>Select user</option>
                              <?php
                              if ($users) {
                                while ($row = $users->fetch_assoc()) {
                                  $name = $row['name'];
                                  $id = $row['id'];
                                  ?>
                                  <option value='<?php echo $id; ?>'>
                                    <?php echo $name; ?>
                                  </option>
                                  <?php
                                }
                              } else {
                                echo "error Assign";
                              }
                              ?>
                            </select>
                            <label for="floatingSelectAssign">Assign</label>
                          </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded"
                          data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded" id="submit" name='submit'>Submit</button>
                        <div class="spinner-border" id="loader" style="display: none;" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


              <div class="row" id="taskContainer">
                <?php
                if ($select) {
                  while ($row = $select->fetch_assoc()) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $start_date = $row['start_date'];
                    $end_date = $row['end_date'];
                    $status = $row['status'];
                    $assign = $row['name'];
                    ?>

                    <div class="col-xl-3 col-md-6">
                      <div class="card mb-4 border-2 border-primary">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <h5 class="card-title text-black">
                              <?php echo $title; ?>
                            </h5>
                            <button onclick="deleteTask(this, <?= $id ?>)" class="btn btn-outline-danger btn-sm"
                              data-toggle="tooltip" data-placement="top" title="Delete Task"><i
                                class="mdi mdi-close"></i></button>
                          </div>

                          <hr class="text-dark">
                          <p class="text-black">
                          <h6>Description:</h6>
                          <?php echo $description; ?>
                          </p>
                        </div>
                        <ul class="list-group list-group-flush custom-list">
                          <li class="list-group-item custom-item text-black"> <strong>Start date:</strong>
                            <?php echo $start_date; ?>
                          </li>
                          <li class="list-group-item custom-item text-black"> <strong>End date:</strong>
                            <?php echo $end_date; ?>
                          </li>
                          <li class="list-group-item custom-item text-black"> <strong>Task status:</strong>
                            <?php echo $status; ?>
                          </li>
                          <li class="list-group-item custom-item text-black"> <strong>Assign to:</strong>
                            <?php echo $assign; ?>
                          </li>
                        </ul>
                        <div class="card-footer cardFooter d-flex align-items-center justify-content-center"
                          style="cursor: pointer;">
                          <button class="small text-primary btn btn-outline-primary" id="viewTaskDetails"
                            data-card-id="<?php echo $id; ?>">View
                            Details <i class="mdi mdi-arrow-top-right-thick text-xl-end ms-2"></i></button>
                        </div>
                      </div>
                    </div>
                  <?php }
                } else {
                  echo 'Data not found';
                }
                ?>
              </div>
            </div>
          </main>
          <?php include('../includes/footer.html'); ?>

          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

  <?php include('../includes/scripts.html'); ?>

  <script>
    $('#taskForm').submit(function (e) {
      e.preventDefault();

      $('#submit').hide();
      $('#loader').show();

      let formData = $(this).serialize();

      $.ajax({
        method: 'POST',
        url: './taskData.php',
        data: formData,
        success: function (response) {
          console.log(response)
          let responseObj = JSON.parse(response);
          let result = responseObj.error || responseObj.message;
          let resEmoji = responseObj.error ? '✗ ' : '✓ ';
          let toastColor = responseObj.error ? 'linear-gradient(to right, red, orangered)' : 'linear-gradient(to right, #04364A, black)';

          Toastify({
            text: resEmoji + result,
            duration: 4000,
            stopOnFocus: true,
            position: "center",
            style: {
              background: toastColor,
              borderRadius: "10px",
            },
            offset: {
              y: 50
            },
          }).showToast();
          $('#loader').hide();
          $('#submit').show();

          $('#taskForm')[0].reset();
          $('#taskId').val('');
          $('#staticBackdrop').modal('hide');
          $('.modal-backdrop').remove();
          $('#taskContainer').load(location.href + " #taskContainer");
        },
      });
    });

    function changeModalTitle(title) {
      document.getElementById('staticBackdropLabel').innerText = title;
    }

    $(document).on('click', '#viewTaskDetails', function (e) {
      e.preventDefault();
      changeModalTitle('Update Task')
      let taskId = $(this).data('card-id');

      $.ajax({
        method: 'GET',
        url: './geTask.php',
        data: { id: taskId },

        success: function (res) {
          let dataModal = JSON.parse(res);
          console.log(dataModal);

          $('#taskId').val(dataModal.id);
          $('#floatingInput').val(dataModal.title);
          $('#floatingTextarea').val(dataModal.description);
          $('#startDate').val(dataModal.start_date);
          $('#endDate').val(dataModal.end_date);
          $('#floatingSelect').val(dataModal.status_id);
          $('#floatingSelectAssign').val(dataModal.user_id);
          $('#staticBackdrop').modal('show');
        }
      })
    });

    $('#staticBackdrop').on('hidden.bs.modal', function () {
      $('#taskForm')[0].reset();
      $('#taskId').val('');
      changeModalTitle('Create Task')
    });

    function deleteTask(button, id) {
      $.ajax({
        method: 'GET',
        url: './deleteTask.php',
        data: { id: id },
        success: function (res) {
          console.log(res);
          let message = JSON.parse(res).message;

          Toastify({
            text: '✓ ' + message,
            duration: 4000,
            stopOnFocus: true,
            position: 'center',
            style: {
              background: "linear-gradient(to right, red, orangered)",
              borderRadius: "10px",
            },
            offset: {
              y: 50
            },
          }).showToast();

          $(button).closest('.col-xl-3').remove();
        }
      })
    }

    $(document).ready(function () {
      $('#search').keyup(function () {
        let name = $(this).val().toLowerCase();
        if (name === '') {
          $('#display').hide()
        } else {
          $.ajax({
            method: 'POST',
            url: 'search.php',
            data: { search: name },
            success: function (data) {
              $("#display").html(data).show();
            }
          });
        }
      });
    });

    $('#search').keyup(function () {
      let searchText = $(this).val().toLowerCase();
      $('#taskContainer .col-xl-3').each(function () {
        let cardTitle = $(this).find(".card-title").text().toLowerCase();
        let cardAssign = $(this).find("li.list-group-item:nth-of-type(4)").text().toLowerCase();
        if (cardTitle.includes(searchText) || cardAssign.includes(searchText)) {
          $(this).show();
        } else {
          $(this).hide()
        }
      });
    });

  </script>

</body>

</html>
