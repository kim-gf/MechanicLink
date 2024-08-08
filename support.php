<?php
include 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'], $_POST['body'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO questions (user_id, title, body) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $body);

    if ($stmt->execute()) {
        header("Location: support.php");
        exit();
    } else {
        $error_message = "Error posting question: " . $conn->error;
    }
}

$query = "SELECT questions.*, users.username FROM questions JOIN users ON questions.user_id = users.id ORDER BY questions.created_at DESC";
$result = $conn->query($query);
$questions = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - MechanicLink</title>
    <link rel="stylesheet" href="css/support.css">
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
                    <li><a href="support.php">Support</a></li>
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
        <h2>Support</h2>
        <div class="question-form">
            <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="post" action="support.php">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                <label for="body">Body:</label>
                <textarea id="body" name="body" rows="5" required></textarea>
                <button type="submit">Post Question</button>
            </form>
        </div>
        <div class="questions-list">
            <?php foreach ($questions as $question): ?>
            <div class="question-item">
                <h3><a
                        href="question.php?id=<?php echo $question['id']; ?>"><?php echo htmlspecialchars($question['title']); ?></a>
                </h3>
                <p><?php echo htmlspecialchars($question['body']); ?></p>
                <p>Posted by <?php echo htmlspecialchars($question['username']); ?> on
                    <?php echo $question['created_at']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 MechanicLink. All Rights Reserved.</p>
    </footer>
</body>

</html>