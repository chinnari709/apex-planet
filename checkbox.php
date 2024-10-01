<?php
include 'connection.php';
if (isset($_POST['submit'])) {
  $datas = $_POST['data'];
  // echo $datas;
  $allData = implode(",", $datas);
  // echo $allData;

  $sql = "insert into multipledata (checkBoxData) values('$allData')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "inserted successfully";
  } else {
    die("Connection failed: " . mysqli_connect_error());
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

  <title>Multiple
    Checkbox data
  </title>
</head>

<body>
  <div class="container my-5">
    <form method="post">
      <div class="input-group-text">
        <input type="checkbox" name="data[]" value="JavaScript">JavaScript
      </div>
      <div class="input-group-text my-3">
        <input type="checkbox" name="data[]" value="React">React
      </div>
      <div class="input-group-text my-3">
        <input type="checkbox" name="data[]" value="HTML">HTML
      </div>
      <div class="input-group-text my-3">
        <input type="checkbox" name="data[]" value="CSS">CSS
      </div>
      <button class="btn btn-dark my-3" name="submit" type="submit">Submit</button>

    </form>
  </div>

</body>

</html>