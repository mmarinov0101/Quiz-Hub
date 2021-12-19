<?php
    include_once 'staff_auth.php';

    if(isset($_POST['delete_question'])){
        deleteQuestion();
    } else if(isset($_POST['del_val'])){
        $stmt = db_query("DELETE FROM answer WHERE answer_id = {$_POST['del_val']}");
        header('Refresh:0');
    } else if(isset($_POST['add_question'])){
        header('Location: create_question.php?quiz_id='.$_POST['add_question']);   
    } else if(isset($_POST['add_answer'])){
        header('Location: create_answer.php?question_id='.$_POST['add_answer'].'&quiz_id='.$_GET['quiz_id']);
    } else if(isset($_POST['edit_question'])){
        header('Location: edit_question.php?question_id='.$_POST['edit_question'].'&quiz_id='.$_GET['quiz_id']);
    } else if(isset($_POST['edit_answer'])){
        header('Location: edit_answer.php?answer_id='.$_POST['edit_answer'].'&quiz_id='.$_GET['quiz_id']);
    } else if(isset($_POST['go_back'])){
        $allowed = true;
        $stmt = db_query("SELECT COUNT(*) FROM question  WHERE quiz_id = {$_GET['quiz_id']}");
        $num_of_questions = $stmt->fetchColumn();
        if($num_of_questions == 0){
            echo "The quiz has no questions. Please add some.";
            $allowed = false;
        } else{
            $stmt = db_query("SELECT question_content, question_id, question_score FROM question WHERE quiz_id = {$_GET['quiz_id']}");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while($row = $stmt->fetch()){
                $stmt_2 = db_query("SELECT COUNT(*) FROM answer WHERE question_id = {$row['question_id']}");
                $row_2 = $stmt_2->fetchColumn();
                if($row_2 < 2){
                    echo "There is a question with not enough answers.";
                    $allowed = false;
                    break;
                }
            }
        }
        if($allowed) header('Location: user_quizzes.php');
    }
    
    function deleteQuestion(){
        $question_id = $_POST['delete_question'];
        $stmt = db_query("SELECT * FROM answer WHERE question_id = {$question_id}");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()){
            $stmt_2 = db_query("DELETE FROM answer WHERE answer_id = {$row['answer_id']}");
        }
        $stmt = db_query("DELETE FROM question WHERE question_id = {$question_id}");
        header('Refresh:0');
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Quiz</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="text-center marg-top-5">
            <h1 class="display-2">My quiz</h1>
        </div>
        <?php
            echo(quizForm());
            if(!empty($_POST)) updateForm();
            displayQuestions();
        ?>
    </body>
</html>

<?php
    function quizForm(){
        $stmt = db_query("SELECT * FROM quiz WHERE quiz_id = {$_GET['quiz_id']}");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        return "
                <form method='POST'>
                    <div class='container'>
                        <div class='form-group'>
                            <label for='quiz_name' class='marg-left-13'>Quiz name</label>
                            <input type='text' id='quiz_name' name='quiz_name' value='{$row['quiz_name']}' class='form-control w-75 marg-left-13'>
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
                            <input type='number' id='quiz_duration' name='quiz_duration' min='0' max='300' value='{$row['quiz_duration_in_minutes']}' class='form-control w-75 marg-left-13'>
                            <br>
                        </div>

                        <input type='submit' value='Update Quiz' class='btn btn-primary' style='margin-left: 20%; margin-top: 5%; margin-bottom: 5%; width:60%;'>

                    </form>
                </div>
        ";
    }

    function updateForm(){
        if(isset($_POST['quiz_name'])) $quiz_name = $_POST['quiz_name'];
        if(isset($_POST['quiz_availability'])) $quiz_availability = $_POST['quiz_availability'];
        if(isset($_POST['quiz_duration'])) $quiz_duration = $_POST['quiz_duration'];
        if(!empty($quiz_name)) $stmt = db_query("UPDATE quiz SET quiz_name = '{$quiz_name}' WHERE quiz_id={$_GET['quiz_id']}");
        if(isset($quiz_availability)) $stmt = db_query("UPDATE quiz set quiz_available = {$quiz_availability} WHERE quiz_id={$_GET['quiz_id']}");
        if(!empty($quiz_duration)) $stmt = db_query("UPDATE quiz set quiz_duration_in_minutes = {$quiz_duration} WHERE quiz_id={$_GET['quiz_id']}");
        if(isset($_POST['quiz_name']) || isset($_POST['quiz_availability']) || isset($_POST['quiz_duration'])) header("Refresh:0");
    }

    function displayQuestions(){
        $quiz_id = $_GET['quiz_id'];
        $stmt = db_query("SELECT * FROM question WHERE quiz_id = '{$quiz_id}'");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo("
            <div class='text-center'>
            <h1 class='display-2'>Questions so far:</h1>
            </div>
            ");
        $counter = 1;
        echo("<form method='POST'>");  
        while($row = $stmt->fetch()){
            echo("<div id='{$row['question_id']}' class='d-flex' style='margin-top: 2%;'>");
            echo "<h4>Question " . $counter . ": " . $row['question_content']."</h4>";
            $counter += 1;
            echo("<button name='edit_question' value=".$row['question_id']." class='btn btn-danger marg-left-3'>Edit Question</button>");
            echo("<button name='delete_question' value=".$row['question_id']." class='btn btn-danger marg-left-3'>Delete Question</button>");
            echo("<button name='add_answer' value=".$row['question_id']." class='btn btn-danger marg-left-3'>Add Answer</button><br>");
            echo("</div>");
            $stmt_2 = db_query("SELECT * FROM answer
                                WHERE question_id = {$row['question_id']}");
            $stmt_2->setFetchMode(PDO::FETCH_ASSOC);
            $counter_2 = 1;
            while($row_2 = $stmt_2->fetch()){
                echo("<div id='{$row_2['answer_id']}' class='d-flex' style='margin-top: 1%;'>");
                echo "<h5>Answer " . $counter_2 . ": " . $row_2['answer_content']."</h5>";
                echo("<button name='edit_answer' value=".$row_2['answer_id']." class='btn btn-warning marg-left-3'>Edit Answer</button>");
                echo("<button name='del_val' value='{$row_2['answer_id']}' class='btn btn-warning marg-left-3'>Delete Answer</button><br>");
                echo("</div>");
                $counter_2 += 1;
            }
        }
        echo("<button name='add_question' value=".$quiz_id." class='btn btn-primary' style='margin-left: 20%; margin-top: 5%; width:60%;'>Add Question</button><br>");
        echo("<button name='go_back' class='btn btn-primary' style='margin-left: 20%; margin-bottom: 5%; width:60%; margin-top: 2%;'>Save and Exit</button>");
        echo("</form");
    }
?>