<!DOCTYPE html>
<html lang="en-us" dir="ltr">

<head>
    <title>Future Study Hub </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-xl bg-light">
            <div class="container fixed-container">
                <a class="navbar-brand" href="./index.php">
                    Future Study Hub
                </a>
                <?php
                include('./assets/include/db.php');
                if (isset($_SESSION['email'])) {
                    $email = $_SESSION['email'];
                    $result = mysqli_query($conn, "SELECT * FROM student WHERE email ='" . $email . "'");
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="./index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Exam</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">IELTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./material.php">Material </a>
                            </li>
                        </ul>
                    </div>

                    <span>Welcome, <?php echo $row['student_name']; ?></span>
                    <a href="./logout.php" class="btn btn white">Logout</a>
                <?php
                } else {
                ?>
                    <div class="d-flex justify-content-between hide-desktop order-xl-last">
                        <a href="./login.php" class="btn white">Login</a>
                        <a href="./Registration.php" class="btn purple">Register <img class="img-fluid" src="./assets/img/arrow.webp" alt="->"></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="./index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Exam</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">IELTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./material.php">Material </a>
                            </li>
                        </ul>
                    </div>
                <?php
                }
                ?>
            </div>
        </nav>
    </header>
</body>

</html>