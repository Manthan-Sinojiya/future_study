<?php 
session_start();
include('./assets/include/config.php');
$msg = '';
if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    // $username = $_SESSION['alogin'];
    // Fetch admin details including password from database
    $sql = "SELECT * FROM student WHERE id = :id"; // Improved query to fetch specific student details
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $_SESSION['student_id'], PDO::PARAM_INT); // Binding student ID
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    // Verify current password
    if ($password === $cpassword) {
        // Update password in database
        $con = "UPDATE student SET password=:password WHERE id = :id"; // Improved query to update password for specific student
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':password', $password, PDO::PARAM_STR);
        $chngpwd1->bindParam(':id', $_SESSION['student_id'], PDO::PARAM_INT); // Binding student ID
        $chngpwd1->execute();

        // Update password in session
        $_SESSION['password'] = $password;

        $msg = "Your Password has been changed successfully.";
    } else {
        $error = "Your current password is wrong.";
    }
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
                New Password:
            </label>
            <input type="password" id="password" name="password" placeholder="Enter your New Password" autocomplete="off" required>
            <label for="password">
                Confirm Password: <!-- Corrected spelling of "Confirm" -->
            </label>
            <input type="password" id="cpassword" name="cpassword" placeholder="Enter your Confirm Password" autocomplete="off" required>
            <div class="wrap">
                <button type="submit" name='submit'>
                    Submit
                </button>
            </div>
        </form>
    </div>
</body>

</html>