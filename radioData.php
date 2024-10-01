<?php
include 'connection.php';
if (isset($_POST['submit'])) {
    $gender = $_POST['gender'];
    $sql = "insert into radiodata (gender) values ('$gender')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Data of Radio buttons inserted successfully";
    } else {
        die(mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Button Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <form method="post">
            <div>
                <input type="radio" name="gender" value="male" required>Male
            </div>
            <div>
                <input type="radio" name="gender" value="female" required>Female
            </div>
            <div>
                <input type="radio" name="gender" value="kids" required>Kids
            </div>
            <button type="submit" name="submit" class="btn btn-dark my-5">Submit</button>
        </form>
    </div>
</body>

</html>