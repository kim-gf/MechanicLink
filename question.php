<?php
include 'db_config.php';
session_start();

$question_id = $_GET['id'];

$query = "SELECT questions.*, users.username FROM questions JOIN users ON questions.user_id = users.id WHERE questions.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $question_id);
$stmt->execute();
$result = $stmt->get_result();
$question = $result->fetch_assoc();

if (!$question) {
    die("Question not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['body'])) {
    $body = $_POST['body'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO answers (question_id, user_id, body) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $question_id, $user_id, $body);

    if ($stmt->execute()) {
        header("Location: question.php?id=" . $question_id);
        exit();
    } else {
        $error_message = "Error posting answer: " . $conn->error;
    }
}

$query = "SELECT answers.*, users.username FROM answers JOIN users ON answers.user_id = users.id WHERE answers.question_id = ? ORDER BY answers.created_at ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $question_id);
$stmt->execute();
$result = $stmt->get_result();
$answers = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($question['title']); ?> - MechanicLink Support</title>
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
        <h2><?php echo htmlspecialchars($question['title']); ?></h2>
        <div class="question-detail">
            <p><?php echo htmlspecialchars($question['body']); ?></p>
            <p>Posted by <?php echo htmlspecialchars($question['username']); ?> on
                <?php echo $question['created_at']; ?></p>
        </div>
        <div class="answers-list">
            <h3>Answers</h3>
            <?php foreach ($answers as $answer): ?>
            <div class="answer-item">
                <p><?php echo htmlspecialchars($answer['body']); ?></p>
                <p>Answered by <?php echo htmlspecialchars($answer['username']); ?> on
                    <?php echo $answer['created_at']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="answer-form">
            <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="post" action="question.php?id=<?php echo $question['id']; ?>">
                <label for="body">Your Answer:</label>
                <textarea id="body" name="body" rows="5" required></textarea>
                <button type="submit">Post Answer</button>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 MechanicLink. All Rights Reserved.</p>
    </footer>
</body>

</html>