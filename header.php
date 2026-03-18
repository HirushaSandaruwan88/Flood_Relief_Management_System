<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div style="background:#333;color:#fff;padding:10px;">
    <?php if(isset($_SESSION['user_id'])): ?>
        Welcome, <?php echo $_SESSION['name']; ?> |
        <?php if($_SESSION['role'] == 'admin'): ?>
            <a href="admin_dashboard.php" style="color:#fff;">Admin Dashboard</a> |
        <?php else: ?>
            <a href="dashboard.php" style="color:#fff;">Dashboard</a> |
            <a href="create_request.php" style="color:#fff;">New Request</a> |
            <a href="my_requests.php" style="color:#fff;">My Requests</a> |
        <?php endif; ?>
        <a href="logout.php" style="color:#fff;">Logout</a>
    <?php else: ?>
        <a href="login.php" style="color:#fff;">Login</a> |
        <a href="register.php" style="color:#fff;">Register</a>
    <?php endif; ?>
</div>
<hr>
