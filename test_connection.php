<?php
include 'db_config.php';

$sql = "SELECT DATABASE()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Connected to database: " . $row["DATABASE()"];
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();