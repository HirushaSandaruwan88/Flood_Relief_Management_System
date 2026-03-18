<?php
session_start();
include "db.php";
include "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM relief_requests WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Requests</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

<h2>My Relief Requests</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Type</th>
    <th>District</th>
    <th>Severity</th>
    <th>Action</th>
</tr>

<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['relief_type']; ?></td>
            <td><?php echo $row['district']; ?></td>
            <td><?php echo $row['flood_severity']; ?></td>
            <td>
                <a href="edit_request.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_request.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this request?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="5">No requests found</td></tr>
<?php endif; ?>

</table>

<br>
<a href="create_request.php">➕ Create New Request</a><br>
<a href="dashboard.php">⬅ Dashboard</a>

</body>
</html>
