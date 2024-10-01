<?php
include 'connection.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM exampledb WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: read.php');  // Redirect back to the main page after deletion
    } else {
        die(mysqli_error($conn));
    }
}
