<?php
session_start();
include_once "db_config.php";

if (!isset($_GET['userId'])) {
    // Dacă nu este furnizat ID-ul utilizatorului, redirecționează utilizatorul către o pagină de eroare sau altă pagină relevantă
    header("Location: error.php");
    exit();
}

// Obține ID-ul utilizatorului din parametrul URL
$userId = $_GET['userId'];

// Interoghează baza de date pentru a obține informațiile utilizatorului cu ID-ul specificat
$user_query = mysqli_query($con, "SELECT * FROM users WHERE unique_id = '$userId'");
if(mysqli_num_rows($user_query) > 0) {
    $user_row = mysqli_fetch_assoc($user_query);
    // Afișează informațiile utilizatorului
    // Restul codului pentru afișarea profilului utilizatorului...
    
    // Interogare pentru a obține postările utilizatorului
    $posts_query = mysqli_query($con, "SELECT * FROM posts WHERE user_id = '$userId' ORDER BY created_at DESC");
    if(mysqli_num_rows($posts_query) > 0) {
        // Afisează postările utilizatorului
        while($post = mysqli_fetch_assoc($posts_query)) {
            // Afisează fiecare postare
            // ...
        }
    } else {
        echo "No posts found";
    }
} else {
    // Dacă nu există un utilizator cu ID-ul specificat, poți afișa un mesaj de eroare sau redirecționa utilizatorul către o altă pagină relevantă
    echo "User profile not found";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>
    <div class="container">
    <?php 
        // Verifică dacă este furnizat un ID de utilizator în parametrul URL
        if(isset($_GET['userId'])) {
            // Obține ID-ul utilizatorului din parametrul URL
            $user_id = $_GET['userId'];
            // Interoghează baza de date pentru a obține informațiile utilizatorului cu ID-ul specificat
            $sql = mysqli_query($con, "SELECT * FROM users WHERE unique_id = '$user_id'");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
    ?>
        <div class="header">
            <a href="feed.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <h1><?php echo htmlspecialchars($row['fname']). " " . htmlspecialchars($row['lname']) ?>'s Profile</h1>
        </div>
        <div class="profile">
            <img src="php/images/<?php echo htmlspecialchars($row['img']); ?>" alt="">
            <h2><?php echo htmlspecialchars($row['fname']). " " . htmlspecialchars($row['lname']) ?></h2>
            <p>Email: <?php echo htmlspecialchars($row['email']) ?></p>
            <p>About me: <?php echo htmlspecialchars($row['about_me']) ?></p>
        </div>
        <h2>Posts</h2>
        <div class="posts">
        <?php 
            // Interoghează baza de date pentru a obține postările utilizatorului cu ID-ul specificat
            $posts_query = mysqli_query($con, "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY created_at DESC");
            while($post = mysqli_fetch_assoc($posts_query)) {
                echo '<div class="post">';
                // Verifică dacă există o imagine pentru postare și afișează-o
                if (!empty($post['post_image'])) {
                    echo "<img src='uploads/{$post['post_image']}' alt='Post Image'>";
                } else {
                    echo '<img src="post-placeholder.jpg" alt="New Post">';
                }
                // Afișează textul postării
                echo '<div class="post-content"><p>' . htmlspecialchars($post['post_text']) . '</p></div>';
                echo '</div>';
            }
        ?>
        </div>
    <?php
            } else {
                // Afisează un mesaj de eroare dacă nu este găsit un utilizator cu ID-ul specificat
                echo "User profile not found.";
            }
        } else {
            // Afisează un mesaj de eroare dacă nu este furnizat un ID de utilizator în parametrul URL
            echo "User ID not provided.";
        }
    ?>
    </div>
    <script src="./profil.js"></script>
</body>
</html>

