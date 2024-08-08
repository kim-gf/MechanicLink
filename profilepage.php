<?php
include 'db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: sign_in.php");
    exit();
}

$is_mechanic = isset($_SESSION['is_mechanic']) && $_SESSION['is_mechanic'];
$user_id = $_SESSION['user_id'];

if ($is_mechanic) {
    $query = "SELECT * FROM mechanics WHERE user_id = ?";
} else {
    $query = "SELECT * FROM users WHERE id = ?";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

if (!$user_data) {
    die("User data not found. Please make sure you are logged in and have a profile.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    
    if ($is_mechanic) {
        $specialization = $_POST['specialization'];
        $update_query = "UPDATE mechanics SET name = ?, email = ?, phone = ?, bio = ?, specialization = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("sssssi", $name, $email, $phone, $bio, $specialization, $user_id);
    } else {
        $update_query = "UPDATE users SET name = ?, email = ?, phone = ?, bio = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssssi", $name, $email, $phone, $bio, $user_id);
    }

    if ($update_stmt->execute()) {
        $_SESSION['message'] = "Profile updated successfully.";
        header("Location: profilepage.php");
        exit();
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page - MechanicLink</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="#" class="logo">MechanicLink</a>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profilepage.php">Profile</a></li>
                    <li><a href="appointment.php">Appointment</a></li>
                    <li><a href="mechanic-profile.php">Mechanics</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                    <li><a href="sign_in.php">Sign in/Sign up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <h2>Profile Page</h2>
        <?php if (isset($_SESSION['message'])): ?>
        <p class="success-message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <div class="profile-form">
            <form method="post" action="profilepage.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>"
                    required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>"
                    required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>"
                    required>

                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" rows="4"
                    required><?php echo htmlspecialchars($user_data['bio']); ?></textarea>

                <?php if ($is_mechanic): ?>
                <label for="specialization">Specialization:</label>
                <input type="text" id="specialization" name="specialization"
                    value="<?php echo htmlspecialchars($user_data['specialization']); ?>" required>
                <?php endif; ?>

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 MechanicLink. All Rights Reserved.</p>
    </footer>
</body>

</html>