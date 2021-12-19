<?php
    include_once 'staff_auth.php';

    function displayForm(){
        return "
        <div class='container marg-top-5'>
        <form method='POST'>
        <div class='form-group'>
        <label for='question_content' class='marg-left-13'>Question</label>
        <input type='text' id='question_content' name='question_content' class='form-control w-75 marg-left-13' required>
        <br>
        </div>
        
        <div class='form-group'>
        <label for='question_score' class='marg-left-13'>Question Score</label>
        <input type='number' id='question_score' name='question_score' class='form-control w-75 marg-left-13' required>
        <br>
        </div>
        
        <button onclick='create_question('{$_GET['quiz_id']}')' class='btn btn-primary submit-btn'>Save</button>
        </form>
            ";
    }

    function processForm(){
        $question_content = $_POST['question_content'];
        $question_score = $_POST['question_score'];
        $stmt = db_query("UPDATE question SET question_content = '{$question_content}', question_score = {$question_score} WHERE question_id = {$_GET['question_id']}");
        header('Location: edit_quiz.php?quiz_id='.$_GET['quiz_id']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Question</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="text-center marg-top-5">
            <h1 class="display-1">Edit Question</h1>
        </div>
        <?php
        echo(displayForm());
        if(!empty($_POST)) processForm();
        ?>
    </body>
</html>