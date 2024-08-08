<?php
include 'db_config.php';

$sql = "SELECT id, username, email, role, user_type, created_at FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();

return $users;
?>