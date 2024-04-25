<?php
// Improved code for video.php in the Teacher section
session_start();

// Redirect to login if not logged in as a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php');
    exit();
}

// Include database connection
include('../assets/include/db.php');

// Function to get video details from the database
function getVideoDetails($video_id) {
    global $conn;
    $sql = "SELECT title, description, file_path FROM videos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0 ? $result->fetch_assoc() : false;
}

// Function to update video details in the database
function updateVideoDetails($video_id, $title, $description) {
    global $conn;
    $sql = "UPDATE videos SET title = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $description, $video_id);
    if ($stmt->execute()) {
        echo "Video details updated successfully.";
    } else {
        echo "Error updating video details: " . $conn->error;
    }
}

// Function to upload a video
function uploadVideo($file, $description) {
    $target_dir = "../uploads/videos/";
    $target_file = $target_dir . basename($file["name"]);
    $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Validate video file
    if (isset($_POST["submit"])) {
        $check = getimagesize($file["tmp_name"]);
        $uploadOk = $check !== false ? 1 : 0;
        echo $uploadOk ? "File is a video - " . $check["mime"] . "." : "File is not a video.";
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedTypes = ['mp4', 'avi', 'mov', '3gp', 'mpeg'];
    if (!in_array($videoFileType, $allowedTypes)) {
        echo "Sorry, only MP4, AVI, MOV, 3GP & MPEG files are allowed.";
        $uploadOk = 0;
    }

    // Attempt to upload file if validation passed
    if ($uploadOk) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
            $sql = "INSERT INTO videos (filename, description) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", htmlspecialchars(basename($file["name"])), $description);
            if ($stmt->execute()) {
                echo "Video description saved successfully.";
            } else {
                echo "Error saving video description: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, your file was not uploaded.";
    }
}

// Function to add a video lecture
function addVideoLecture($video_url, $video_name, $video_description) {
    global $conn;
    $sql = "INSERT INTO video_lectures (url, name, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sss", $video_url, $video_name, $video_description);
        $stmt->execute();
        echo $stmt->affected_rows > 0 ? '<script>alert("Video lecture added successfully!");</script>' : '<script>alert("Error adding video lecture.");</script>';
        $stmt->close();
    } else {
        echo '<script>alert("Database error: could not prepare statement.");</script>';
    }
}

// Function to update a video lecture
function updateVideoLecture($video_id, $video_url, $video_name, $video_description) {
    global $conn;
    $sql = "UPDATE video_lectures SET url = ?, name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssi", $video_url, $video_name, $video_description, $video_id);
        $stmt->execute();
        echo $stmt->affected_rows > 0 ? '<script>alert("Video lecture updated successfully!");</script>' : '<script>alert("Error updating video lecture.");</script>';
        $stmt->close();
    } else {
        echo '<script>alert("Database error: could not prepare statement.");</script>';
    }
}

// Function to delete a video lecture
function deleteVideoLecture($video_id) {
    global $conn;
    $sql = "DELETE FROM video_lectures WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $video_id);
        $stmt->execute();
        echo $stmt->affected_rows > 0 ? '<script>alert("Video lecture deleted successfully!");</script>' : '<script>alert("Error deleting video lecture.");</script>';
        $stmt->close();
    } else {
        echo '<script>alert("Database error: could not prepare statement.");</script>';
    }
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['file'])) {
        uploadVideo($_FILES["videoFile"], $_POST["description"]);
    } elseif (isset($_POST['add'])) {
        addVideoLecture($_POST['video_url'] ?? '', $_POST['video_name'] ?? '', $_POST['video_description'] ?? '');
    } elseif (isset($_POST['update'])) {
        updateVideoLecture($_POST['video_id'] ?? 0, $_POST['video_url'] ?? '', $_POST['video_name'] ?? '', $_POST['video_description'] ?? '');
    } elseif (isset($_POST['delete'])) {
        deleteVideoLecture($_POST['video_id'] ?? 0);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Video Lectures</title>
</head>

<body>
    <h1>Manage Video Lectures</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="videoFile">Select video to upload:</label>
        <input type="file" name="videoFile" id="videoFile" required>
        <input type="hidden" id="video_id" name="video_id">
        <label for="video_url">Video URL:</label>
        <input type="text" id="video_url" name="video_url" required><br>
        <label for="video_name">Video Name:</label>
        <input type="text" id="video_name" name="video_name" required><br>
        <label for="video_description">Video Description:</label>
        <textarea id="video_description" name="video_description" required></textarea><br>
        <button type="submit" name="add">Add Video</button>
        <button type="submit" name="update">Update Video</button>
        <button type="submit" name="delete">Delete Video</button>
    </form>
</body>

</html>
