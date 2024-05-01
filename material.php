<?php
session_start();
require_once("./Header.php"); // Adjust the path as needed
require_once('./assets/include/db.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("location:./login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material</title>
    <link rel="stylesheet" href="path_to_css_file.css"> <!-- Link to CSS for styling if needed -->
</head>
<body>
    <div class="panel-body p-20">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Material Name</th>
                    <th>Description</th>
                    <th>Download Material</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM material";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['material_name']) . "</td>
                                <td>" . htmlspecialchars($row['description']) . "</td>
                                <td><a href='../Teacher/" . htmlspecialchars(urlencode($row['pdf_path'])) . "' download>Download</a></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No materials available.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>