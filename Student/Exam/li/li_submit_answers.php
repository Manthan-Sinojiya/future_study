<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "future_study_hub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$answers = $data['answers'];

$totalQuestions = count($answers);
$correctAnswers = 0;

foreach ($answers as $questionId => $answer) {
    $stmt = $conn->prepare("SELECT correct_answer FROM li_quiz WHERE id = ?");
    $stmt->bind_param("i", $questionId);
    $stmt->execute();
    $stmt->bind_result($correctAnswer);
    $stmt->fetch();
    $stmt->close();

    if ($answer == $correctAnswer) {
        $correctAnswers++;
    }
}

$conn->close();

$score = ($correctAnswers / $totalQuestions) * 100;
$response = ['status' => 'success', 'message' => 'Answers submitted successfully', 'score' => $score];

header('Content-Type: application/json');
echo json_encode($response);
?>
