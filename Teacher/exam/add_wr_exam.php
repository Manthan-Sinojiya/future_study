<?php
session_start();
error_reporting(0);
include '../includes/db_connection.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("location:../login.php");
    exit;
}

$msg = ""; // Initialize message variable

if (isset($_POST['submit'])) {
    // Retrieve form data
    $question = $_POST["title"];
    $correct_answer = $_POST["correct_answer"];
    $option_a = $_POST["option1"];
    $option_b = $_POST["option2"];
    $option_c = $_POST["option3"];
    $option_d = $_POST["option4"];

    // Shuffle the options array
    $options = array($option_a, $option_b, $option_c, $option_d, $correct_answer);
    shuffle($options);

    // Insert question details into the database
    $sql = "INSERT INTO wr_quiz (title, correct_answer, option1, option2, option3, option4) 
            VALUES (:title, :correct_answer, :option1, :option2, :option3, :option4)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':title', $question, PDO::PARAM_STR);
    $query->bindParam(':correct_answer', $correct_answer, PDO::PARAM_STR);
    $query->bindParam(':option1', $options[0], PDO::PARAM_STR);
    $query->bindParam(':option2', $options[1], PDO::PARAM_STR);
    $query->bindParam(':option3', $options[2], PDO::PARAM_STR);
    $query->bindParam(':option4', $options[3], PDO::PARAM_STR);

    // Execute the query
    if ($query->execute()) {
        $msg = "Question added successfully!";
    } else {
        $msg = "Error adding question. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Exam Question</title>

    <link rel="stylesheet" href="./css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="./css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="./css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="./css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="./css/main.css" media="screen">

    <script src="js/modernizr/modernizr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#option_a, #option_b, #option_c, #option_d").on("keyup", function() {
                var options = [
                    $("#option_a").val(),
                    $("#option_b").val(),
                    $("#option_c").val(),
                    $("#option_d").val()
                ];
                var correctAnswer = $("#correct_answer").val();
                var selectOptions = '';
                options.forEach(function(option) {
                    selectOptions += '<option value="' + option + '">' + option + '</option>';
                });
                $("#correct_answer").html(selectOptions);
            });
        });
    </script>

</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Add Exam Question</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Exam Questions</a></li>
                                    <li class="active">Add Question</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Add Exam Question</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } ?>
                                            <form method="post">
                                                <div class="form-group has-success">
                                                    <label for="question" class="control-label">Question:</label>
                                                    <input type="text" name="question" class="form-control" required>
                                                </div>

                                                <div class="form-group has-success">
                                                    <label for="option_a" class="control-label">Option A:</label>
                                                    <input type="text" name="option1" id="option_a" class="form-control" required>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="option_b" class="control-label">Option B:</label>
                                                    <input type="text" name="option2" id="option_b" class="form-control" required>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="option_c" class="control-label">Option C:</label>
                                                    <input type="text" name="option3" id="option_c" class="form-control" required>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="option_d" class="control-label">Option D:</label>
                                                    <input type="text" name="option4" id="option_d" class="form-control" required>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="correct_answer" class="control-label">Correct Answer:</label>
                                                    <select name="correct_answer" id="correct_answer" class="form-control" required>
                                                        <!-- Options will be generated dynamically using JavaScript -->
                                                    </select>
                                                </div>
 
                                                <div class="form-group has-success">
                                                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
</body>

</html>