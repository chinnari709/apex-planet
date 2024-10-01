<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', 'Chinnari@709', 'exdb');

// Check connection
if (!$conn) { // Correct check for connection failure
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connection successful"; // Uncomment this line to see success message
}

