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
              <h1 class="mt-4">Users</h1>
              <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
              </ol>

              <div class="d-flex justify-content-end p-2">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                  data-bs-target="#staticBackdrop" data-bs-whatever="@mdo">Add User</button>
              </div>

              <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Create user</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body" method="POST" id="userForm">

                      <div class="form-floating mb-3">
                        <input type="hidden" name="id" id="userId">
                        <input type="text" class="form-control" id="floatingInputName" placeholder="Enter user"
                          name="user" required>
                        <label for="floatingInput">Enter Name</label>
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" class="form-control" name="username" id="userName" placeholder="Username"
                          aria-label="Username" aria-describedby="basic-addon1" required>
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
              <div class="card mb-4 text-secondary" id="dataTable">
                <div class="card-header fw-bold">
                  <i class="mdi mdi-account text-primary "></i>
                  Users List
                </div>
                <div class="card-body table-responsive text-nowrap">
                  <table class="table table-hover" id="datatablesSimple">
                    <thead class="table-dark">
                      <tr>
                        <th>S.NO</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="tableBody">
                      <?php include('./fetchUser.php') ?>
                    </tbody>
                  </table>
                </div>
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

    $('#userForm').submit(function (e) {
      e.preventDefault();

      $('#submit').hide();
      $('#loader').show();

      let formData = $(this).serialize();

      $.ajax({
        method: 'POST',
        url: 'userData.php',
        data: formData,
        success: function (response) {
          let responseObj = JSON.parse(response);
          let result = responseObj.error || responseObj.message;
          let resEmoji = responseObj.error ? '✗ ' : '✓ ';
          let toastColor = responseObj.error ? 'linear-gradient(to right, red, orangered)' : 'linear-gradient(to right, #04364A, black)';

          if (responseObj.error) {
            $('#submit').show();
            $('#loader').hide();

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
          } else {
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
            $('#userForm')[0].reset();
            $('#userId').val('');
            $('#staticBackdrop').modal('hide');
            $('.modal-backdrop').remove();

            $.get(location.href, function (data) {
              var newContent = $(data).find('#dataTable').html();
              $('#dataTable').html(newContent);

              const datatablesSimple = document.getElementById('datatablesSimple');
              if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
              }
            });
          }
        }
      });
    });

    function editRow(id) {
      $.ajax({
        method: 'GET',
        url: './getUser.php',
        data: { id: id },
        success: function (res) {
          let userModal = JSON.parse(res);
          console.log(userModal);

          $('#userId').val(userModal.id);
          $('#floatingInputName').val(userModal.name);
          $('#userName').val(userModal.username);

          $('#staticBackdrop').modal('show');
        },
      });
    }

    function deleteRow(button, id) {
      $.ajax({
        method: 'GET',
        url: './deleteUser.php',
        data: { id: id },
        success: function (res) {
          console.log(res);
          let response = JSON.parse(res)

          let result = response.error || response.message;
          let resEmoji = response.error ? '✗ ' : '✓ ';
          let toastColor = response.error ? 'linear-gradient(to right, red, orangered)' : 'linear-gradient(to right, #04364A, black)';

          if (response.error) {
            Toastify({
              text: resEmoji + result,
              duration: 4000,
              stopOnFocus: true,
              position: 'center',
              style: {
                background: toastColor,
                borderRadius: "10px",
              },
              offset: {
                y: 50
              },
            }).showToast();
          } else {
            Toastify({
              text: resEmoji + result,
              duration: 4000,
              stopOnFocus: true,
              position: 'center',
              style: {
                background: toastColor,
                borderRadius: "10px",
              },
              offset: {
                y: 50
              },
            }).showToast();
            $(button).closest('tr').remove();
          }

        }
      })
    }

    $('#staticBackdrop').on('hidden.bs.modal', function () {
      $('#userForm')[0].reset();
      $('#userId').val('');
    });

  </script>

</body>

</html>
