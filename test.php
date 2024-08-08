<?php
include 'db_config.php'; // Ensure this path is correct

if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Failed to connect to the database.";
}

$conn->close();