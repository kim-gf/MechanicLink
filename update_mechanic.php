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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a session or user ID to identify the mechanic
    session_start();
    $userId = $_SESSION['user']; // Adjust as needed
    
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $experience = $_POST['experience'];
    $services = $_POST['services'];
    $specialization = $_POST['specialization'];
    $certifications = $_POST['certifications'];

    $sql = "UPDATE mechanics SET
            name = '$name',
            phone = '$phone',
            location = '$location',
            experience = '$experience',
            services = '$services',
            specialization = '$specialization',
            certifications = '$certifications'
            WHERE user_id = '$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();