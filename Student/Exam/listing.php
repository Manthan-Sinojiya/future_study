<?php
// Include database configuration
require_once '../includes/db.php'; // Use require_once to ensure the script stops if the file is missing

// Improved database connection using PDO instead of mysqli for better error handling and prepared statements
try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the listening quiz data from the database using a prepared statement
    $stmt = $conn->prepare("SELECT * FROM listening_quiz ORDER BY id DESC");
    $stmt->execute();
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($quizzes)) {
        echo "No listening quizzes available.";
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listening Quiz</title>
    <style>
        .audio-control {
            margin-top: 10px;
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
        <h1>Listening Quiz</h1>
        <?php if (!empty($quizzes)): ?>
            <?php foreach ($quizzes as $quiz): ?>
                <div class="quiz">
                    <audio controls class="audio-control">
                        <source src="<?php echo htmlspecialchars($quiz['audio_url']); ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
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
                </div>
            <?php endforeach; ?>
            <button onclick="submitAnswers()">Submit Answers</button>
        <?php else: ?>
            <p>No quizzes available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>

    <script>
        function submitAnswers() {
            var answers = {};
            var quizzes = document.querySelectorAll('.quiz');
            quizzes.forEach(function(quiz, index) {
                var questions = quiz.querySelectorAll('.question');
                questions.forEach(function(question) {
                    var input = question.querySelector('input[type="radio"]:checked');
                    if (input) {
                        answers['question' + index] = input.value;
                    }
                });
            });

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "submit_listening_answers.php", true);
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
