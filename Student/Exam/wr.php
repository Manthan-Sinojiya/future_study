<?php
// Include database configuration
require_once '../includes/db.php'; // Use require_once to ensure the script stops if the file is missing

// Improved database connection using PDO instead of mysqli for better error handling and prepared statements
try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the writing quiz prompt from the database using a prepared statement
    $stmt = $conn->prepare("SELECT id, prompt, word_limit FROM writing_quiz ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $prompt = $result['prompt'];
        $word_limit = $result['word_limit'];
    } else {
        echo "No writing quiz available.";
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
    <title>Writing Quiz</title>
    <style>
        textarea {
            width: 100%;
            height: 150px;
            margin-top: 10px;
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
        <h1>Writing Quiz</h1>
        <?php if (isset($prompt)): ?>
            <p><?php echo htmlspecialchars($prompt); ?></p>
            <textarea id="response" maxlength="<?php echo $word_limit; ?>"></textarea>
            <button onclick="submitResponse()">Submit</button>
            <p id="wordCount">Word Limit: <?php echo $word_limit; ?></p>
        <?php else: ?>
            <p>No quiz available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>

    <script>
        function submitResponse() {
            var response = document.getElementById('response').value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "submit_response.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('Response submitted successfully!');
                    document.getElementById('response').value = ''; // Clear the textarea
                }
            };
            xhr.send("response=" + encodeURIComponent(response));
        }
    </script>
</body>
</html>
