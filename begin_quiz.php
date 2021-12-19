<?php
    include_once 'auth_session.php' ;
    require_once 'db.php';

    echo('<div id="countdowntimer" class="timer"></div>');

    echo("<form action='quiz_score.php?quiz_id={$_GET['quiz_id']}' method='POST'>");

    $stmt = db_query("SELECT question_content, question_id, question_score FROM question WHERE quiz_id = {$_GET['quiz_id']}");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch()){
        echo("<div class='container pad-top-5'>");
        echo("<h4>Question: " . $row['question_content'] . "</h4>");
        $stmt_2 = db_query("SELECT answer_content, is_correct FROM answer WHERE question_id = {$row['question_id']}");
        $stmt_2->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_3 = db_query("SELECT COUNT(is_correct) FROM answer WHERE is_correct = 1
                                                    AND question_id = {$row['question_id']}");
        $row_3 = $stmt_3->fetchColumn();
        if($row_3 > 1){
            $points = $row['question_score']/$row_3;
            while($row_2 = $stmt_2->fetch()){
                echo("<label for='answer' style='font-size: 130%;'>{$row_2['answer_content']}</label>");
                if($row_2['is_correct']){
                    echo("<input type='checkbox' name='{$row_2['answer_content']}{$row['question_content']}' value={$points}><br>");   
                } else{
                    echo("<input type='checkbox' name='{$row_2['answer_content']}{$row['question_content']}' value=-{$points}><br>");   
                }
            }
        } else{
            while($row_2 = $stmt_2->fetch()){
                echo("<label for='answer' style='font-size: 130%;'>{$row_2['answer_content']}</label>");
                if($row_2['is_correct']){
                    echo("<input type='radio' name='{$row['question_content']}' value={$row['question_score']}><br>");   
                } else{
                    echo("<input type='radio' name='{$row['question_content']}' value=0><br>");   
                }
        }
    }
        echo("</div>");
        echo("<br><br>");
    }
    echo("<button class='btn btn-primary marg-top-5 submit-btn' type='submit'>Submit</button>");
    echo("</form>");
?>

<script type="text/javascript">
    setInterval(function(){
        timer();
    },1000);
    function timer()
    {
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                if(xmlhttp.responseText=="00:00:01")
                {
                    window.location="quiz_score.php?quiz_id=" + <?php echo($_GET['quiz_id']);?>;
                }

                document.getElementById("countdowntimer").innerHTML=xmlhttp.responseText;

            }
        };
        xmlhttp.open("GET","load_timer.php",true);
        xmlhttp.send(null);
    }

    </script>

<!DOCTYPE html>
<html>
    <head>
        <title>Quiz</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>