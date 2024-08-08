<?php
$servername = "localhost";
$username = "host";
$password = "";
$dbname = "mechaniclink1";

// Create connection
$conn = new mysqli($localhost, $root,  $password, $MechanicLink1);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND role = '$role'";
    $result = $conn->query($MySQL);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful!";
            // Start session, set session variables, etc.
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username or role.";
    }
}

$conn->close();