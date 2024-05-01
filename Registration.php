<?php
include('./assets/include/db.php');

// Function to clean and validate user input
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize variables to store user input and error messages
$student_name = $email = $dob = $password = $contact_no = $gender = "";
$student_nameErr = $emailErr = $dobErr = $passwordErr = $contact_noErr = $genderErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    $student_name = clean_input($_POST["student_name"]);
    $email = clean_input($_POST["email"]);
    $dob = clean_input($_POST["dob"]);
    $password = clean_input($_POST["password"]);
    $contact_no = clean_input($_POST["contact_no"]);
    $gender = clean_input($_POST["gender"]);
    
    // Validate inputs
    if (empty($student_name)) {
        $student_nameErr = "Student name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    if (empty($dob)) {
        $dobErr = "Date of birth is required.";
    }
    if (empty($password)) {
        $passwordErr = "Password is required.";
    }
    if (!preg_match("/^[0-9]{10}$/", $contact_no)) {
        $contact_noErr = "Invalid contact number";
    }
    if (empty($gender)) {
        $genderErr = "Gender is required.";
    }
   
    // If there are no validation errors, insert data into the database
    if (empty($student_nameErr) && empty($emailErr) && empty($dobErr) && empty($passwordErr) && empty($contact_noErr) && empty($genderErr)) {
        $sql = "INSERT INTO student (student_name, email, dob, password, contact_no, gender) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $student_name, $email, $dob, $password, $contact_no, $gender);
        if ($stmt->execute()) {
            echo '<script>alert("Registration successful!");</script>';
            echo '<script>window.location.href="login.php";</script>';
        } else {
            echo '<script>alert("Error: ' . $stmt->error . '");</script>';
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="./assets/css/Registration.css">
    <style>
        /* Custom pop-up validation message */
        .custom-validation-message {
            display: none;
            position: absolute;
            background-color: #f44336;
            color: white;
            padding: 10px;
            z-index: 1;
            border-radius: 5px;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <h1>Future Study Hub</h1>
    <div class="main">
        <form method="post" name="forms" onsubmit="return validateForm()" enctype="multipart/form-data">
            <h3>Registration Form</h3>
            <label for="student_name">Student Name :</label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter your full name" autocomplete="off" required oninput="validateStudentName(this)" pattern="^[A-Za-z\s]+$">
            <span class="error"><?php echo $student_nameErr;?></span>

            <label for="email">Email :</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your Email" id="email" required="required" autocomplete="off">
            <span class="error"><?php echo $emailErr;?></span>

            <label for="dob">Date of Birth :</label>
            <input type="date" id="dob" name="dob" placeholder="Enter your DOB" autocomplete="off" max="<?php echo date('Y-m-d', strtotime('-14 years')); ?>" required>
            <span class="error"><?php echo $dobErr;?></span>

            <label for="password">Password :</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="off" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{8,}$" title="Password must contain at least one number, one alphabet, one symbol, and be at least 8 characters long" required>
            <span class="error"><?php echo $passwordErr;?></span>

            <label for="contact_no">Contact :</label>
            <input type="tel" name="contact_no" class="form-control" id="contact_no" placeholder="Enter your contact no" pattern="\d{10}" title="Please enter a 10-digit phone number" required autocomplete="off" onkeypress="validateContactNumber(event)">
            <span class="error"><?php echo $contact_noErr;?></span>

            <label for="gender">Gender :</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <span class="error"><?php echo $genderErr;?></span>
            <div class="wrap">
                <button type="submit">Submit</button>
            </div>
        </form>
        <!-- Custom pop-up validation message -->
        <div id="custom-validation-message" class="custom-validation-message"></div>
    </div>
    <div class="login">
        <p>Already have an account? <a class="login1" href="./login.php">Log in</a></p>
    </div>

    <script>
        // Function to validate the form inputs
        function validateForm() {
            var student_name = document.forms["forms"]["student_name"].value;
            var email = document.forms["forms"]["email"].value;
            var dob = document.forms["forms"]["dob"].value;
            var password = document.forms["forms"]["password"].value;
            var contact_no = document.forms["forms"]["contact_no"].value;
            var gender = document.forms["forms"]["gender"].value;

            // Check if any field is empty
            if (student_name == "" || email == "" || dob == "" || password == "" || contact_no == "" || gender == "") {
                // Display custom pop-up validation message
                document.getElementById("custom-validation-message").innerHTML = "All fields are required!";
                document.getElementById("custom-validation-message").style.display = "block";
                // Prevent form submission
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
            // Check if age is less than 14
            if (age <= 14) {
                alert("You must be at least 14 years old to register.");
                return false;
            }
            // Check if the Date of Birth is valid
            if (dobDate > currentDate || age < 14) {
                alert("Invalid date of birth! Date of birth should be before the current date and above 14 years.");
                return false;
            }

                return true;
        }

        // Function to validate the student name input
        function validateStudentName(input) {
            var inputValue = input.value;
            if (/^\d+$/.test(inputValue)) {
                // If the input contains only numbers, show a message and clear the input
                alert("Please enter only alphabetic characters in the Student Name field.");
                input.value = '';
            }
        }

        // Function to validate the contact number input
        function validateContactNumber(event) {
            var keyCode = event.which ? event.which : event.keyCode;

            // Allow only numeric characters (48-57 are ASCII codes for digits 0-9)
            if (keyCode < 48 || keyCode > 57) {
                alert("Please enter only numeric characters for the contact number.");
                event.preventDefault();
            }

            // Get the input value and check its length
            var input = event.target.value;
            if (input.length >= 10) {
                alert("Contact number should be exactly 10 digits.");
                event.preventDefault(); // Prevent further input if length exceeds 10
            }
        }
    </script>
</body>

</html>

