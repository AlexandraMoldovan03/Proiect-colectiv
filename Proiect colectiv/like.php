<?php
// Conectarea la baza de date și preluarea datelor din cerere
include_once "db_config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['unique_id'])) {
    $data = json_decode(file_get_contents("php://input"), true);
    $postId = $data['postId'];
    $userId = $_SESSION['unique_id'];

    // Verificăm dacă utilizatorul a dat deja like la această postare
    $query = "SELECT * FROM likes WHERE post_id = $postId AND user_id = $userId";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 0) {
        // Dacă utilizatorul nu a dat deja like, adăugăm un nou rând în tabela de like-uri
        $insertQuery = "INSERT INTO likes (post_id, user_id) VALUES ($postId, $userId)";
        mysqli_query($con, $insertQuery);

        // Adăugăm ID-ul postării la lista de like-uri a utilizatorului în sesiune
        $_SESSION['liked_posts'][] = $postId;
        
        // Incrementăm numărul total de like-uri pentru postare
        $updateLikeCountQuery = "UPDATE posts SET like_count = like_count + 1 WHERE post_id = $postId";
        mysqli_query($con, $updateLikeCountQuery);
        
        // Obținem numărul actualizat de like-uri pentru postare
        $likeCountQuery = "SELECT like_count FROM posts WHERE post_id = $postId";
        $likeCountResult = mysqli_query($con, $likeCountQuery);
        $likeCountData = mysqli_fetch_assoc($likeCountResult);
        $likeCount = $likeCountData['like_count'];
    } else {
        // Dacă utilizatorul a dat deja like, eliminăm rândul din tabela de like-uri
        $deleteQuery = "DELETE FROM likes WHERE post_id = $postId AND user_id = $userId";
        mysqli_query($con, $deleteQuery);
        
        // Eliminăm ID-ul postării din lista de like-uri a utilizatorului în sesiune
        $key = array_search($postId, $_SESSION['liked_posts']);
        if ($key !== false) {
            unset($_SESSION['liked_posts'][$key]);
        }
        
        // Decrementăm numărul total de like-uri pentru postare
        $updateLikeCountQuery = "UPDATE posts SET like_count = like_count - 1 WHERE post_id = $postId";
        mysqli_query($con, $updateLikeCountQuery);
        
        // Obținem numărul actualizat de like-uri pentru postare
        $likeCountQuery = "SELECT like_count FROM posts WHERE post_id = $postId";
        $likeCountResult = mysqli_query($con, $likeCountQuery);
        $likeCountData = mysqli_fetch_assoc($likeCountResult);
        $likeCount = $likeCountData['like_count'];
    }

    echo json_encode(['likeCount' => $likeCount]);
} else {
    echo json_encode(['error' => 'Unauthorized']);
}
?>
