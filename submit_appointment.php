<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $mechanic = $_POST['mechanic'];

    // Here you can add your database connection and insertion logic
    // For example:
    // $conn = new mysqli($servername, $username, $password, $dbname);
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // $sql = "INSERT INTO appointments (name, email, phone, date, mechanic)
    //         VALUES ('$name', '$email', '$phone', '$date', '$mechanic')";
    // if ($conn->query($sql) === TRUE) {
    //     echo "New appointment booked successfully";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
    // $conn->close();

    echo "Appointment booked successfully!";
    echo "<br>Name: " . htmlspecialchars($name);
    echo "<br>Email: " . htmlspecialchars($email);
    echo "<br>Phone: " . htmlspecialchars($phone);
    echo "<br>Date: " . htmlspecialchars($date);
    echo "<br>Mechanic: " . htmlspecialchars($mechanic);
} else {
    echo "Invalid request.";
}