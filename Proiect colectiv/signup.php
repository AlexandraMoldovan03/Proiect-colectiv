<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = signup($_POST);

	if(count($errors) == 0)
	{
		header("Location: login.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>

    <!-- Include navbar.php if needed -->
    <!-- <?php //include('navbar.php')?> -->

    <div class="form-container">
    <h1 class="form-message" >Sign up</h1>

        <div>
            <?php if(count($errors) > 0):?>
                <?php foreach ($errors as $error):?>
                    <?= $error?> <br>    
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <form method="post">
            <input type="text" name="username" placeholder="Username"><br>
            <input type="text" name="email" placeholder="Email"><br>
            <input type="text" name="password" placeholder="Password"><br>
            <input type="text" name="password2" placeholder="Retype Password"><br>
            <br>
            <input type="submit" value="Sign up" class="signup-button"> 
			<input type="button" value="Already have an account?" class="signup-button" onclick="window.location.href = 'login.php';">      
        </form>
    </div>
</body>
</html>