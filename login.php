<?php
    session_start();
    require_once 'db.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
        <style>
        </style>
    </head>
    <body>
        <div class="text-center marg-top-5">
            <h1 class="display-1">Quiz Hub</h1>
            <h1>Want to register? Click <a href="register.php">here</a>.</h1>
        </div>
    </body>
</html>

<?php
    function loginForm()
    {
        return "
            <div class='container marg-top-5'>
            <form method='POST' class='was-validated'>
                <div class='form-group'>
                <label for='username' class='marg-left-13'>Username</label>
                <input type='text' id='username' name='username' class='form-control w-75 marg-left-13' required>
                <div class='valid-feedback pad-left-13'>Valid.</div>
                <div class='invalid-feedback pad-left-13'>Please fill out this field.</div>
                </div>
                
                <div class='form-group'>
                <label for='password' class='marg-left-13'>Password</label>
                <input type='password' id='password' name='password' class='form-control w-75 marg-left-13' required>
                <div class='valid-feedback pad-left-13'>Valid.</div>
                <div class='invalid-feedback pad-left-13'>Please fill out this field.</div>
                </div>
                
                
                <input type='submit' value='Login' class='btn btn-primary submit-btn'>
            </form>
            </div>
            ";
    }


    function processLogin()
    {
        $un = $_POST['username'];
        $pw = $_POST['password'];
        
        $stmt = db_query("SELECT username, user_password_hash, is_staff FROM user
                WHERE username = '". $un . "'");
        $row = $stmt->fetch();
        if($row != null){
            if(password_verify($pw, $row['user_password_hash'])){
                $_SESSION['username'] = $un;
                $_SESSION['is_staff'] = $row['is_staff'];
                header("Location: ../dashboard.php");
            }
        }
        echo("<br><h4 style='margin-left: 40%;'>Invalid Credentials. Please try again.</h4>");
    }
?>

<?php
    if(empty($_SESSION['username'])){
        echo(loginForm());
        if(!empty($_POST)) processLogin();
    } else{
        header("Location: ../dashboard.php"); 
    }
?>