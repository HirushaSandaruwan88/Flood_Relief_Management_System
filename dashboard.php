<?php
session_start();
include "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['name']; ?> 😎</h2>

<p>You are logged in as: <?php echo $_SESSION['role']; ?></p>

<a href="logout.php">Logout</a>

</body>
</html>
