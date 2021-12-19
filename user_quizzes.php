<!DOCTYPE html>
<html>
    <head>
        <title>My Quizzes</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="text-center">
            <h1 class="display-1">My Quizzes</h1>
        </div>
    </body>
</html>

<?php 
    include_once 'staff_auth.php';

    $stmt = db_query("SELECT quiz_id, quiz_name FROM quiz WHERE quiz_author_username = '{$_SESSION['username']}'");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch()){
        echo("<div id='{$row['quiz_id']}' style='margin-left: 30%; margin-top: 4%;'>");
        echo("<form method='POST' class='d-flex'>");
        echo("<h4>Name: " . $row['quiz_name']."</h4>");
        echo("<button name='edit_quiz' value=".$row['quiz_id']." class='btn btn-danger marg-left-3'>Edit Quiz</button>");
        echo("<button name='begin_quiz' value=".$row['quiz_id']." onclick='set_quiz_session(this.value)' class='btn btn-danger marg-left-3'>Begin Quiz</button>");
        echo("<button name='delete_quiz' value=".$row['quiz_id']." class='btn btn-danger marg-left-3'>Delete Quiz</button>");
        echo("<button name='quiz_attempts' value=".$row['quiz_id']." class='btn btn-danger marg-left-3'>Attempts</button><br>");
        echo("</form>");
        echo("</div>");
    }
    echo("<form action='dashboard.php'>");
    echo("<button type='submit' class='btn btn-primary' style='margin-left: 30%; width:40%; margin-top: 2%;'>Go Back</a>");
    echo("</form>");

    function deleteQuiz(){
        $quiz_id = $_POST['delete_quiz'];
        $stmt = db_query("SELECT question_id FROM question WHERE quiz_id = {$quiz_id}");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()){
            $question_id = $row['question_id'];
            $stmt_2 = db_query("SELECT answer_id FROM answer WHERE question_id = {$question_id}");
            $stmt_2->setFetchMode(PDO::FETCH_ASSOC);
            while($row_2 = $stmt_2->fetch()){
                $stmt_3 = db_query("DELETE FROM answer WHERE answer_id = {$row_2['answer_id']}");
        }
            $stmt_2 = db_query("DELETE FROM question WHERE question_id = {$question_id}");
        }
        $stmt = db_query("DELETE FROM attempt WHERE quiz_id = {$quiz_id}");
        $stmt = db_query("DELETE FROM quiz WHERE quiz_id = {$quiz_id}");
        header('Refresh:0');
    }
    if(isset($_POST['delete_quiz'])) deleteQuiz();
    else if(isset($_POST['quiz_attempts'])) header('Location: attempts.php?quiz_id='.$_POST['quiz_attempts']);
    else if(isset($_POST['edit_quiz'])) header('Location: edit_quiz.php?quiz_id='.$_POST['edit_quiz']);
?>

<script>
    function set_quiz_session(quiz_id)
    {
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                window.location = "begin_quiz.php?quiz_id=" + quiz_id;
            }
        };
        xmlhttp.open("GET","set_quiz_session.php?quiz_id="+ quiz_id,true);
        xmlhttp.send(null);
    }
</script>