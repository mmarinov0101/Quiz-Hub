<?php
    session_start();
    require_once 'db.php';

    function registerForm()
    {
        return "
            <div class='container'>
                <form action='' method='POST' class='was-validated'>
                    <div class='form-group'>
                        <label for='username' class='marg-left-13'>Username</label>
                        <input type='text' id='username' name='username' class='form-control w-75 marg-left-13' required>
                        <div class='valid-feedback pad-left-13'>Valid.</div>
                        <div class='invalid-feedback pad-left-13'>Please fill out this field.</div>
                        <br>
                    </div>

                    <div class='form-group'>
                    <label for='password' class='marg-left-13'>Password</label>
                    <input type='password' id='password' name='password' class='form-control w-75 marg-left-13' required>
                    <div class='valid-feedback pad-left-13'>Valid.</div>
                    <div class='invalid-feedback pad-left-13'>Please fill out this field.</div>
                    <br>
                    </div>

                    <div class='form-group'>
                    <label for='fore_name' class='marg-left-13'>First name</label>
                    <input type='text' id='fore_name' name='fore_name' class='form-control w-75 marg-left-13' required>
                    <div class='valid-feedback pad-left-13'>Valid.</div>
                    <div class='invalid-feedback pad-left-13'>Please fill out this field.</div>
                    <br>
                    </div>

                    <div class='form-group'>
                    <label for='last_name' class='marg-left-13'>Last name</label>
                    <input type='text' id='last_name' name='last_name' class='form-control w-75 marg-left-13' required>
                    <div class='valid-feedback pad-left-13'>Valid.</div>
                    <div class='invalid-feedback pad-left-13'>Please fill out this field.</div>
                    <br>
                    </div>

                    <div class='form-group'>
                    <label for='date_of_birth' class='marg-left-13'>Date of birth</label>
                    <input type='date' id='date_of_birth' name='date_of_birth' class='form-control w-75 marg-left-13' required>
                    <br>
                    </div>

                    <div class='form-group'>
                    <label for='email' class='marg-left-13'>Email</label>
                    <input type='email' id='email' name='email' class='form-control w-75 marg-left-13' required>
                    <br>
                    </div>

                    <label for='is_staff' class='marg-left-13'>Are you a student or staff?</label>
                    <br>
                    
                    <label for='is_staff' class='marg-left-13'>I am a student</label>
                    <input type='radio' id='student' name='is_staff' value='0' class='form-check-input'>
                    <br>
                    <label for='is_staff' class='marg-left-13'>I am staff</label>
                    <input type='radio' id='teacher' name='is_staff' value='1' class='form-check-input'>
                    <br>

                    <input type='submit' value='Register' class='btn btn-primary' style='margin-left: 20%; width:60%; margin-top: 2%;'>
                </form>
            </div>
            ";
    }

    function processRegister()
    {
        global $error_msg;
        $un = $_POST['username'];
        $pw = $_POST['password'];
        $first_name = $_POST['fore_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $email = $_POST['email'];
        $is_staff = $_POST['is_staff'];
        
        $stmt = db_query("SELECT username FROM user WHERE username = '{$un}'");
        $stmt_2 = db_query("SELECT email FROM user WHERE email = '{$email}'");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($row = $stmt->fetch())
        {
            echo"Username already used!";
        } else if(!ctype_alnum($un)){
            echo"The username can contain only alphanumeric characters! (letters and numbers)";
        } else if($row = $stmt_2->fetch()){
            echo"The email is already linked to an account.";
        } else if(strlen($pw) < 5){
            echo"The password must be longer than 5 characters.";
        } else{
        $pw = password_hash($pw, PASSWORD_DEFAULT);
        $stmt = db_query("INSERT INTO user(username, user_password_hash, user_forename, user_surname, date_of_birth, email, is_staff) VALUES ('{$un}', '{$pw}', '{$first_name}', '{$last_name}', '{$date_of_birth}', '{$email}', {$is_staff})");
        $_SESSION['username'] = $un;
        $_SESSION['is_staff'] = $is_staff;
        header("Location: dashboard.php");
        }
    }

    echo('
        <div class="text-center marg-top-5">
            <h1 class="display-1">Registration Form</h1>
            <h1>Already have an account? Click <a href="login.php">here</a>.</h1>
        </div>
        ');
    echo(registerForm());
    if(!empty($_POST)) processRegister();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>