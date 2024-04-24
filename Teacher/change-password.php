<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the session variable is set and not empty
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("location:../login.php");
    exit;
} else {
    $msg = "";
    $error = "";
    $teacherEmail = $teacher['email'];

    // Debugging: Check if the email session variable is set
    if(isset($_SESSION['teacher_email'])) {
    // Retrieve teacher's profile information
    $email = isset($_SESSION['teacher_email']) ? trim($_SESSION['teacher_email']) : '';
    $sql = "SELECT teacher_name, email FROM teacher WHERE email=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $teacher = $query->fetch(PDO::FETCH_ASSOC);
    $teacherName = $teacher['teacher_name'];
    $teacherEmail = $teacher['email'];

    if (isset($_POST['submit'])) {
        $password = $_POST['password'];
        $newpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];
        $email = isset($_SESSION['teacher_email']) ? trim($_SESSION['teacher_email']) : ''; // Trim the email
        $sql = "SELECT password FROM teacher WHERE email=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($results) {
            $storedPassword = $results[0]->password;

            // Check if the entered password matches the stored password
            if ($password === $storedPassword) {
                if ($newpassword === $confirmpassword) {
                    $con = "UPDATE teacher SET password=:newpassword WHERE email=:email";
                    $chngpwd1 = $dbh->prepare($con);
                    $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
                    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
                    $chngpwd1->execute();
                    $msg = "Your password has been successfully changed";
                } else {
                    $error = "New Password and Confirm Password do not match";
                }
            } else {
                $error = "Your current password is wrong";
            }
        } else {
            $error = "No user found with this email";
        }
    }
    } else {
        echo "Email session variable is NOT set.";
    }
?>

<!-- Your HTML code goes here -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher change password</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match  !!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
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
                                <h2 class="title">Teacher Change Password</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Teacher change password</li>
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
                                                <h5>Teacher Change Password</h5>
                                            </div>
                                        </div>
                                        <!-- Display teacher profile -->
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label>Teacher Name:</label>
                                                <p><?php echo htmlentities($teacherName); ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Email:</label>
                                                <p><?php echo htmlentities($teacherEmail); ?></p>
                                            </div>
                                        </div>
                                        <!-- Display error or success message -->
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } else if ($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <!-- Change password form -->
                                        <div class="panel-body">
                                            <form name="chngpwd" method="post" \ onSubmit="return valid();">
                                                <div class="form-group has-success">
                                                    <label for="success" class="control-label">Current Password (Email: <?php echo htmlentities($teacherEmail); ?>)</label>
                                                    <div class="">
                                                        <input type="password" name="password" class="form-control" required="required" id="success">
                                                    </div>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="success" class="control-label">New Password</label>
                                                    <div class="">
                                                        <input type="password" name="newpassword" required="required" class="form-control" id="success">
                                                    </div>
                                                </div>
                                                <div class="form-group has-success">
                                                    <label for="success" class="control-label">Confirm Password</label>
                                                    <div class="">
                                                        <input type="password" name="confirmpassword" class="form-control" required="required" id="success">
                                                    </div>
                                                </div>
                                                <div class="form-group has-success">
                                                    <div class="">
                                                        <button type="submit" name="submit" class="btn btn-success btn-labeled">Change
                                                            <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                                                        </button>
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
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>



    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>
<?php } ?>