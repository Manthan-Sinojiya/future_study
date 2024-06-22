<!DOCTYPE html>
<html lang="en-us" dir="ltr">

<head>
    <title>Future Study Hub </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400">
    <style>
        .m1 {
            list-style: none;
            display: none;
        }

        .m1:hover {
            display: block;
        }

        .dropbtn {
            background-color: white;
            color: black;
            font-size: 16px;
            border: none;
            padding-top: 20%;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: transparent;
            min-width: 160px;
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        /* .dropdown-content a:hover {
            background-color: #ddd;
        } */

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {
            background-color: white;
        }

        /* The container <div> - needed to position the dropdown content */
        .profile {
            position: relative;
            display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .profile-content {
            display: none;
            position: absolute;
            background-color: transparent;
            min-width: 160px;
            /* box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2); */
            z-index: 1;
        }

        /* Links inside the dropdown */
        .profile-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Show the dropdown menu on hover */
        .profile:hover .profile-content {
            display: block;
            margin-left: -100px;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .profile:hover .dropbtn {
            background-color: white;
        }
    </style>
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
                                <div class="dropdown">
                                    <button class="dropbtn" style="font-weight: bold;">Exam</button>
                                    <div class="dropdown-content">
                                        <a href="./Student/Exam/li/li.html">Listening Exam</a>
                                        <a href="./Student/Exam/re/re.html">Reading Exam</a>
                                        <a href="./Student/Exam/wr/wr.html">Writing Exam</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">IELTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./material.php">Material </a>
                            </li>
                        </ul>
                    </div>
                    <div class="profile">
                        <button class="dropbtn"><img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Avatar" class="img-fluid my-3" id="img-fluid" style="width: 50px; margin-left:-100%;" />
                            <div class="profile-content">
                                <span style="color:black;">Welcome, <?php echo $row['student_name']; ?></span>
                                <a href="#">Result</a>
                                <a href="./logout.php" class="btn btn white">Logout</a>
                            </div>
                        </button>
                    </div>
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