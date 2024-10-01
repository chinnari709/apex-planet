<?php
include 'connection.php';
if (isset($_POST['submit'])) {
    $place = $_POST['place'];
    $sql = "insert into selectdata (place) values ('$place')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "data inserted successfully";
    } else {
        die("Error updating: " . mysqli_error($conn));
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select option data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <form method="post">
            <div>
                <select name="place">
                    <option value="Mumbai">Mumbai</option>
                    <option value="Bangalore">Bangalore</option>
                    <option value="Kolkata">Kolkata</option>
                    <option value="Mysore">Mysore</option>
                </select>
            </div>
            <div class="my-5">
                <button type="submit" name="submit" class="btn btn-dark my-5">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>