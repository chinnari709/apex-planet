<?php
include 'connection.php';

// Initialize search variable
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Pagination settings
$limit = 5; // Number of entries to show per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit; // Offset for SQL query

// Get the total number of entries based on search
$totalSql = "SELECT COUNT(*) as total FROM exampledb WHERE id LIKE '%$search%' OR fname LIKE '%$search%' OR lname LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%'";
$totalResult = mysqli_query($conn, $totalSql);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalEntries = $totalRow['total'];
$totalPages = ceil($totalEntries / $limit); // Calculate total pages

// Fetch entries for the current page based on search
$sql = "SELECT * FROM exampledb WHERE id LIKE '%$search%' OR fname LIKE '%$search%' OR lname LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%' LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Arial', sans-serif;
    }

    .container {
      margin-top: 50px;
    }

    table {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table th {
      background-color: #343a40;
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    table td {
      text-align: center;
      padding: 10px;
      vertical-align: middle;
    }

    .btn-dark {
      background-color: #343a40;
      color: #fff;
      border-radius: 5px;
      padding: 5px 10px;
    }

    .btn-dark:hover {
      background-color: #495057;
      color: #fff;
    }

    .btn-danger {
      background-color: #dc3545;
      color: #fff;
      border-radius: 5px;
      padding: 5px 10px;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    table tbody tr:nth-child(odd) {
      background-color: #f2f2f2;
    }

    table tbody tr:nth-child(even) {
      background-color: #e9ecef;
    }

    table tbody tr:hover {
      background-color: #dee2e6;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
      table {
        font-size: 14px;
      }

      table th, table td {
        padding: 5px;
      }
    }

    /* Custom styles for no data message */
    .no-data {
      text-align: center;
      padding: 20px;
      font-size: 18px;
      color: #ff0000;
    }

    /* Add and Logout buttons */
    .action-buttons {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .btn-add {
      background-color: #28a745;
      color: white;
    }

    .btn-logout {
      background-color: #dc3545;
      color: white;
    }
  </style>

  <title>Display Data</title>
</head>

<body>
  <div class="container">
    <h2 class="text-center mb-4">User Information</h2>

    <!-- Add User and Logout Buttons -->
    <div class="action-buttons">
      <a href="register.php" class="btn btn-add">Add User</a>
      <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-logout" data-toggle="modal" data-target="#logoutModal">Logout</button>
    </div>

    <!-- Search Form -->
    <form method="POST" class="mb-4">
      <div class="row justify-content-start">
        <div class="col-md-4 col-sm-6">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by id, name, email, mobile" value="<?= htmlspecialchars($search) ?>" autocomplete="off">
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit">Search</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <!-- Table or "Data not found" message -->
    <?php if (mysqli_num_rows($result) > 0): ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">S1 No</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Mobile</th>
            <th scope="col">Subjects</th>
            <th scope="col">Gender</th>
            <th scope="col">Place</th>
            <th scope="col">Operations</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $email = $row['email'];
            $mobile = $row['mobile'];
            $datas = $row['multipleData'];
            $gender = $row['gender'];
            $place = $row['place'];
            echo '<tr>
              <th scope="row">' . $id . '</th>
              <td>' . $fname . '</td>
              <td>' . $lname . '</td>
              <td>' . $email . '</td>
              <td>' . $mobile . '</td>
              <td>' . $datas . '</td>
              <td>' . $gender . '</td>
              <td>' . $place . '</td>
              <td>
                <a href="update.php?updateid=' . $id . '" class="btn btn-dark">Update</a>
                <a href="delete.php?deleteid=' . $id . '" class="btn btn-danger">Delete</a>
              </td>
            </tr>';
          }
        else: ?>
            <div class="no-data">No data found for your search.</div>
        <?php endif; ?>
        </tbody>
      </table>
    

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>

    <!-- Logout Modal -->
   
<div id="logoutModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document"> <!-- Added modal-dialog-centered class -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="register.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>


  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
