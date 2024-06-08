<?php
include_once "db_config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id']) && isset($_POST['comment_text'])) {
        $post_id = mysqli_real_escape_string($con, $_POST['post_id']);
        $comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);
        $user_id = $_SESSION['unique_id'];

        // Inserare comentariu în baza de date
        $query = "INSERT INTO comments (post_id, user_id, comment_text) VALUES ('$post_id', '$user_id', '$comment_text')";
        mysqli_query($con, $query);

        // Selectați comentariul adăugat recent pentru afișare
        $queryNewComment = "SELECT comments.*, users.fname, users.lname 
                            FROM comments 
                            INNER JOIN users ON comments.user_id = users.unique_id 
                            WHERE comments.post_id = '$post_id' 
                            AND comments.user_id = '$user_id' 
                            ORDER BY comments.created_at DESC LIMIT 1";
        $resultNewComment = mysqli_query($con, $queryNewComment);

        if ($resultNewComment && mysqli_num_rows($resultNewComment) > 0) {
            $newComment = mysqli_fetch_assoc($resultNewComment);
            // Afișați noul comentariu
            echo "<div class='comment'>";
            echo "<span>{$newComment['fname']} {$newComment['lname']}</span>"; // Numele utilizatorului care a comentat
            echo "<span>{$newComment['created_at']}</span>"; // Data comentariului
            echo "<p>{$newComment['comment_text']}</p>"; // Textul comentariului
            echo "</div>";
        }
    }
}
?>
