<?php
// Include database configuration
require_once '../includes/db.php'; // Use require_once to ensure the script stops if the file is missing
try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch the reading quiz data from the database
$query = "SELECT * FROM reading_quiz ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

$reading_quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($reading_quizzes)) {
    echo "No reading quizzes available.";
}

$conn = null; // Close connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reading Quiz</title>
    <style>
        .passage {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .question {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        </style>
</head>
<body>
    <div id="quiz-container">
        <h1>Reading Quiz</h1>
        <?php if (!empty($reading_quizzes)): ?>
            <?php foreach ($reading_quizzes as $quiz): ?>
                <div class="passage">
                    <p><?= htmlspecialchars($quiz['passage']); ?></p>
                </div>
                <?php foreach (json_decode($quiz['questions'], true) as $question): ?>
                    <div class="question">
                        <p><?= htmlspecialchars($question['text']); ?></p>
                        <?php foreach ($question['options'] as $option): ?>
                            <label>
                                <input type="radio" name="question<?= $question['id']; ?>" value="<?= htmlspecialchars($option); ?>">
                                <?= htmlspecialchars($option); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <button onclick="submitReadingAnswers()">Submit Answers</button>
        <?php else: ?>
            <p>No quizzes available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>

    <style>
        .passage {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .question {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
        <?php foreach ($reading_quizzes as $quiz): ?>
            <div class="passage">
                <p><?php echo htmlspecialchars($quiz['passage']); ?></p>
            </div>
            <?php foreach (json_decode($quiz['questions'], true) as $question): ?>
                <div class="question">
                    <p><?php echo htmlspecialchars($question['text']); ?></p>
                    <?php foreach ($question['options'] as $option): ?>
                        <label>
                            <input type="radio" name="question<?php echo $question['id']; ?>" value="<?php echo htmlspecialchars($option); ?>">
                            <?php echo htmlspecialchars($option); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <button onclick="submitReadingAnswers()">Submit Answers</button>
        
    <script>
        function submitReadingAnswers() {
            var answers = {};
            var quizzes = document.querySelectorAll('.question');
            quizzes.forEach(function(question, index) {
                var input = question.querySelector('input[type="radio"]:checked');
                if (input) {
                    answers['question' + index] = input.value;
                }
            });

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "submit_reading_answers.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('Answers submitted successfully!');
                }
            };
            xhr.send("answers=" + JSON.stringify(answers));
        }
        </script>
</body>
</html>

