<?php
include('../assets/include/db.php');

// Function to check video access and progress
function checkVideoAccess($student_id, $video_id) {
    global $conn;
    $sql = "SELECT start_date, progress FROM video_access WHERE student_id = ? AND video_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $student_id, $video_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $start_date = new DateTime($row['start_date']);
        $current_date = new DateTime();
        $interval = $start_date->diff($current_date);
        $days_passed = $interval->days;

        if ($days_passed > 3) {
            // Reset progress if more than 3 days have passed
            $sql_update = "UPDATE video_access SET progress = 0, start_date = NOW() WHERE student_id = ? AND video_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ii", $student_id, $video_id);
            $stmt_update->execute();
            return 0; // Return 0% progress
        } else {
            return $row['progress']; // Return current progress
        }
    } else {
        // If no record exists, create a new access record
        $sql_insert = "INSERT INTO video_access (student_id, video_id, start_date, progress) VALUES (?, ?, NOW(), 0)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $student_id, $video_id);
        $stmt_insert->execute();
        return 0; // Return 0% progress
    }
}

// Function to display video and track progress
function displayVideo($student_id, $video_id) {
    global $conn; // Ensure $conn is accessible within this function scope
    $progress = checkVideoAccess($student_id, $video_id);
    $sql = "SELECT file_path FROM videos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $video_url = $result->fetch_assoc()['file_path'];

    echo "<video id='studentVideo' width='320' height='240' controls>";
    echo "<source src='$video_url' type='video/mp4'>";
    echo "Your browser does not support the video tag.";
    echo "</video>";
    echo "<script>";
    echo "var video = document.getElementById('studentVideo');";
    echo "video.currentTime = video.duration * ($progress / 100);";
    echo "video.addEventListener('timeupdate', function() {";
    echo "    var newProgress = (video.currentTime / video.duration) * 100;";
    echo "    // Update progress in the database";
    echo "    var xhr = new XMLHttpRequest();";
    echo "    xhr.open('POST', 'update_progress.php', true);";
    echo "    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');";
    echo "    xhr.send('student_id=' + $student_id + '&video_id=' + $video_id + '&progress=' + newProgress);";
    echo "});";
    echo "</script>";
}

// Example usage (student_id and video_id should be dynamically set based on context)
$student_id = 1; // This should be the actual student ID
$video_id = 1; // This should be the actual video ID
displayVideo($student_id, $video_id);
?>