<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Fetch existing user information
$stmt = $conn->prepare("SELECT fname, lname, email, mobile, multipleData, gender, place FROM exampledb WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $datas = $_POST['data'] ?? []; // Use null coalescing to avoid undefined variable
    $allData = implode(",", $datas);
    $gender = $_POST['gender'];
    $place = $_POST['place'];

    // Update user information in the same row in the database
    $sql = $conn->prepare("UPDATE exampledb SET fname=?, lname=?, email=?, mobile=?, multipleData=?, gender=?, place=? WHERE username=?");
    $sql->bind_param("ssssssss", $fname, $lname, $email, $mobile, $allData, $gender, $place, $username);

    if ($sql->execute()) {
        header('Location: read.php'); // Redirect after successful update
        exit();
    } else {
        $errorMessage = "Error updating information. Please try again."; // User-friendly error message
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light background for better contrast */
            font-family: Arial, sans-serif; /* Change font style */
        }
        .container {
            background-color: #ffffff; /* White background for form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            padding: 20px; /* Padding for spacing */
            margin-top: 50px; /* Top margin for spacing */
        }
        h2 {
            margin-bottom: 20px; /* Space below heading */
            color: #007bff; /* Custom color for heading */
        }
        .btn-primary {
            background-color: #007bff; /* Custom button color */
            border-color: #007bff; /* Custom border color */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade on hover */
            border-color: #0056b3; /* Darker border on hover */
        }
        .alert {
            margin-top: 20px; /* Space above alert */
        }
        label {
            font-weight: bold; /* Bold labels */
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>Complete Your Profile</h2>
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" name="fname" value="<?= htmlspecialchars($userData['fname']) ?>" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" name="lname" value="<?= htmlspecialchars($userData['lname']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" name="mobile" value="<?= htmlspecialchars($userData['mobile']) ?>" required>
            </div>
            <div class="form-group">
                <label>Skills:</label><br>
                <?php 
                $skills = explode(",", $userData['multipleData']); // Existing skills
                ?>
                <label><input type="checkbox" name="data[]" value="JavaScript" <?= in_array('JavaScript', $skills) ? 'checked' : '' ?>> JavaScript</label>
                <label><input type="checkbox" name="data[]" value="React" <?= in_array('React', $skills) ? 'checked' : '' ?>> React</label>
                <label><input type="checkbox" name="data[]" value="HTML" <?= in_array('HTML', $skills) ? 'checked' : '' ?>> HTML</label>
                <label><input type="checkbox" name="data[]" value="CSS" <?= in_array('CSS', $skills) ? 'checked' : '' ?>> CSS</label>
            </div>
            <div class="form-group">
                <label>Gender:</label><br>
                <label><input type="radio" name="gender" value="male" <?= $userData['gender'] == 'male' ? 'checked' : '' ?> required> Male</label>
                <label><input type="radio" name="gender" value="female" <?= $userData['gender'] == 'female' ? 'checked' : '' ?> required> Female</label>
                <label><input type="radio" name="gender" value="kids" <?= $userData['gender'] == 'kids' ? 'checked' : '' ?> required> Kids</label>
            </div>
            <div class="form-group">
                <label for="place">Select Place</label>
                <select name="place" class="form-control" required>
                    <option value="">Select your place</option>
                    <option value="Mumbai" <?= $userData['place'] == 'Mumbai' ? 'selected' : '' ?>>Mumbai</option>
                    <option value="Bangalore" <?= $userData['place'] == 'Bangalore' ? 'selected' : '' ?>>Bangalore</option>
                    <option value="Kolkata" <?= $userData['place'] == 'Kolkata' ? 'selected' : '' ?>>Kolkata</option>
                    <option value="Mysore" <?= $userData['place'] == 'Mysore' ? 'selected' : '' ?>>Mysore</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
