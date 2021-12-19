<?php
    include_once 'auth_session.php' ;
    require_once 'db.php';

    $score = 0;
    if(!empty($_POST)){
        foreach($_POST as $v){
            $score += $v;
        }
    }
    if($score < 0) $score = 0;

    $total_possible = 0;
    $stmt = db_query("SELECT question_score FROM question WHERE quiz_id = {$_GET['quiz_id']}");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch()){
        $total_possible += $row['question_score'];
    }

    $score = round($score, 1);
    $percentage = 0;
    if($total_possible == 0) $percentage = round(($score)*100, 1);
    else $percentage = round(($score/$total_possible)*100, 1);
    echo("
        <div class='text-center' style='margin-top: 15%'>
            <h1 class='display-1'>Final score: {$score}/{$total_possible} ({$percentage}%)</h1>
        </div>
        ");
    $date = date("Y-m-d");
    $stmt_2 = db_query("INSERT INTO attempt(attempt_id, quiz_id, username, date_of_attempt, final_score) VALUES(default, {$_GET['quiz_id']}, '{$_SESSION['username']}', '{$date}', {$percentage})");

    echo("<form action='dashboard.php'>");
    echo("<button type='submit' class='btn btn-primary submit-btn' style='margin-top: 10%;'>Go Back</a>");
    echo("</form>");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Final Score</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>