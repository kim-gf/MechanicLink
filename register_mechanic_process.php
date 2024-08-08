<?php
// register_mechanic_process.php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $speciality = $_POST['speciality'];

    $sql = $conn->prepare("INSERT INTO Mechanic (FirstName, LastName, PhoneNumber, Email, Speciality) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $firstName, $lastName, $phoneNumber, $email, $speciality);

    if ($sql->execute() === TRUE) {
        echo "New mechanic registered successfully";
    } else {
        echo "Error: " . $sql->error;
    }

    $sql->close();
    $conn->close();
}