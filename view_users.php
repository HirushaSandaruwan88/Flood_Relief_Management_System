<?php
session_start();
include "db.php";
include "header.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Access denied";
    exit();
}

$sql = "SELECT id, name, email, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

<h2>All Registered Users</h2>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
</tr>

<?php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['role']."</td>";
    echo "</tr>";
}
?>

</table>

<br>
<a href="admin_dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
