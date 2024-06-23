<?php
session_start();
include 'includes/config.php';

// Validate the video path
if (!isset($_GET['video']) || empty($_GET['video'])) {
    header("location:index.php");
    exit;
}

// Assuming video path is passed through GET parameter (ensure to sanitize and validate this in production)
$videoPath = urldecode($_GET['video']);

// Fetch video details from database based on video path
$sql_video_details = "SELECT video_title, description, video_path FROM videos WHERE video_path = :video_path";
$query_video_details = $dbh->prepare($sql_video_details);
$query_video_details->bindParam(':video_path', $videoPath);
$query_video_details->execute();
$videoDetails = $query_video_details->fetch(PDO::FETCH_ASSOC);

// If no video details found, redirect to index.php
if (!$videoDetails) {
    header("location:index.php");
    exit;
}

$videoTitle = $videoDetails['video_title'];
$videoDescription = $videoDetails['description'];
$videoPath = $videoDetails['video_path']; // Ensure the correct video_path is fetched

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Video - Future Study Hub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            padding: 20px;
        }
        .video-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .video-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .video-description {
            margin-bottom: 20px;
        }
        .video-player {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include("includes/Header.php"); ?>

    <div class="container video-container">
        <div class="text-center">
            <h2 class="video-title"><?php echo htmlentities($videoTitle); ?></h2>
            <p class="video-description"><?php echo htmlentities($videoDescription); ?></p>
        </div>
        
        <div class="embed-responsive embed-responsive-16by9">
            <video controls class="video-player">
                <source src="../Teacher/<?php echo htmlentities($videoPath); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    <?php include("includes/Footer.php"); ?>
</body>
</html>
