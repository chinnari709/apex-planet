<?php
include 'connection.php';
$id = $_GET['updateid'];

// Fetch the existing data for the selected record
$sql = "SELECT * FROM exampledb WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$fname = $row['fname'];
$lname = $row['lname'];
$email = $row['email'];
$mobile = $row['mobile'];
$datas = $row['multipleData'];
$gender = $row['gender'];
$place = $row['place'];

// Handle form submission
if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // Handle subjects (checkboxes)
    if (isset($_POST['data']) && is_array($_POST['data'])) {
        $datas = $_POST['data'];
        $allData = implode(",", $datas);
    } else {
        $allData = '';
    }

    // Handle gender (radio buttons)
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    }

    // Handle place (select box)
    $place = $_POST['place'];

    // Update the record in the database
    $sql = "UPDATE exampledb SET fname='$fname', lname='$lname', email='$email', mobile='$mobile', multipleData='$allData', gender='$gender', place='$place' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location:read.php');
    } else {
        die("Error updating: " . mysqli_error($conn));
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            margin-top: 50px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 30px;
            font-weight: bold;
            color: #343a40;
        }

        .form-group label {
            font-weight: bold;
        }

        .custom-checkbox {
            margin-bottom: 10px;
        }

        .custom-checkbox input {
            margin-right: 10px;
        }

        .radio-buttons {
            margin-bottom: 20px;
        }

        .btn-dark {
            background-color: #343a40;
            color: #fff;
            border-radius: 5px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-dark:hover {
            background-color: #495057;
            color: #fff;
        }

        .btn-lg {
            width: 100%;
        }

        .form-control {
            padding: 10px;
            font-size: 16px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .btn-lg {
                padding: 15px;
            }
        }

        /* Additional styling */
        .my-3.text-center {
            margin-top: 20px;
        }

        .radio-buttons input {
            margin-right: 5px;
            margin-left: 10px; /* Add left margin for spacing */
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
        }

        .custom-checkbox label {
            margin-bottom: 0; /* Remove margin for better alignment */
        }
    </style>

    <title>Update Data</title>
</head>

<body>
    <div class="container form-container">
        <h2 class="text-center">Update Information</h2>
        <form method="post">
            <!-- Form Fields for First Name, Last Name, Email, etc. -->

            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" autocomplete="off" name="fname" value="<?php echo $fname; ?>" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" autocomplete="off" name="lname" value="<?php echo $lname; ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" autocomplete="off" name="email" value="<?php echo $email; ?>" required>
            </div>

            <div class="form-group">
                <label>Mobile</label>
                <input type="text" class="form-control" autocomplete="off" name="mobile" value="<?php echo $mobile; ?>" required>
            </div>

            <div class="form-group">
                <label>Subjects</label>
                <div class="custom-checkbox">
                    <input type="checkbox" name="data[]" value="JavaScript" <?php if (strpos($datas, 'JavaScript') !== false) echo 'checked'; ?>> JavaScript
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" name="data[]" value="React" <?php if (strpos($datas, 'React') !== false) echo 'checked'; ?>> React
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" name="data[]" value="HTML" <?php if (strpos($datas, 'HTML') !== false) echo 'checked'; ?>> HTML
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" name="data[]" value="CSS" <?php if (strpos($datas, 'CSS') !== false) echo 'checked'; ?>> CSS
                </div>
            </div>

            <div class="radio-buttons">
                <label>Gender:</label><br>
                <input type="radio" name="gender" value="male" <?php if ($gender == 'male') echo 'checked'; ?>> Male
                <input type="radio" name="gender" value="female" <?php if ($gender == 'female') echo 'checked'; ?>> Female
                <input type="radio" name="gender" value="kids" <?php if ($gender == 'kids') echo 'checked'; ?>> Kids
            </div>

            <div class="form-group">
                <label>Place</label>
                <select name="place" class="form-control" required>
                    <option value="Mumbai" <?php if ($place == 'Mumbai') echo 'selected'; ?>>Mumbai</option>
                    <option value="Bangalore" <?php if ($place == 'Bangalore') echo 'selected'; ?>>Bangalore</option>
                    <option value="Kolkata" <?php if ($place == 'Kolkata') echo 'selected'; ?>>Kolkata</option>
                    <option value="Mysore" <?php if ($place == 'Mysore') echo 'selected'; ?>>Mysore</option>
                </select>
            </div>

            <div class="my-3 text-center">
                <button class="btn btn-dark" name="update">Update</button>
            </div>
        </form>
    </div>
</body>

</html>
