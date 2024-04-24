<?php
session_start();
include("./Header.php"); // Adjust the path as needed
include('./assets/include/db.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("location:./login.php");
    exit;
}
?>
<html>
<head>
    <title>Material</title>
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
                                <td>" . $row['material_name'] . "</td>
                                <td>" . $row['description'] . "</td>
                                <td><a href='../Teacher/" . urlencode($row['pdf_path']) . "'>Download</a></td>
                            </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>