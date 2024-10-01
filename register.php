<?php
// Include the connection file to connect to the MySQL database
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showModal = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password

    // Check if username exists
    $checkUserQuery = $conn->prepare("SELECT * FROM exampledb WHERE username=?");
    $checkUserQuery->bind_param("s", $username);
    $checkUserQuery->execute();
    $result = $checkUserQuery->get_result();

    if ($result->num_rows > 0) {
        // Show modal
        $showModal = true;
    } else {
        // Insert the username and hashed password into the database
        $sql = $conn->prepare("INSERT INTO exampledb (username, password) VALUES (?, ?)");
        $sql->bind_param("ss", $username, $password);

        if ($sql->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            // Handle error
            $errorMessage = "There was an error registering your account. Please try again.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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

        .login-link {
            margin-top: 20px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
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
            background-color: rgba(0,0,0,0.5); /* Darker background */
        }

        .modal-content {
            background-color: #ffffff;
            margin: 15% auto;
            padding: 20px;
            border: 2px solid #dc3545; 
            border-radius: 10px;
            width: 300px; /* Fixed width */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-header {
            font-size: 18px;
            font-weight: bold;
            color: #dc3545; 
            margin-bottom: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
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
        <h2>Register</h2>
        <form method="post" action="register.php">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" autocomplete="username" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" autocomplete="new-password" required><br><br>

            <input type="submit" value="Register">
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                Warning
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <p>Username already taken.</p>
            <button onclick="closeModal()">OK</button>
        </div>
    </div>
</body>
</html>
