<?php  
    include_once 'staff_auth.php';

    function displayForm(){
        return "
        <div class='container marg-top-5'>
        <form method='POST'>
        <div class='form-group'>
        <label for='answer_content' class='marg-left-13'>Answer</label>
        <input type='text' id='answer_content' name='answer_content' class='form-control w-75 marg-left-13' required>
        <br>
        </div>
        
        <div class='form-group'>
        <label for='is_correct' class='marg-left-13'>Is this a correct answer?</label>
        <br>
        <label for='is_correct' class='marg-left-13'>Yes</label>
        <input type='radio' id='yes' name='is_correct' value='1' class='form-check-input'>
        <br>
        <label for='is_correct' class='marg-left-13'>No</label>
        <input type='radio' id='no' name='is_correct' value='0' class='form-check-input'>
        <br>
        </div>
        
        <button class='btn btn-primary submit-btn'>Add</button>
        </form>
        </div>
        ";
    }

    function processForm(){
        $answer_content = $_POST['answer_content'];
        $is_correct = $_POST['is_correct'];
        $stmt = db_query("INSERT INTO answer(answer_id, answer_content, question_id, is_correct) VALUES(default, '{$answer_content}', {$_GET['question_id']}, {$is_correct})");
        header('Location: edit_quiz.php?quiz_id='.$_GET['quiz_id']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Answer</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="text-center marg-top-5">
            <h1 class="display-1">Answer</h1>
        </div>
        <?php
        echo(displayForm());
        if(!empty($_POST)) processForm();
        ?>
    </body>
</html>