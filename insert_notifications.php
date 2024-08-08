<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mechaniclink1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example data
$userId = 1; // Example user ID
$title = "Appointment Reminder";
$message = "Your appointment with Mechanic XYZ is scheduled for tomorrow.";

$sql = "INSERT INTO notifications (user_id, title, message) VALUES ('$userId', '$title', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "New notification added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();