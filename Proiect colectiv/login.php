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
    <title>Logare</title>
    <style>
        /* Stilizare CSS poate fi adăugată aici */
        .div {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="div">
    <h2>Logare</h2>
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
        <input type="password" name="password" placeholder="Parolă" required><br>
        <br>
        <input type="submit" value="Logare">
    </form>
    <br>

    <p>Nu ai cont? <a href="signup.php">Înregistrează-te aici</a></p>
</div>

</body>
</html>