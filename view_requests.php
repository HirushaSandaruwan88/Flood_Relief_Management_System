<?php
session_start();
include "db.php";
include "header.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Access denied";
    exit();
}

$sql = "SELECT relief_requests.id,
               relief_requests.relief_type,
               relief_requests.district,
               relief_requests.flood_severity,
               relief_requests.description,
               relief_requests.created_at,
               users.name
        FROM relief_requests
        JOIN users ON relief_requests.user_id = users.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Relief Requests</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

<h2>All Relief Requests</h2>

<table border="1" cellpadding="8">
<tr>
    <th>Request ID</th>
    <th>User</th>
    <th>Relief Type</th>
    <th>District</th>
    <th>Severity</th>
    <th>Description</th>
    <th>Date</th>
</tr>

<?php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['relief_type']."</td>";
    echo "<td>".$row['district']."</td>";
    echo "<td>".$row['flood_severity']."</td>";
    echo "<td>".$row['description']."</td>";
    echo "<td>".$row['created_at']."</td>";
    echo "</tr>";
}
?>

</table>

<br>
<a href="admin_dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
