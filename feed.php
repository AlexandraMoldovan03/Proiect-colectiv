<?php
session_start();
include_once "db_config.php";

// Verifica dacă utilizatorul este autentificat sau nu
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php"); // Redirecționează către pagina de autentificare
}

if (isset($_POST['submit'])) {
    $post_text = mysqli_real_escape_string($con, $_POST['post_text']);

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
                    $insert_query = mysqli_query($con, "INSERT INTO posts (user_id, post_text, post_image) VALUES ('$user_id', '$post_text', '$new_img_name')");
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
</head>
<body>
    <h2>Încarcă o postare nouă</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <textarea name="post_text" placeholder="Introdu un mesaj pentru postare" required></textarea><br>
        <input type="file" name="image" required><br>
        <input type="submit" name="submit" value="Postează">
    </form>
</body>
</html>
