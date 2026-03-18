<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM relief_requests
        WHERE id = '$id' AND user_id = '$user_id'";

$conn->query($sql);

header("Location: my_requests.php");
exit();
?>
