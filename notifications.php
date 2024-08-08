<?php
include 'db_config.php';
session_start();

// Example notification data
$notifications = [
    ["message" => "You have booked an appointment successfully!", "details" => "Service: Oil Change with John Doe on 2024-08-10 at 10:00 AM."],
    ["message" => "Your appointment has been rescheduled.", "details" => "New Schedule: Brake Service with Jane Smith on 2024-08-12 at 2:00 PM."],
    ["message" => "Your mechanic has left a new message.", "details" => "Message from Mike: Please bring your car in 15 minutes early for the engine repair appointment."]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - MechanicLink</title>
    <link rel="stylesheet" href="css/services.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="#" class="logo">MechanicLink</a>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profilepage.php">Profile</a></li>
                    <li><a href="appointment.php">Appointment</a></li>
                    <li><a href="mechanic-profile.php">Mechanics</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                    <li><a href="sign_in.php">Sign in/Sign up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <h2>Notifications</h2>
        <div class="notifications-grid">
            <?php foreach ($notifications as $notification): ?>
            <div class="notification-item">
                <h3><?php echo $notification['message']; ?></h3>
                <p><?php echo $notification['details']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
