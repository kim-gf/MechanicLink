<?php
include 'db_config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    die('Please log in to book a service.');
}

// Initialize variables
$service_id = null;
$service = null;
$mechanics_result = null;

// Handle booking request
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Fetch service details
    $sql = "SELECT name, description FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $service_id);
    $stmt->execute();
    $service = $stmt->get_result()->fetch_assoc();

    // Debugging: Check if service details are fetched
    if (!$service) {
        die('Service not found.');
    }

    // Fetch available mechanics
    $sql = "SELECT id, name FROM mechanics";
    $mechanics_result = $conn->query($sql);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['service_id'])) {
    $user_id = $_SESSION['username']; // Ensure 'username' is the correct session variable
    $service_id = $_POST['service_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $problem = $_POST['problem'];
    $mechanic_id = $_POST['mechanic_id'];
    $appointment_date = date('Y-m-d'); // Current date
    $appointment_time = date('H:i:s');  // Current time

    $sql = "INSERT INTO appointments (user_id, mechanic_id, service_id, name, email, location, problem, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiissssss', $user_id, $mechanic_id, $service_id, $name, $email, $location, $problem, $appointment_date, $appointment_time);

    if ($stmt->execute()) {
        $appointment_success = 'Service booked successfully!';
    } else {
        $appointment_error = 'Failed to book service. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - MechanicLink</title>
    <link rel="stylesheet" href="/css/services.css">
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
                    <li><a href="sign_in.php">Sign In/Sign up</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                    <li><a href="sign_in.php">Sign in/Sign up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <div class="services-container">
        <h2>Available Services</h2>

        <?php if (isset($appointment_success)): ?>
        <div class="success"><?php echo htmlspecialchars($appointment_success); ?></div>
        <?php endif; ?>
        <?php if (isset($appointment_error)): ?>
        <div class="error"><?php echo htmlspecialchars($appointment_error); ?></div>
        <?php endif; ?>

        <?php if ($service): ?>
        <div class="booking-form">
            <h3><?php echo htmlspecialchars($service['name']); ?></h3>
            <p><?php echo htmlspecialchars($service['description']); ?></p>
            <form method="post" action="Garage.php">
                <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">

                <label for="name">Your Name:</label>
                <input type="text" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" name="email" required>

                <label for="location">Your Location:</label>
                <input type="text" name="location" required>

                <label for="problem">Describe Your Problem:</label>
                <textarea name="problem" required></textarea>

                <label for="mechanic_id">Select Mechanic:</label>
                <select name="mechanic_id" required>
                    <option value="">Select a mechanic</option>
                    <?php while ($mechanic = $mechanics_result->fetch_assoc()): ?>
                    <option value="<?php echo $mechanic['id']; ?>">
                        <?php echo htmlspecialchars($mechanic['name']); ?>
                    </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit">Submit Booking</button>
            </form>
        </div>
        <?php else: ?>
        <div class="services-list">
            <?php
            // Define the services with their details and images
            $services = [
                ['id' => 1, 'name' => 'Oil Change', 'description' => 'Complete oil change with filter replacement', 'image' => 'images/oil change.jpg'],
                ['id' => 2, 'name' => 'Brake Inspection', 'description' => 'Comprehensive brake inspection and repair', 'image' => 'images/break service.jpg'],
                ['id' => 3, 'name' => 'Engine Repair', 'description' => 'Full engine tune-up and performance check', 'image' => 'images/engine repair.jpg'],
                ['id' => 4, 'name' => 'Transmission Repair', 'description' => 'Repair or replacement of transmission components', 'image' => 'images/transmission repair.jpg'],
                ['id' => 5, 'name' => 'AC Repair', 'description' => 'Diagnosis and repair of air conditioning system', 'image' => 'images/AC.jpg'],
                ['id' => 6, 'name' => 'Alignment', 'description' => 'Wheel alignment service', 'image' => 'images/alignment.jpg'],
                ['id' => 7, 'name' => 'Tire Repair', 'description' => 'Repair or replacement of tires', 'image' => 'images/tire rotation.jpg'],
                ['id' => 8, 'name' => 'Diagnostic', 'description' => 'Diagnostic check of vehicle systems', 'image' => 'images/diagonistic.jpg'],
                ['id' => 9, 'name' => 'Suspension Repair', 'description' => 'Repair or replacement of suspension components', 'image' => 'images/suspension repair.jpg'],
                ['id' => 10, 'name' => 'Battery Replacement', 'description' => 'Replacement of vehicle battery', 'image' => 'images/battery replacement.jpg']
            ];

            // Display the services
            foreach ($services as $service): ?>
            <div class="service">
                <img src="<?php echo htmlspecialchars($service['image']); ?>"
                    alt="<?php echo htmlspecialchars($service['name']); ?>">
                <div class="service-description">
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                    <a href="Garage.php?service_id=<?php echo $service['id']; ?>">Book Now</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</body>

</html>