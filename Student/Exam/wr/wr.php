<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "future_study_hub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM wr_quiz";
$result = $conn->query($sql);

$questions = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

echo json_encode($questions);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mt-4">Questions</h2>
    <div id="questions" class="question-container">
        <!-- Questions will be loaded here -->
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-primary" onclick="submitAnswers()">Submit Answers</button>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        fetchQuestions();
    });

    function fetchQuestions() {
        $.ajax({
            url: 'wr.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    renderQuestions(data);
                }
            },
            error: function(xhr, status, error) {
                alert('Error fetching questions: ' + error);
            }
        });
    }

    function renderQuestions(questions) {
        let questionsHtml = '';
        questions.forEach(function(question, index) {
            questionsHtml += '<div class="card mb-3">';
            questionsHtml += '<div class="card-body">';
            questionsHtml += '<h5 class="card-title">' + question.question + '</h5>';
            ['option1', 'option2', 'option3', 'option4'].forEach(function(option) {
                questionsHtml += '<div class="form-check">';
                questionsHtml += '<input class="form-check-input" type="radio" name="question' + question.id + '" value="' + question[option] + '">';
                questionsHtml += '<label class="form-check-label">' + question[option] + '</label>';
                questionsHtml += '</div>';
            });
            questionsHtml += '</div>';
            questionsHtml += '</div>';
        });
        $('#questions').html(questionsHtml);
    }

    function submitAnswers() {
        let answers = {};
        $('input[type=radio]:checked').each(function() {
            let questionId = $(this).attr('name').replace('question', '');
            answers[questionId] = $(this).val();
        });

        console.log('Student Answers:', answers);
        // Send the answers to the server if needed
        // $.ajax({
        //     url: 'submit_answers.php',
        //     type: 'POST',
        //     data: {answers: answers},
        //     success: function(response) {
        //         alert('Answers submitted successfully');
        //     },
        //     error: function(xhr, status, error) {
        //         alert('Error submitting answers: ' + error);
        //     }
        // });
    }
</script>
</body>
</html>

