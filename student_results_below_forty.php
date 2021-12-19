<?php
    include_once 'auth_session.php' ;
    require_once 'db.php';

    $stmt = db_query("CALL GetStudentScoresBelowForty;");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo('
        <div class="text-center marg-top-5">
            <h1 class="display-1">Low Scores (Below 40%)</h1>
        </div>
    ');
    echo("
        <div class='container marg-top-5'>      
          <table class='table table-bordered' bgcolor='#aaa'>
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Student Username</th>
                <th>Score</th>
              </tr>
            </thead>
            <tbody>
        ");
    while($row = $stmt->fetch()){
        echo "<tr>";
        echo "<td>". $row['user_forename'] . " " . $row['user_surname'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['final_score'] . "%</td>";
        echo "</tr>";
    }
    echo("
        </tbody>
    </table>
    </div>
    ");
    echo("<form action='dashboard.php'>");
    echo("<button type='submit' class='btn btn-primary submit-btn marg-top-5'>Go Back</a>");
    echo("</form>");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Failing Students</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>