<?php
    require "functions.php";
    $errors = array(); // Inițializare variabilă pentru a evita erorile

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = login($_POST);

        if (count($errors) == 0) {
            $_SESSION['email_verified'] = true; // Setează variabila de sesiune pentru autentificare
            //header("Location: index.html");
            die;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Log in</title>

</head>
<body>

<div class="form-container">
    <h2 class="form-message">Log in</h2>
    <?php if (count($errors) > 0) : ?>
        <div style="color: red;">
            <?php foreach ($errors as $error) : ?>
                <?= $error ?> <br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($confirmation_message)) : ?>
        <p style="color: green;"><?= $confirmation_message ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <br>
        <input type="submit" value="Log in" class="signup-button">
        <input type="button" value="No account? Sign up here!" class="signup-button" onclick="window.location.href = 'signup.php';">  
    </form>
    <br>
</div>

</body>
</html>