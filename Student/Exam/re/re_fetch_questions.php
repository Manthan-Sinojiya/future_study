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

$sql = "SELECT id, question, option1, option2, option3, option4, img_path, text FROM re_quiz";
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $conn->error]));
}

$questions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = [
            'id' => $row['id'],
            'question' => htmlspecialchars($row['question']),
            'option1' => htmlspecialchars($row['option1']),
            'option2' => htmlspecialchars($row['option2']),
            'option3' => htmlspecialchars($row['option3']),
            'option4' => htmlspecialchars($row['option4']),
            'img_path' => htmlspecialchars($row['img_path']),
            'text' => htmlspecialchars($row['text'])
        ];
    }
} else {
    die(json_encode(['error' => 'No questions found']));
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($questions);
?>
