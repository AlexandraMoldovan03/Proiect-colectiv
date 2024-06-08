<?php
session_start();
include_once "db_config.php";

// Verifica dacă utilizatorul este autentificat sau nu
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php"); // Redirecționează către pagina de autentificare
}

if (isset($_POST['submit'])) {
    $post_text = mysqli_real_escape_string($con, $_POST['post_text']);
    $selected_tags = mysqli_real_escape_string($con, $_POST['selected_tags']);

    // Verifică dacă s-a încărcat o imagine
    if (isset($_FILES['image'])) {
        $img_name = $_FILES['image']['name'];
        $img_type = $_FILES['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];

        // Obține extensia imaginii
        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);

        $extensions = ["jpeg", "png", "jpg"];
        if (in_array($img_ext, $extensions) === true) {
            $types = ["image/jpeg", "image/jpg", "image/png"];
            if (in_array($img_type, $types) === true) {
                $time = time();
                $new_img_name = $time . $img_name;
                if (move_uploaded_file($tmp_name, "uploads/" . $new_img_name)) {
                    // Inserează postarea în baza de date
                    $user_id = $_SESSION['unique_id'];
                    $insert_query = mysqli_query($con, "INSERT INTO posts (user_id, post_text, post_image, star_tags) VALUES ('$user_id', '$post_text', '$new_img_name', '$selected_tags')");
                    if ($insert_query) {
                        echo "Postarea a fost încărcată cu succes!";
                    } else {
                        echo "Ceva nu a mers bine. Te rog să încerci din nou!";
                    }
                } else {
                    echo "A apărut o eroare la încărcarea imaginii. Te rog să încerci din nou!";
                }
            } else {
                echo "Te rog să încarci doar fișiere de imagine - jpeg, png, jpg";
            }
        } else {
            echo "Te rog să încarci doar fișiere de imagine - jpeg, png, jpg";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed Social Media</title>
    <link rel="stylesheet" href="postarile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container">
    <div class="header">
    <a href="feed.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <h1 class="sign">Upload a new post</h1>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <textarea name="post_text" placeholder="Post description" required></textarea><br>
        <input type="file" name="image" required><br>
        <div class="hash-container">
            <div class="hashtags">Choose your hashtags:</div>
            <div class="hashtag" data-tag="art"><i class="fas fa-star"></i> Art</div>
            <div class="hashtag" data-tag="sport"><i class="fas fa-star"></i> Sport</div>
            <div class="hashtag" data-tag="photography"><i class="fas fa-star"></i> Photography</div>
            <div class="hashtag" data-tag="food"><i class="fas fa-star"></i> Food</div>
            <div class="hashtag" data-tag="acting"><i class="fas fa-star"></i> Acting</div>
        </div>
        <input type="hidden" name="selected_tags" id="selected_tags" value="">
        <input type="submit" name="submit" value="Create your post">
    </form>
</div>

    <script>
        const hashtags = document.querySelectorAll('.hashtag');
    const selectedTagsInput = document.getElementById('selected_tags');

    hashtags.forEach(hashtag => {
        hashtag.addEventListener('click', () => {
            hashtag.classList.toggle('selected');
            updateSelectedTags();
        });
    });

    function updateSelectedTags() {
        const selectedTags = [];
        document.querySelectorAll('.hashtag.selected').forEach(tag => {
            selectedTags.push(tag.getAttribute('data-tag'));
        });
        selectedTagsInput.value = selectedTags.join(',');
    }
        const root = document.querySelector(':root'); // Add this line to access root variables

// Retrieve theme colors from localStorage
const mainColor = localStorage.getItem('mainColor');
const primaryColor = localStorage.getItem('primaryColor');
const secondaryColor = localStorage.getItem('secondaryColor');
const thirdColor = localStorage.getItem('thirdColor');

// Apply theme colors to root variables if retrieved from localStorage
if (mainColor && primaryColor && secondaryColor && thirdColor) {
    root.style.setProperty('--main-color', mainColor);
    root.style.setProperty('--primary-color', primaryColor);
    root.style.setProperty('--secondary-color', secondaryColor);
    root.style.setProperty('--third-color', thirdColor);
}
    </script>
</body>
</html>
