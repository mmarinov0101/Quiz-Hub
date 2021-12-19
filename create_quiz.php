<?php
    include_once 'staff_auth.php';

    function quizForm(){
        return "
        <div class='container'>
            <form method='POST' class='was-validated'>
                <div class='form-group'>
                    <label for='quiz_name' class='marg-left-13'>Quiz name</label>
                    <input type='text' id='quiz_name' name='quiz_name' class='form-control w-75 marg-left-13' required>
                    <div class='valid-feedback pad-left-13'>Valid.</div>
                    <div class='invalid-feedback pad-left-13'>Please fill out this field.</div>
                    <br>
                </div>

                <div class='form-group'>
                <label for='is_available' class='marg-left-13'>Is the quiz available?</label>
                <br>
                <label for='is_available' class='marg-left-13'>Yes</label>
                <input type='radio' id='quiz_availability' name='quiz_availability' value='1' class='form-check-input'>
                <br>
                <label for='is_available' class='marg-left-13'>No</label>
                <input type='radio' id='quiz_availability' name='quiz_availability' value='0' class='form-check-input'>
                <br>
                </div>

                <div class='form-group'>
                <label for='quiz_duration' class='marg-left-13'>Quiz duration (in minutes)</label>
                <input type='number' id='quiz_duration' name='quiz_duration' min='0' max='300' class='form-control w-75 marg-left-13' required>
                <br>
                </div>

                <input type='submit' value='Create Quiz' class='btn btn-primary' style='margin-left: 20%; margin-top: 5%; margin-bottom: 5%; width:60%;'>

            </form>
        </div>
        ";
    }

    function processQuiz(){
        $quiz_name = $_POST['quiz_name'];
        $quiz_availability = $_POST['quiz_availability'];
        $quiz_duration = $_POST['quiz_duration'];
        $stmt = db_query("INSERT INTO quiz(quiz_id, quiz_name, quiz_author_username, quiz_available, quiz_duration_in_minutes) VALUES(default, '{$quiz_name}', '{$_SESSION['username']}', {$quiz_availability}, {$quiz_duration})");
        $stmt_2 = db_query("SELECT MAX(quiz_id) FROM quiz");
        $quiz_id = $stmt_2->fetchColumn();
        header('Location: edit_quiz.php?quiz_id='.$quiz_id);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Quiz</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div>
            <h1 class="display-3 text-center" >Create a Quiz</h1>
        </div>
        <?php
            echo(quizForm());
            if(!empty($_POST)) processQuiz();
        ?>
        <a href="dashboard.php" class='btn btn-primary' style='margin-left: 20%; margin-top: -2%; margin-bottom: 5%; width:50.5%; margin-left: 24.75%;'>Go Back</a>
    </body>
</html>