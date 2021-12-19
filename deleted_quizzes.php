<?php
    include_once 'auth_session.php' ;
    require_once 'db.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Deleted Quizzes</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>

<?php
    $stmt = db_query("SELECT * FROM deleted_quizzes WHERE staff_id = '{$_SESSION['username']}'");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo('
        <div class="text-center marg-top-5">
            <h1 class="display-1">My Deleted Quizzes</h1>
        </div>
        ');
    echo("
        <div class='container marg-top-5'>      
          <table class='table table-bordered' bgcolor='#aaa'>
            <thead>
              <tr>
                <th>Quiz ID</th>
                <th>Date of Deletion</th>
              </tr>
            </thead>
            <tbody>
        ");
    while($row = $stmt->fetch()){
        echo "<tr>";
        echo "<td>". $row['quiz_id'] . "</td>";
        echo "<td>" . $row['date_of_deletion'] . "</td>";
        echo "</tr>";
    }
    echo("
        </tbody>
    </table>
    </div>
    ");
    echo("<form action='dashboard.php'>");
    echo("<button type='submit' class='btn btn-primary submit-btn marg-top-5' style='margin-bottom: 2%;'>Go Back</a>");
    echo("</form>");
?>