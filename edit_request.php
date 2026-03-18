<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$sql = "SELECT * FROM relief_requests 
        WHERE id = '$id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "Request not found.";
    exit();
}

$request = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $relief_type = $_POST['relief_type'];
    $district = $_POST['district'];
    $severity = $_POST['severity'];
    $description = $_POST['description'];

    $update_sql = "UPDATE relief_requests SET
        relief_type='$relief_type',
        district='$district',
        flood_severity='$severity',
        description='$description'
        WHERE id='$id' AND user_id='$user_id'";

    if ($conn->query($update_sql)) {
    echo "<script>showMessage('Request updated successfully!');</script>";
    echo "<script>window.location.href='my_requests.php';</script>";
    } else {
        echo "<script>showMessage('Update failed.');</script>";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Request</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

<h2>Edit Relief Request</h2>

<form method="POST">

Relief Type:
<select name="relief_type" required>
    <option <?php if($request['relief_type']=="Food") echo "selected"; ?>>Food</option>
    <option <?php if($request['relief_type']=="Water") echo "selected"; ?>>Water</option>
    <option <?php if($request['relief_type']=="Medicine") echo "selected"; ?>>Medicine</option>
    <option <?php if($request['relief_type']=="Shelter") echo "selected"; ?>>Shelter</option>
</select><br><br>

District:
<input type="text" name="district" value="<?php echo $request['district']; ?>" required><br><br>

Flood Severity:
<select name="severity" required>
    <option <?php if($request['flood_severity']=="Low") echo "selected"; ?>>Low</option>
    <option <?php if($request['flood_severity']=="Medium") echo "selected"; ?>>Medium</option>
    <option <?php if($request['flood_severity']=="High") echo "selected"; ?>>High</option>
</select><br><br>

Description:
<textarea name="description"><?php echo $request['description']; ?></textarea><br><br>

<button type="submit" name="update">Update</button>

</form>

<a href="my_requests.php">⬅ Back</a>

</body>
</html>
