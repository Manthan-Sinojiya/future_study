<?php
session_start();
include 'includes/config.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("location:../login.php");
    exit;
}

// Fetch unique topics with topic number, topic name, module name, and subject name from the database
$sql_topics = "SELECT DISTINCT v.topic_number, t.topic_name, m.module_name, s.sub_name 
            FROM videos v 
            LEFT JOIN topics t ON v.topic_number = t.topic_number
            LEFT JOIN module m ON v.module = m.module_id
            LEFT JOIN subject s ON v.subject = s.sub_id
            ORDER BY v.topic_number ASC";
$query_topics = $dbh->prepare($sql_topics);
$query_topics->execute();
$topics = $query_topics->fetchAll(PDO::FETCH_OBJ);

// Fetch all videos
$sql_videos = "SELECT video_id, video_title, description, topic_number, video_path, created_at 
            FROM videos ORDER BY topic_number ASC";
$query_videos = $dbh->prepare($sql_videos);
$query_videos->execute();
$videos = $query_videos->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video Lectures - Future Study Hub</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .video-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            background: #fff;
        }
        .video-table th, .video-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .video-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            cursor: pointer;
        }
        .video-table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .video-item {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .video-item:hover {
            background-color: #f0f0f0;
        }
        .video-player {
            width: 100%;
            margin-top: 20px;
        }
        .video-player video {
            width: 70%;
            outline: none;
        }
        .video-details-info {
            background-color: #f9f9f9;
            padding: 10px;
            margin-top: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .video-details-info h4,
        .video-details-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <?php include("includes/Header.php"); ?>

    <div class="container">
        <h1>Video Lectures</h1>

        <table class="video-table">
            <thead>
                <tr>
                    <th>Topic Number</th>
                    <th>Topic Name</th>
                    <th>Module Name</th>
                    <th>Subject Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topics as $topic) { ?>
                    <tr class="video-item" data-topic-number="<?php echo htmlentities($topic->topic_number); ?>">
                        <td><?php echo htmlentities($topic->topic_number); ?></td>
                        <td class="topic-name"><?php echo htmlentities($topic->topic_name); ?></td>
                        <td class="module-name"><?php echo isset($topic->module_name) ? htmlentities($topic->module_name) : ''; ?></td>
                        <td class="subject-name"><?php echo isset($topic->sub_name) ? htmlentities($topic->sub_name) : ''; ?></td>
                    </tr>
                    <tr class="video-details" id="details-<?php echo htmlentities($topic->topic_number); ?>" style="display:none;">
                        <td colspan="4">
                            <div class="video-list" id="videoList<?php echo $topic->topic_number; ?>">
                                <h3><?php echo htmlentities($topic->topic_name); ?></h3>
                                <ul>
                                    <?php foreach ($videos as $video) {
                                        if ($video->topic_number == $topic->topic_number) { ?>
                                            <li class="video-list-item" 
                                                data-video-path="<?php echo htmlentities($video->video_path); ?>"
                                                data-video-title="<?php echo htmlentities($video->video_title); ?>"
                                                data-video-description="<?php echo htmlentities($video->description); ?>"
                                                data-video-date="<?php echo htmlentities($video->created_at); ?>">
                                                <?php echo htmlentities($video->video_title); ?>
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                            </div>
                            <div class="video-player" id="player-<?php echo htmlentities($topic->topic_number); ?>">
                                <video controls>
                                    <source src="" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <h4 id="videoTitleDisplay"></h4>
                                <p id="videoDescriptionDisplay"></p>
                                <p id="videoDateDisplay"></p>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include("includes/Footer.php"); ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoItems = document.querySelectorAll('.video-item');
        const videoDetailsRows = document.querySelectorAll('.video-details');
        const videoListItems = document.querySelectorAll('.video-list-item');

        // Event listener for clicking on video table rows to show video lists
        videoItems.forEach(item => {
            const topicNumber = item.getAttribute('data-topic-number');
            const detailsRow = document.getElementById('details-' + topicNumber);
            const videoList = document.getElementById('videoList' + topicNumber);

            item.addEventListener('click', function() {
                // Hide all video detail rows first
                videoDetailsRows.forEach(row => row.style.display = 'none');
                // Show the video details row for the clicked topic
                detailsRow.style.display = 'table-row';
            });
        });

        // Event listener for video list items (to play video and update title and description display)
        videoListItems.forEach(item => {
            item.addEventListener('click', function() {
                const videoPath = this.getAttribute('data-video-path');
                const videoTitle = this.getAttribute('data-video-title');
                const videoDescription = this.getAttribute('data-video-description');
                const videoDate = this.getAttribute('data-video-date');
                const topicNumber = this.closest('.video-list').getAttribute('id').replace('videoList', '');
                const videoPlayer = document.querySelector('#player-' + topicNumber + ' video');
                const videoTitleDisplay = document.querySelector('#details-' + topicNumber + ' #videoTitleDisplay');
                const videoDescriptionDisplay = document.querySelector('#details-' + topicNumber + ' #videoDescriptionDisplay');
                const videoDateDisplay = document.querySelector('#details-' + topicNumber + ' #videoDateDisplay');

                // Hide all other video players
                document.querySelectorAll('.video-player video').forEach(player => {
                    player.pause();
                });

                // Set video source and play
                videoPlayer.querySelector('source').src = videoPath;
                videoPlayer.load();
                videoPlayer.play();

                // Update displayed video title, description, and date
                videoTitleDisplay.textContent = 'Title: ' + videoTitle;
                videoDescriptionDisplay.textContent = 'Description: ' + (videoDescription ? videoDescription : 'No description available');
                videoDateDisplay.textContent = 'Date: ' + (videoDate ? videoDate : 'Unknown date');
            });
        });
    });
</script>

</body>
</html>
