<?php
session_start();
include "header.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Access denied";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Admin Dashboard</h2>

<ul>
    <li><a href="view_users.php">View All Users</a></li>
    <li><a href="view_requests.php">View All Relief Requests</a></li>
    <li><a href="admin_summary.php">Summary Report</a></li>
</ul>

<a href="logout.php">Logout</a>

</body>
</html>
