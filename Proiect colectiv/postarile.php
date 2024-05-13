<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .post-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .post {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .post p {
            margin: 10px 0;
        }
        .post img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .post-details p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="post-container">
        <h1>Feed</h1>
        <?php
            include_once "db_config.php"; // Include fișierul de configurare a bazei de date

            // Interogare pentru a selecta postările împreună cu informațiile utilizatorului care le-a postat
            $query = "SELECT posts.*, users.fname, users.lname, users.img AS profile_img 
                      FROM posts 
                      INNER JOIN users ON posts.user_id = users.unique_id 
                      ORDER BY posts.created_at DESC"; // Înlocuiește 'unique_id' cu denumirea coloanei cheii primare din tabela 'users'

            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // Afișează fiecare postare și informațiile asociate
                    echo "<div class='post'>";
                    echo "<div class='post-details'>";
                    echo "<img src='images/{$row['profile_img']}' alt='Profile Picture' class='profile-pic'>";
                    echo "<p><strong>{$row['fname']} {$row['lname']}</strong></p>";
                    echo "</div>";
                    echo "<p><strong>Date:</strong> {$row['created_at']}</p>";
                    echo "<img src='uploads/{$row['post_image']}' alt='Post Image'>";
                    echo "<p>{$row['post_text']}</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nu există postări de afișat.</p>";
            }
        ?>
    </div>
</body>
</html>
