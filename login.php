<?php
session_start();
include "db.php";

$login_error = ""; 

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_safe = $conn->real_escape_string($email);

    $sql = "SELECT * FROM users WHERE email = '$email_safe'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $login_error = "Wrong password!";
        }
    } else {
        $login_error = "User not found!";
    }
}

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flood Relief Management System - Home & Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .split-layout {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: flex-start;
            margin-bottom: 50px;
            margin-top: 30px;
        }

        .hero-content {
            flex: 1 1 500px; 
        }

        .hero-title {
            font-size: 3rem;
            color: var(--primary-hover, #0284c7);
            margin-bottom: 20px;
            line-height: 1.1;
            font-weight: 700;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-muted, #64748b);
            margin-bottom: 30px;
            font-weight: 400;
        }

        .login-container {
            flex: 1 1 400px; 
        }

        .login-container form {
            margin: 0;
            width: 100%;
            max-width: none; 
        }

        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 12px 15px;
            border-radius: var(--radius-sm, 4px);
            margin-bottom: 20px;
            font-size: 0.95rem;
            font-weight: 500;
            border-left: 4px solid #ef4444;
            display: flex;
            align-items: center;
        }
        .error-message::before {
            content: '⚠️';
            margin-right: 10px;
        }

        .welcome-box {
             background: var(--surface-color, #ffffff);
             padding: 30px;
             border-radius: var(--radius-lg, 8px);
             border-left: 5px solid var(--success-color, #10b981);
             box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            margin-top: 60px;
            text-align: center;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
            margin-bottom: 60px;
        }

        .gallery-item {
            position: relative;
            border-radius: var(--radius-lg, 8px);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 5px solid white;
            transition: all 0.4s ease;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .gallery-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(15, 23, 42, 0.8); 
            color: white;
            padding: 15px;
            font-size: 0.95rem;
            font-weight: 500;
            transform: translateY(100%); 
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-caption {
            transform: translateY(0); 
        }
       
       
    </style>
</head>
<body>

<div class="split-layout">
    <div class="hero-content">
        <h1 class="hero-title">Flood Relief Management System</h1>
        <p class="hero-subtitle">Providing rapid assistance, coordinating volunteers, and managing resources for communities affected by severe flooding. Together, we rebuild hope.</p>

        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="welcome-box">
                <h2 style="margin-bottom: 15px; border: none;">Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
                <p style="margin-bottom: 20px; color: var(--text-muted);">You are currently logged in. Access your dashboard to manage requests or view status updates.</p>
                <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'admin_dashboard.php' : 'dashboard.php'; ?>"
                   style="display: inline-block; background: var(--primary-color, #0ea5e9); color: white; padding: 12px 24px; border-radius: 6px; font-weight: 600; box-shadow: 0 4px 14px rgba(14, 165, 233, 0.4);">
                   Go to Dashboard
                </a>
            </div>
        <?php else: ?>
            <p style="color: var(--text-muted);">Please login to access the system to request aid, or register as a new user or volunteer.</p>
        <?php endif; ?>
    </div>

    <?php if(!isset($_SESSION['user_id'])): ?>
    <div class="login-container">
        <form method="POST" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <h2 style="margin-top: 0; border-bottom: none; color: var(--primary-hover, #0284c7); text-align: center;">Login to Account</h2>

            <?php if(!empty($login_error)): ?>
                <div class="error-message">
                    <?php echo $login_error; ?>
                </div>
            <?php endif; ?>

            <label for="email" style="font-weight: 600; color: #333; display: block; margin-bottom: 5px;">Email Address</label>
            <input type="email" name="email" id="email" required placeholder="name@example.com" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">

            <label for="password" style="font-weight: 600; color: #333; display: block; margin-bottom: 5px;">Password</label>
            <input type="password" name="password" id="password" required placeholder="Enter your password" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">

            <button type="submit" name="login" style="width: 100%; padding: 12px; background-color: #0ea5e9; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1rem;">Sign In</button>

            <p style="text-align: center; margin-top: 25px; font-size: 0.95rem; color: #64748b;">
                New here? <a href="register.php" style="font-weight: 600; color: #0ea5e9; text-decoration: none;">Create an account</a>
            </p>
        </form>
    </div>
    <?php endif; ?>
</div>

<div class="section-header">
    <h2> On The Ground: Relief Efforts</h2>
    <p style="color: #64748b; max-width: 600px; margin: 0 auto;">Witnessing the impact of the floods and the dedicated efforts of our teams and volunteers delivering aid.</p>
</div>

<div class="image-gallery">
    <div class="gallery-item">
        <img src="Photo 01.jpg" alt="Flooded streets showing severe water levels" class="gallery-img">
        <div class="gallery-caption">Severe flooding affecting local infrastructure.</div>
    </div>

    <div class="gallery-item">
        <img src="Photo 02.jpg" alt="Volunteers distributing relief supplies" class="gallery-img">
        <div class="gallery-caption">Volunteers distributing vital clean water and food.</div>
    </div>

    <div class="gallery-item">
        <img src="Photo 03.jpg" alt="Rescue boat operation in progress" class="gallery-img">
        <div class="gallery-caption">Emergency rescue boat operations underway.</div>
    </div>
</div>

<footer class="site-footer">
    <div class="footer-container">
        
        <div class="footer-section">
            <h3>Flood Relief System</h3>
            <p>Dedicated to coordinating rapid response, managing volunteer efforts, and distributing life-saving resources to communities affected by severe flooding. Your safety is our top priority.</p>
        </div>

        <div class="footer-section">
            <h3>Emergency Hotlines</h3>
            <ul>
                <li>Disaster Management Center: <span class="emergency-number">117</span></li>
                <li>Emergency Police: <span class="emergency-number">119</span></li>
                <li>Ambulance Service: <span class="emergency-number">1990</span></li>
                <li>Fire & Rescue: <span class="emergency-number">110</span></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Need further assistance? Reach out to our development team directly.</p>
            <ul style="margin-top: 15px;">
                <li>📞 <a href="tel:0784547868" style="margin-left: 10px;">0784547868</a></li>
                <li>✉️ <a href="mailto:floodreliefdeveloper@gmail.com" style="margin-left: 10px;">floodreliefdeveloper@gmail.com</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> Flood Relief Management System. All rights reserved.</p>
    </div>
</footer>

</body>
</html>