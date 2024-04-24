<?php
session_start();
error_reporting(0);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("location:../login.php");
    exit;
}

include('includes/config.php');

// Check if the form is being submitted
if (isset($_POST['submit'])) {
    $email = $_POST['email']; // Retrieve email from form data

    // Store email in session
    $_SESSION['teacher_email'] = $email;

    $teacher_name = $_POST['teacher_name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $gender = $_POST['gender'];
    $module_id = $_POST['module_id'];
    $dob = $_POST['dob'];
    $course_field = $_POST['course_field'];
    $hire_date = date("Y-m-d"); // Automatically set to current date

    // Generate random password
    $password = 'password';
    // Prepare and execute SQL query to insert teacher data into database
    $sql = "INSERT INTO teacher(teacher_name, email, contact_no, gender, dob, course_field, module_id, hire_date, password) 
    VALUES(:teacher_name, :email, :contact_no, :gender, :dob, :course_field, :module_id, :hire_date, :password)";
    $contact_no;
    $query = $dbh->prepare($sql);
    $query->bindParam(':teacher_name', $teacher_name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':contact_no', $contact_no, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':module_id', $module_id, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':course_field', $course_field, PDO::PARAM_STR);
    $query->bindParam(':hire_date', $hire_date, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        // Send email to the teacher
        $subject = "Your login credentials for Future-Study-Hub";
        $message = "Hello $teacher_name,\n\n";
        $message .= "Your account has been created successfully. Below are your login credentials:\n";
        $message .= "Email: $email\n";
        $message .= "Password: $password\n\n";
        $message .= "Please login using the provided credentials at \n\n";
        $message .= "Regards,\nFuture Study Hub";
        $email_sent = sendEmail($email, $subject, $message);

        $msg = " Teacher info added successfully. Email sent with login credentials.";
    } else {
        $error = "Something went wrong. Please try again";
    }
}

// Function to send email
    function sendEmail($email, $subject, $message)
    {
        // Include PHPMailer autoload file
        require '../vendor/autoload.php';

        $mail = new PHPMailer(true);
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'leadergoal12@gmail.com';                     //SMTP username
        $mail->Password   = 'tppz xjsk ixzj sdzp';                               //SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS
        $mail->SMTPSecure = 'ssl';
        $mail->CharSet = 'utf-8';
        $mail->setFrom('leadergoal12@gmail.com', 'Future Study hub ');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->SMTPDebug = false;

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            header('./manage-teachers.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin | Add Teacher</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">

    <script src="js/modernizr/modernizr.min.js"></script>

</head>

<body class="top-navbar-fixed" onload="setJoiningDate()">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('./includes/leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Teacher</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Teacher</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Fill The Info</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } else if ($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post" name="addTeacherForm" onsubmit="return validateForm()">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Teacher Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="teacher_name" class="form-control" id="teacher_name" required="required" autocomplete="off" onkeypress="validateTeacherName(event)">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control" id="email" required="required" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Contact No</label>
                                                <div class="col-sm-10">
                                                    <input type="tel" name="contact_no" class="form-control" id="contact_no" pattern="\d{10}" title="Please enter a 10-digit phone number" required autocomplete="off" onkeypress="allowOnlyNumbers(event)">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="date" class="col-sm-2 control-label">DOB</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="dob" class="form-control" id="date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Gender</label>
                                                <div class="col-sm-10">
                                                    <input type="radio" name="gender" value="Male" required="required" checked="">Male
                                                    <input type="radio" name="gender" value="Female" required="required">Female
                                                    <input type="radio" name="gender" value="Other" required="required">Other
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Module</label>
                                                <div class="col-sm-10">
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
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Subject</label>
                                                <div class="col-sm-10">
                                                    <select name="course_field" class="form-control" id="default" required="required">
                                                        <option value="">Select Subject</option>
                                                        <?php
                                                        $sql = "SELECT * from subject";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <option value="<?php echo htmlentities($result->sub_name); ?>"><?php echo htmlentities($result->sub_name); ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>

    </div>
</body>
<script>
     function getCurrentDate() {
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1 < 10 ? '0' : '') + (currentDate.getMonth() + 1);
            var day = (currentDate.getDate() < 10 ? '0' : '') + currentDate.getDate();
            return year + '-' + month + '-' + day;
        }

        function validateTeacherName(event) {
            var inputChar = String.fromCharCode(event.keyCode);
            // Regular expression to allow only alphabetic characters
            var pattern = /[a-zA-Z]/;
            if (!pattern.test(inputChar)) {
                // If the input character is not alphabetic, prevent its entry
                event.preventDefault();
            }
        }


        // Function to validate the form inputs
        function validateForm() {
            var teacher_name = document.forms["addTeacherForm"]["teacher_name"].value;
            // Check if teacher name is empty
            if (teacher_name.trim() === "") {
                alert("Teacher name cannot be empty!");
                return false;
            }
            return true;
        }

        // Function to automatically populate the "Joining Date" field with the current date
        function setJoiningDate() {
            var currentDate = new Date();
            var maxDate = new Date(currentDate);
            maxDate.setFullYear(maxDate.getFullYear() - 20); // Subtract 20 years from current date
            var year = maxDate.getFullYear();
            var month = (maxDate.getMonth() + 1 < 10 ? '0' : '') + (maxDate.getMonth() + 1);
            var day = (maxDate.getDate() < 10 ? '0' : '') + maxDate.getDate();
            var maxDateString = year + '-' + month + '-' + day;
            document.getElementById("date").setAttribute("max", maxDateString);
        }
        function allowOnlyNumbers(event) {
            // Get the ASCII code of the pressed key
            var keyCode = event.which ? event.which : event.keyCode;

            // Allow only numeric characters (48-57 are ASCII codes for digits 0-9)
            if (keyCode < 48 || keyCode > 57) {
                event.preventDefault();
            }

            // Get the input value and check its length
            var input = event.target.value;
            if (input.length >= 10) {
                event.preventDefault(); // Prevent further input if length exceeds 10
        }
    }

    

    // Function to validate the form inputs
    function validateForm() {
        var teacher_name = document.forms["addTeacherForm"]["teacher_name"].value;
        var email = document.forms["addTeacherForm"]["email"].value;
        var contact_no = document.forms["addTeacherForm"]["contact_no"].value;
        var dob = document.forms["addTeacherForm"]["dob"].value;
        var module_id = document.forms["addTeacherForm"]["module_id"].value;
        var course_field = document.forms["addTeacherForm"]["course_field"].value;

        // Check if any field is empty
        if (teacher_name == "" || email == "" || contact_no == "" || dob == "" || module_id == "" || course_field == "") {
            alert("All fields are required!");
            return false;
        }

        // Function to validate the email address format
        function validateEmail($email)
        {
            // Email format validation using regular expression
            $emailFormat = "/^[^\s@]+@[^\s@]+\.(com|in)$/";
            return preg_match($emailFormat, $email);
        }

        // Then, in your form validation function, use this function to validate the email address:
        function validateForm() {
            // Other form validation code...

            // Validate email format
            if (!validateEmail(email)) {
                alert("Invalid email address! Please enter a valid email ending with .com or .in.");
                return false;
            }
    }
    // Other validation code...




        // Contact number format validation (10 digits)
        var contactFormat = /^\d{10}$/;
        if (!contact_no.match(contactFormat)) {
            alert("Invalid contact number! Please enter a 10-digit phone number.");
            return false;
        }
        
        // Date of Birth validation
        var currentDate = new Date();
        var dobDate = new Date(dob);
        var age = currentDate.getFullYear() - dobDate.getFullYear();
        var monthDiff = currentDate.getMonth() - dobDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < dobDate.getDate())) {
            age--;
        }
        if (dobDate > currentDate || age < 20) {
            alert("Invalid date of birth! Date of birth should be before the current date and above 20 years.");
            return false;
        }

        return true;
    }

</script>

</html>