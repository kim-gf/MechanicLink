<?php
include 'db_config.php';
session_start();

$appointment_error = '';
$appointment_success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mechanic_id = $_POST['mechanic_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $user_id = $_SESSION['user_id'];
    $service_type = $_POST['service_type'];
    $user_email = $_SESSION['user_email']; // Assuming you store user email in session
    
    $sql = "INSERT INTO appointments (user_id, mechanic_id, appointment_date, appointment_time, service_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('iisss', $user_id, $mechanic_id, $appointment_date, $appointment_time, $service_type);
    if ($stmt->execute()) {
        $appointment_success = 'Appointment booked successfully!';
        
        // Send confirmation email
        $to = $user_email;
        $subject = 'Appointment Confirmation - MechanicLink';
        $message = "Hello,\n\nYour appointment for $service_type has been booked successfully.\n\nDetails:\nMechanic ID: $mechanic_id\nDate: $appointment_date\nTime: $appointment_time\n\nThank you for choosing MechanicLink.";
        $headers = 'From: no-reply@mechaniclink.com';
        mail($to, $subject, $message, $headers);
    } else {
        $appointment_error = 'Failed to book appointment. Please try again.';
    }
    $stmt->close();
}

$sql = "SELECT id, name, specialization FROM mechanics";
$mechanics_result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - MechanicLink</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="#" class="logo">MechanicLink</a>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="appointment.php">Appointment</a></li>
                    <li><a href="mechanic-profile.php">Mechanics</a></li>
                    <li><a href="Garage.php">Services</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                    <li><a href="sign_in.php">Sign in/Sign up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <div class="form-container">
        <h2>Book an Appointment</h2>
        <?php if ($appointment_error): ?>
        <div class="error"><?php echo htmlspecialchars($appointment_error); ?></div>
        <?php endif; ?>
        <?php if ($appointment_success): ?>
        <div class="success"><?php echo htmlspecialchars($appointment_success); ?></div>
        <?php endif; ?>
        <form method="post" action="appointment.php">
            <label for="mechanic_id">Select Mechanic:</label>
            <select name="mechanic_id" required>
                <option value="">Select a mechanic</option>
                <?php while ($mechanic = $mechanics_result->fetch_assoc()): ?>
                <option value="<?php echo $mechanic['id']; ?>">
                    <?php echo htmlspecialchars($mechanic['name']) . " - " . htmlspecialchars($mechanic['specialization']); ?>
                </option>
                <?php endwhile; ?>
            </select>
            <label for="service_type">Service Type:</label>
            <input type="text" name="service_type" required>
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" name="appointment_date" required>
            <label for="appointment_time">Appointment Time:</label>
            <input type="time" name="appointment_time" required>
            <button type="submit">Book Appointment</button>
        </form>
    </div>
</body>

</html>