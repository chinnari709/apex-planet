<?php
// Include the connection file to connect to the MySQL database
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showModal = false;
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new password and confirm password match
    if ($new_password === $confirm_password) {
        // Fetch the user details from the database
        $sql = "SELECT * FROM exampledb WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_sql = "UPDATE exampledb SET password='$hashed_password' WHERE username='$username'";
            if ($conn->query($update_sql) === TRUE) {
                // Redirect to the login page after successful password change
                header('Location: login.php');
                exit();
            } else {
                $showModal = true;
                $errorMessage = "Error updating password. Please try again.";
            }
        } else {
            $showModal = true;
            $errorMessage = "Username does not exist.";
        }
    } else {
        $showModal = true;
        $errorMessage = "Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        /* Center the form on the page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Modal styles */
        .modal {
            display: <?= $showModal ? 'block' : 'none' ?>;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #ffffff;
            margin: 15% auto;
            padding: 20px;
            border: 2px solid #dc3545; /* Red border */
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-header {
            font-size: 18px;
            font-weight: bold;
            color: #dc3545; /* Red text for header */
            margin-bottom: 10px;
        }

        .modal button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .modal button:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="post" action="forgot_password.php">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" autocomplete="username" required><br><br>

            <label for="new_password">New Password:</label><br>
            <input type="password" id="new_password" name="new_password" autocomplete="new_password" required><br><br>

            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" autocomplete="confirm_password" required><br><br>

            <input type="submit" value="Change Password">
        </form>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                Error
            </div>
            <p><?= $errorMessage ?></p>
            <button onclick="closeModal()">OK</button>
        </div>
    </div>
</body>
</html>
