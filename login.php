<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$msg = "";

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    function sendMail()
    {
        include('./assets/include/db.php');
        $mail = $_POST['email'];
        $r = mt_rand(100000, 999999);
        $sqlotp = "UPDATE onetimepassword SET otp = '$r', mail = '$mail'";
        $resultotp = mysqli_query($conn, $sqlotp);

        require './vendor/autoload.php';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->CharSet = 'utf-8';
        $mail->SMTPAuth = true;
        $mail->Username   = 'leadergoal12@gmail.com';                     //SMTP username
        $mail->Password   = 'tppz xjsk ixzj sdzp';
        $mail->SetFrom('leadergoal12@gmail.com');
        $mail->addAddress("{$_POST['email']}");
        $mail->addReplyTo('leadergoal12@gmail.com');;
        $mail->SMTPDebug = false;
        $mail->IsHTML(true);
        $message = "<html><body> Your OTP is:- $r </body></html>";
        $mail->Subject = 'Future Study Hub';
        $mail->Body = $message;

        if (!$mail->send()) {
            echo '<script>alert("Message could not be sent.");</script>';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
    // Query the admin table
    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Check if user is an admin
    if (mysqli_num_rows($result) == 1) {
        // User is an admin
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = $email;
        sendMail();
        header("location:Admin/otp.php");
        // header("Location:./Admin/dashboard.php");
        exit;
    }

    // Query the teacher table
    $query = "SELECT * FROM teacher WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Check if user is a teacher
    if (mysqli_num_rows($result) == 1) {
        // User is a teacher
        $_SESSION['role'] = 'teacher';
        $_SESSION['email'] = $email;
        sendMail();
        header("location:Teacher/otp.php");
        // header("Location:./Teacher/change-password.php");
        exit;
    }

    // Query the student table
    $query = "SELECT * FROM student WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Check if user is a student
    if (mysqli_num_rows($result) == 1) {
        // User is a student
        $_SESSION['role'] = 'student';
        $_SESSION['email'] = $email;
        sendMail();
        header("location:otp.php");
        // header("Location:./index.php");
        exit;
    }

    // Invalid username or password
    $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Future Study Hub</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <h1>Future Study Hub</h1>
    <div class="main">
        <form action="" method="post">
            <h3>Login Form</h3>
            <?php echo $msg; ?>
            <label for="first">
                Email:
            </label>
            <input type="text" id="email" name="email" placeholder="Enter your Email" autocomplete="off" required>

            <label for="password">
                Password:
            </label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" autocomplete="off" required>
            <a href="./forgetpass.php" style="text-decoration: none; margin-left: 75%;">
                Forget Password
            </a>
            <div class="wrap">
                <button type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <p>Not registered?
        <a href="./Registration.php" style="text-decoration: none;">
            Create an account
        </a>
    </p>

</body>

</html>