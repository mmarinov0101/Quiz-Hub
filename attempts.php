<?php
    include_once 'auth_session.php' ;
    require_once 'db.php';

    $stmt = '';
    if(!isset($_GET['quiz_id'])){
        $stmt = db_query("SELECT attempt_id, quiz_id, date_of_attempt, final_score FROM attempt WHERE username='{$_SESSION['username']}'");   
    }else{
        $stmt = db_query("SELECT attempt_id, quiz_id, date_of_attempt, final_score FROM attempt WHERE username='{$_SESSION['username']}' AND quiz_id = {$_GET['quiz_id']}");   
    }
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    echo('
        <div class="text-center marg-top-5">
            <h1 class="display-1">Attempts</h1>
        </div>
        ');
    echo("
        <div class='container marg-top-5'>      
          <table class='table table-bordered' bgcolor='#aaa'>
            <thead>
              <tr>
                <th>Quiz Name</th>
                <th>Author</th>
                <th>Taken on</th>
                <th>Score</th>
              </tr>
            </thead>
            <tbody>
        ");
    while($row = $stmt->fetch()){
        $stmt_2 = db_query("SELECT * FROM quiz WHERE quiz_id = {$row['quiz_id']}");
        $stmt_2->setFetchMode(PDO::FETCH_ASSOC);
        while($row_2 = $stmt_2->fetch()){
            echo "<tr>";
            echo "<td>" . $row_2['quiz_name'] . "</td>";
            echo "<td>" . $row_2['quiz_author_username'] . "</td>";
            echo "<td>" . $row['date_of_attempt'] . "</td>";
            echo "<td>" . $row['final_score'] . "%</td>";
            echo "</tr>";
        }
    }
    echo("
        </tbody>
    </table>
    </div>
    ");

    if(!isset($_GET['quiz_id'])) echo("<form action='dashboard.php'>");  
    else                         echo("<form action='user_quizzes.php'>");
    echo("<button type='submit' class='btn btn-primary marg-top-5 submit-btn'>Go Back</a>");
    echo("</form>");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Attempts</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>