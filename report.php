<?php
session_start();
include 'db_config.php';

// Initialize variables for query results
$appointments = [];
$services = [];

// Fetch appointments
$sql_appointments = "SELECT id, user_id, mechanic_id, appointment_date, service_type, status FROM appointments";
$result_appointments = $conn->query($sql_appointments);

if ($result_appointments->num_rows > 0) {
    while ($row = $result_appointments->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Fetch services
$sql_services = "SELECT id, user_id, mechanic_id, service_date, service_description FROM services";
$result_services = $conn->query($sql_services);

if ($result_services->num_rows > 0) {
    while ($row = $result_services->fetch_assoc()) {
        $services[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="header-container">
            <h1>MechanicLink Report</h1>
        </div>
    </header>

    <main>
        <div class="report-container">
            <h2>Appointments Report</h2>

            <?php if (!empty($appointments)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Mechanic ID</th>
                        <th>Appointment Date</th>
                        <th>Service Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['mechanic_id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['service_type']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No appointments found.</p>
            <?php endif; ?>

            <h2>Services Report</h2>

            <?php if (!empty($services)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Mechanic ID</th>
                        <th>Service Date</th>
                        <th>Service Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['id']); ?></td>
                        <td><?php echo htmlspecialchars($service['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($service['mechanic_id']); ?></td>
                        <td><?php echo htmlspecialchars($service['service_date']); ?></td>
                        <td><?php echo htmlspecialchars($service['service_description']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No services found.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2024 MechanicLink. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>