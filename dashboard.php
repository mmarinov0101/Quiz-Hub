<?php include_once 'auth_session.php' ; require_once 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Main Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-inverse" style="background-color: #FECBA5;">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand">QuizHub</a>
        </div>
        <ul class="nav navbar-nav">
          <li style="background-color: #FBD7BB;"><a href="dashboard.php">Home</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
      </div>
    </nav>
    <div class="d-inline-flex">
        <?php
        $stmt = db_query("SELECT user_forename FROM user WHERE username = '{$_SESSION['username']}'");
        $user_forename = $stmt->fetchColumn();
        echo("
        <div class='text-center marg-top-5'>
            <h1>Hello {$user_forename}. How are you today?</h1>
        </div>
        ");
        echo("<a href='quizzes_list.php' class='menu-item'>Quizzes to play</a>
              <a href='attempts.php' class='menu-item'>Previous Attempts</a>");
        if($_SESSION['is_staff'] == 1){
            echo("<a href='create_quiz.php' class='menu-item'>Create quiz</a>");
            echo("<a href='user_quizzes.php' class='menu-item'>My quizzes</a>");
            echo("<a href='student_results_below_forty.php' class='menu-item'>Failing Students</a>");
            echo("<a href='deleted_quizzes.php' class='menu-item'>Deleted quizzes</a>");
        }
        ?>
    </div>
</body>
</html>