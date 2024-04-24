<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("location:../login.php");
    exit;
}  else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Registration Report</title>
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/DataTables/datatables.min.js"></script>
        <script src="js/modernizr/modernizr.min.js"></script>
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
                                    <h2 class="title">Student Registration Report</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#">REPORT</a></li>
                                        <li class="active">Student Registration Report</li>
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
                                                    <h5>Student Registration Report</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <form method="post">
                                                    <div class="form-group has-success">
                                                        <label for="success" class="control-label">Select Date</label>
                                                        <div class="">
                                                            <input type="date" id="date" name="date" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-success">
                                                        <div class="">
                                                            <button type="submit" name="submit" class="btn btn-success btn-labeled">Generate Report<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                        </div>
                                                </form>
                                            </div>
                                            <div id="tpsReport">
                                                <?php
                                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                    include 'includes/db.php'; // Include database connection script

                                                    // Retrieve selected date from the POST data
                                                    $date = $_POST['date'];

                                                    // Query to retrieve TPS report data for the selected date
                                                    $sql = "SELECT * FROM student WHERE enrollment_date = '$date'";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        // Output TPS report in table format
                                                        echo "<h2>Student Registration Report for $date</h2>";
                                                        echo "<table id='example' class='display table table-striped table-bordered' cellspacing='0' width='100%'>
                                                            <tr>
                                                                <th>Enrollment Date</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Dob</th>
                                                                <th>Contact No</th>
                                                                <th>Gender</th>
                                                            </tr>";

                                                        // Output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>
                                                                        <td>" . $row["enrollment_date"] . "</td>
                                                                        <td>" . $row["student_name"] . "</td>
                                                                        <td>" . $row["email"] . "</td>
                                                                        <td>" . $row["dob"] . "</td>
                                                                        <td>" . $row["contact_no"] . "</td>
                                                                        <td>" . $row["gender"] . "</td>
                                                                </tr>";
                                                        }
                                                        
                                                        echo "</table>";
                                                    } else {
                                                        echo "No registrations found for $date";
                                                    }

                                                    $conn->close();
                                                }
                                                ?>
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
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>



        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>

    </html>
<?php  } ?>