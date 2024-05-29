<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include './includes/config.php';
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
//     header("location:../login.php");
//     exit;
// }
$msg = ""; // Initialize message variable

if (isset($_POST['submit'])) {
    $name = $_POST["title"];
    $total = $_POST["total"];
    $right = $_POST["right_mark"];
    $wrong = $_POST["wrong"];
    $subject_id = $_POST["sub_id"];
    $module_id = $_POST["module_id"];

    $sql = "INSERT INTO quiz (title, module_id, sub_id, total, `right_mark`, `wrong`) VALUES (:title, :module_id, :sub_id, :total, :right_mark, :wrong)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':title', $name, PDO::PARAM_STR);
    $query->bindParam(':module_id', $module_id, PDO::PARAM_STR);
    $query->bindParam(':sub_id', $subject_id, PDO::PARAM_STR);
    $query->bindParam(':total', $total, PDO::PARAM_INT);
    $query->bindParam(':right_mark', $right, PDO::PARAM_INT);
    $query->bindParam(':wrong', $wrong, PDO::PARAM_INT);

    if ($query->execute()) {
        $quiz_id = $dbh->lastInsertId();
        switch ($subject_id) {
            case 1:
                header("Location:./exam/add_li_exam.php?subject_id=" . $subject_id . "&quiz_id=" . $quiz_id .  "&total=" . $total);
                break;
            case 2:
                header("Location:./exam/add_wr_exam.php?subject_id=" . $subject_id . "&quiz_id=" . $quiz_id .  "&total=" . $total);
                break;
            case 3:
                header("Location:./exam/add_re_exam.php?subject_id=" . $subject_id . "&quiz_id=" . $quiz_id .  "&total=" . $total);
                break;
            case 4:
                header("Location:./exam/add_sp_exam.php?subject_id=" . $subject_id . "&quiz_id=" . $quiz_id .  "&total=" . $total);
                break;
            default:
                $msg = "Error adding quiz details. Please try again.";
                break;
        }
        exit;
    } else {
        $msg = "Error adding quiz details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Quiz Details</title>

    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">

    <script src="js/modernizr/modernizr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                <h2 class="title">Add Quiz Details</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Quiz</li>
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
                                                <h5>Add Quiz Details</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } ?>
                                            <form method="post">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Quiz Title:</label>
                                                    <input type="text" name="title" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="module" class="control-label">Module :</label>
                                                    <select name="module_id" class="form-control" id="default" required="required">
                                                        <option value="">Select Module</option>
                                                        <?php
                                                        $sql = "SELECT * from module";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <option value="<?php echo htmlentities($result->module_id); ?>"><?php echo htmlentities($result->module_name); ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="subject" class="control-label">Subject :</label>
                                                    <select name="sub_id" class="form-control" id="default" required="required">
                                                        <option value="">Select Subject</option>
                                                        <?php
                                                        $sql = "SELECT * from subject";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <option value="<?php echo htmlentities($result->sub_id); ?>"><?php echo htmlentities($result->sub_name); ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="total" class="control-label">Total Number of Questions:</label>
                                                    <input type="number" name="total" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="right_mark" class="control-label">Marks on Right Answer:</label>
                                                    <input type="number" name="right_mark" class="form-control" min="0" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="wrong" class="control-label">Minus Marks on Wrong Answer (without sign):</label>
                                                    <input type="number" name="wrong" class="form-control" min="0" required>
                                                </div>
                                                <div class="form-group">
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