<?php
// Include database configuration
require_once '../includes/db.php'; // Use require_once to ensure the script stops if the file is missing

// Improved database connection using PDO instead of mysqli for better error handling and prepared statements
try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the speaking quiz prompt and audio from the database using a prepared statement
    $stmt = $conn->prepare("SELECT id, audio_url FROM speaking_quiz ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $audio_url = $row ? $row['audio_url'] : null;
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
    <title>Speaking Quiz</title>
    <style>
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="quiz-container">
        <h1>Speaking Quiz</h1>
        <?php if ($audio_url): ?>
            <audio id="audioPrompt" controls>
                <source src="<?php echo htmlspecialchars($audio_url); ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            <button id="recordBtn">Record</button>
            <button id="stopBtn" disabled>Stop</button>
            <button id="playbackBtn" disabled>Playback</button>
            <button id="submitBtn" disabled>Submit</button>
        <?php else: ?>
            <p>No speaking quiz available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>

    <script>
        let mediaRecorder;
        let audioBlob;
        let audioUrl;
        let audio = new Audio();

        document.getElementById('recordBtn').addEventListener('click', startRecording);
        document.getElementById('stopBtn').addEventListener('click', stopRecording);
        document.getElementById('playbackBtn').addEventListener('click', playBack);
        document.getElementById('submitBtn').addEventListener('click', submitAudio);

        function startRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();
                    mediaRecorder.ondataavailable = function(e) {
                        audioBlob = e.data;
                    };
                    document.getElementById('stopBtn').disabled = false;
                })
                .catch(err => console.error('Error accessing media devices.', err));
        }

        function stopRecording() {
            mediaRecorder.stop();
            document.getElementById('playbackBtn').disabled = false;
            document.getElementById('submitBtn').disabled = false;
        }

        function playBack() {
            if (audioBlob) {
                audioUrl = URL.createObjectURL(audioBlob);
                audio.src = audioUrl;
                audio.play();
            }
        }

        function submitAudio() {
            if (audioBlob) {
                let formData = new FormData();
                formData.append('audio', audioBlob);

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "submit_audio.php", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert('Audio submitted successfully!');
                    }
                };
                xhr.send(formData);
            }
        }
    </script>
</body>
</html>
