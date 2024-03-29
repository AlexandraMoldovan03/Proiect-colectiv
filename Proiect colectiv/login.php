<?php

require "functions.php";

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = login($_POST);

    if (count($errors) == 0) {
        $_SESSION['email_verified'] = true; // Setează variabila de sesiune pentru autentificare
        //header("Location: booking.php");
        die;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    
</head>
<body>
    <?php //include('navbar.php')?>
    <h1>Login</h1>

    <div>
        <div>
            <?php if(count($errors) > 0):?>
                <?php foreach ($errors as $error):?>
                    <?= $error?> <br>    
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <form method="post">
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <br>
            <input type="submit" value="Login">
            </form>
        <p>Nu ai cont? <a href="signup.php">Înregistrează-te aici</a></p>
    </div>
        </form>
    </div>
</body>
</html>