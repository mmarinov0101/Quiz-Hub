<?php
    include_once 'auth_session.php' ;
    require_once 'db.php';

    $stmt = db_query("SELECT quiz_id, quiz_name, quiz_author_username, quiz_duration_in_minutes FROM quiz WHERE quiz_available = 1");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo('
        <div class="text-center marg-top-5">
            <h1 class="display-1">Quizzes Available</h1>
        </div>
        ');
    echo("
        <div class='container marg-top-5'>      
          <table class='table table-bordered' bgcolor='#aaa'>
            <thead>
              <tr>
                <th>Quiz Name</th>
                <th>Author name</th>
                <th>Author username</th>
                <th>Quiz duration</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
        ");
    while($row = $stmt->fetch()){
        echo "<tr>";
        echo("<td>" . $row['quiz_name'] . "</td>");
        $stmt_2 = db_query("SELECT user_forename, user_surname, username from user
                            WHERE username = '{$row['quiz_author_username']}'");
        $stmt_2->setFetchMode(PDO::FETCH_ASSOC);
        $row_2 = $stmt_2->fetch();
        echo("<td>" . $row_2['user_forename'] . " " . $row_2['user_surname'] . "</td>");
        echo("<td>" . $row_2['username'] . "</td>");
        echo("<td>" . $row['quiz_duration_in_minutes'] . " minutes</td>");
        echo("<td><form method='POST'>");
        echo("<button name='begin_quiz' value='{$row['quiz_id']}' onclick='set_quiz_session(this.value)'>Begin quiz</button></td>");
        echo("</form</td>");
        echo "</tr>";
    }
    echo("
        </tbody>
    </table>
    </div>
        ");
    echo("<a class='link_button' href='dashboard.php' style='margin-left: 45%;'>Go Back</a>");
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

<!DOCTYPE html>
<html>
    <head>
        <title>Quizzes</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>
