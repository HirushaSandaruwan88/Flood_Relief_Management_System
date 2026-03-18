<?php
session_start();
include "db.php";
include "header.php";


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Access denied";
    exit();
}


$user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc();

$request_count = $conn->query("SELECT COUNT(*) AS total FROM relief_requests")->fetch_assoc();

$high_sev = $conn->query("SELECT COUNT(*) AS total FROM relief_requests WHERE flood_severity='High'")->fetch_assoc();

$food = $conn->query("SELECT COUNT(*) AS total FROM relief_requests WHERE relief_type='Food'")->fetch_assoc();
$water = $conn->query("SELECT COUNT(*) AS total FROM relief_requests WHERE relief_type='Water'")->fetch_assoc();
$medicine = $conn->query("SELECT COUNT(*) AS total FROM relief_requests WHERE relief_type='Medicine'")->fetch_assoc();
$shelter = $conn->query("SELECT COUNT(*) AS total FROM relief_requests WHERE relief_type='Shelter'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Summary</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

<h2>System Summary</h2>

<p>Total Users: <?php echo $user_count['total']; ?></p>
<p>Total Relief Requests: <?php echo $request_count['total']; ?></p>
<p>High Severity Requests: <?php echo $high_sev['total']; ?></p>

<h3>Requests by Type</h3>
<ul>
    <li>Food: <?php echo $food['total']; ?></li>
    <li>Water: <?php echo $water['total']; ?></li>
    <li>Medicine: <?php echo $medicine['total']; ?></li>
    <li>Shelter: <?php echo $shelter['total']; ?></li>
</ul>

<br>
<a href="admin_dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
