<?php
session_start();
include "db.php";
include "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {

    $user_id = $_SESSION['user_id'];

    $relief_type = $_POST['relief_type'];
    $district = $_POST['district'];
    $divisional = $_POST['divisional'];
    $gn = $_POST['gn'];
    $contact_person = $_POST['contact_person'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $family_members = $_POST['family_members'];
    $severity = $_POST['severity'];
    $description = $_POST['description'];

    $sql = "INSERT INTO relief_requests
    (user_id, relief_type, district, divisional_secretariat, gn_division,
     contact_person, contact_number, address, family_members, flood_severity, description)
    VALUES
    ('$user_id','$relief_type','$district','$divisional','$gn',
     '$contact_person','$contact_number','$address','$family_members','$severity','$description')";
        if ($conn->query($sql)) {
            echo "<script>showMessage('Relief request submitted successfully!');</script>";
        } else {
            echo "<script>showMessage('Error: ".$conn->error."');</script>";
        }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Relief Request</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

<h2>Create Relief Request</h2>

<form method="POST">

Relief Type:
<select name="relief_type" required>
    <option value="">Select</option>
    <option>Food</option>
    <option>Water</option>
    <option>Medicine</option>
    <option>Shelter</option>
</select><br><br>

District:
<input type="text" name="district" required><br><br>

Divisional Secretariat:
<input type="text" name="divisional" required><br><br>

GN Division:
<input type="text" name="gn" required><br><br>

Contact Person:
<input type="text" name="contact_person" required><br><br>

Contact Number:
<input type="text" name="contact_number" required><br><br>

Address:
<textarea name="address" required></textarea><br><br>

Family Members:
<input type="number" name="family_members" required><br><br>

Flood Severity:
<select name="severity" required>
    <option value="">Select</option>
    <option>Low</option>
    <option>Medium</option>
    <option>High</option>
</select><br><br>

Description:
<textarea name="description"></textarea><br><br>

<button type="submit" name="submit">Submit Request</button>

</form>

<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
