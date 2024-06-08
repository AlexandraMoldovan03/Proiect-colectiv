<?php
include_once "db_config.php";
session_start();

// Procesarea formularului pentru adăugarea like-urilor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['like_post_id'])) {
        $post_id = $_POST['like_post_id'];
        $user_id = $_SESSION['unique_id'];

        // Verifică dacă utilizatorul a dat deja like la această postare
        $check_like_query = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
        $check_like_result = mysqli_query($con, $check_like_query);
        if (mysqli_num_rows($check_like_result) == 0) {
            // Adaugă like-ul în baza de date
            $add_like_query = "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')";
            mysqli_query($con, $add_like_query);

            // Actualizează numărul de like-uri pentru postare
            $update_like_count_query = "UPDATE posts SET like_count = like_count + 1 WHERE post_id = '$post_id'";
            mysqli_query($con, $update_like_count_query);
        }
    }
}

$search_tag = "";
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_tag = mysqli_real_escape_string($con, $_GET['search']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InspireSphere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="feed.css"> 
    <link rel="stylesheet" href="chaty.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: var(--color-cream);
            background: var(--color-dark);
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .left, .middle, .right {
            flex: 1;
        }
        .create-post {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .create-post input[type="text"] {
            width: calc(100% - 100px);
            margin-right: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .create-post input[type="submit"] {
            width: 100px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .feeds {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 20px;
        }
        .feed {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .feed img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
            z-index: -1;
        }
        .feed .profile-photo-small {
            width: 70px;
            height: 70px;
            border-radius: 50%; /* Pentru a face imaginea să fie într-un cerc */
            overflow: hidden; /* Pentru a ascunde orice parte a imaginii care depășește bordura circulară */
            margin-right: 10px;
            margin-top: -30px;
        }
        .feed h3 {
            margin: 0 0 10px;
           
        }
        .feed p {
            margin: 0;
            color: var(--secondary-color);
        }
        .feed h2{
            margin: 0;
            color: var(--primary-color);
            cursor: pointer;
        }
        .profile-photo-small {
            width: 30px;
            height: 30px;
            border-radius: 50%; /* Pentru a face imaginea să fie într-un cerc */
            overflow: hidden; /* Pentru a ascunde orice parte a imaginii care depășește bordura circulară */
            margin-right: 10px;
        }
        .profile-photo-small img {
            width: 100%;
            height: auto;
        }

        .like-button.liked {
            background-color: #ff69b4; /* Roz */
            color: #fff; /* Text alb */
        }

        /* Stil pentru containerul de comentarii */
.comments-container {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #ccc;
}
    </style>
</head>
<body>
<nav>
    <div class="container">
        <h2 class="log">InspireSphere</h2>
        <div class="search-bar">
            <form method="get">
                <input type="search" name="search" placeholder="Search anything of interest">
                <input type="submit" class ="btn btn-primary"value="Search">
            </form>
        </div>
        <div class="create">
        <a class="btn btn-primary" href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
            <div class="profile-photo-small">
                <div class="profile-photo-small">
                    <?php 
                        // Conectare la baza de date și interogare pentru a obține informațiile despre utilizatorul curent
                        include_once "db_config.php";
                        $sql = mysqli_query($con, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                        if(mysqli_num_rows($sql) > 0){
                            $row = mysqli_fetch_assoc($sql);
                            // Afiseaza imaginea de profil a utilizatorului curent
                            echo "<img src='php/images/{$row['img']}' alt='Profile Picture'>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="container">
        <div class="left">

            <div class="sidebar">
                <a class="menu-item active">
                    <span><i class="fas fa-home"></i></span><h3>Home</h3>
                </a>
                <a class="menu-item" id="profileLink">
                    <span><i class="fas fa-user"></i></span><h3>Profile</h3>
                </a>
                <a class="menu-item" id="messagesLink">
                    <span><i class="fas fa-envelope"></i></span><h3>Messages</h3>
                </a>
                <a class="menu-item" id="theme">
                    <span><i class="fas fa-paint-brush"></i></span><h3>Theme</h3>
                </a>
            </div>
        </div>

        <div class="middle" style="background-image: url('<?php echo $background_image_path; ?>');">
        <form class="create-post">
    <!-- Afiseaza poza de profil a utilizatorului -->
    <div class="profile-photo-small">
        <?php 
            $sql = mysqli_query($con, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
                echo "<img src='php/images/{$row['img']}' alt='Profile Picture'>";
            }
        ?>
    </div>
    <!-- Afiseaza doar numele contului utilizatorului -->
    <div class="handle">
        <?php 
            if(mysqli_num_rows($sql) > 0){
                echo "<h4>{$row['fname']} {$row['lname']}</h4>";
            }
        ?>
    </div>
    <!-- Schimba placeholder-ul la numele contului și emailul utilizatorului -->
    <div class="email"><?php echo "{$row['email']}" ?></div>
    <!-- Schimba textul butonului la "Create" -->
    <a class="butn" href="postarile.php">Create</a>
</form>


<div class="feeds">
    <?php
    // Modifică interogarea pentru a include funcționalitatea de căutare
    $query = "SELECT posts.*, users.fname, users.lname, users.img AS profile_img, COUNT(likes.like_id) AS like_count
              FROM posts 
              INNER JOIN users ON posts.user_id = users.unique_id 
              LEFT JOIN likes ON posts.post_id = likes.post_id
              WHERE posts.post_text LIKE '%$search_tag%' OR users.fname LIKE '%$search_tag%' OR users.lname LIKE '%$search_tag%' OR posts.star_tags LIKE '%$search_tag%'
              GROUP BY posts.post_id
              ORDER BY posts.created_at DESC";

    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // Afisează fiecare postare din feed
            echo "<div class='feed'>";
            echo "<img src='uploads/{$row['post_image']}' alt='Post Image'>";
            echo "<div class='post-details'>";
            echo "<div class='profile-photo-small'>";
            echo "<img src='php/images/{$row['profile_img']}' alt='Profile Picture'>";
            echo "</div>";
            echo "<h2 data-user-id='{$row['user_id']}'>{$row['fname']} {$row['lname']}</h2>";
            echo "<h3>{$row['post_text']}</h3>";
            echo "<p><b>Created at:</b> {$row['created_at']}</p>";

            if (!empty($row['star_tags'])) {
                echo "<div class='hash-container'>";
                echo "<div class='hashtags'>Star Tags:</div>";
                $tags = explode(',', $row['star_tags']);
                foreach ($tags as $tag) {
                    echo "<span class='hashtag'><i class='fas fa-star'></i> $tag</span>";
                }
                echo "</div>";
            }

            // Butonul de like și numărul de like-uri pentru fiecare postare
            echo "<form method='post'>";
            echo "<input type='hidden' name='like_post_id' value='{$row['post_id']}'>";
            echo "<button type='submit' class='like-btn' data-post-id='{$row['post_id']}'>";
            echo "<i class='fas fa-heart'></i><b> Like </b> "; // Heart icon
            echo "<span class='like-count'>{$row['like_count']}</span>"; // Like count
            echo "</button>";
            echo "</form>";

            // Displaying comments container
            echo "<div class='comments-container' data-post-id='{$row['post_id']}'>";
            $queryComments = "SELECT comments.*, users.fname, users.lname 
                              FROM comments 
                              INNER JOIN users ON comments.user_id = users.unique_id 
                              WHERE comments.post_id = '{$row['post_id']}' 
                              ORDER BY comments.created_at ASC";
            $resultComments = mysqli_query($con, $queryComments);
            while ($comment = mysqli_fetch_assoc($resultComments)) {
                echo "<div class='comment'>";
                echo "<span>{$comment['fname']} {$comment['lname']}</span>";
                echo "<span>{$comment['created_at']}</span>";
                echo "<p>{$comment['comment_text']}</p>";
                echo "</div>";
            }
            echo "</div>"; // Close comments container

            // Comment button
            echo "<button class='com-btn' data-post-id='{$row['post_id']}'><b>Comment</b></button>";

            // Comment form
            echo "<div class='comment-popup' data-post-id='{$row['post_id']}' style='display: none;'>";
            echo "<form class='comment-form'>";
            echo "<input type='hidden' name='post_id' class='post_id' value='{$row['post_id']}'>";
            echo "<textarea class='comment-input' name='comment_text' placeholder='Add a comment...' data-post-id='{$row['post_id']}'></textarea>";
            echo "<button type='submit' class='post-comment-button'>Post Comment</button>";
            echo "</form>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
        }
    }
        ?>
</div>
</div>

        <div class="right">
        <div class="tags-ranking">
    <div class="heading">
        <h4><i class='fas fa-star'></i> StarTags Ranking</h4>
    </div>
    <?php
    // Interogare pentru a obține cele mai folosite tag-uri și numărul de postări asociate fiecărui tag
    $tag_query = "SELECT tag, COUNT(*) AS post_count 
                  FROM (
                      SELECT post_id, SUBSTRING_INDEX(SUBSTRING_INDEX(star_tags, ',', n.digit+1), ',', -1) tag
                      FROM posts
                      INNER JOIN (
                          SELECT 0 digit UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
                      ) n ON LENGTH(REPLACE(star_tags, ',' , '')) <= LENGTH(star_tags)-n.digit
                  ) tags
                  GROUP BY tag
                  ORDER BY post_count DESC";

    $tag_result = mysqli_query($con, $tag_query);

    if (mysqli_num_rows($tag_result) > 0) {
        echo "<div class='tags'>";
        while ($tag_row = mysqli_fetch_assoc($tag_result)) {
            echo "<div class='tag'>";
            echo "<span class='star-icon'><i class='fas fa-star'></i></span>";
            echo "<span>{$tag_row['tag']}</span>";
            echo "<span class='post-count'>{$tag_row['post_count']}</span>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No tags to display.</p>";
    }
    ?>
</div>
<div class="chat-container">
    <div class="chat-circle" onclick="toggleChatBox()">
        <i class="fas fa-comment"></i>
    </div>
    <div class="chat-box">
        <button class="close-btn" onclick="toggleChatBox()">X</button>
        <div class="chat-box-header">
            <h2>HelpChaty</h2>
        </div>
            <div class="wrapper">
                <div class="form">
                    <div class="bot-inbox inbox">
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="msg-header">
                            <p>Hello there, how can I help you?</p>
                        </div>
                    </div>
                </div>
                <div class="typing-field">
                    <div class="input-data">
                        <input id="data" type="text" placeholder="Type something here.." required>
                        <button id="send-btn">Send</button>
                    </div>
                    <script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                
                // start ajax code
                $.ajax({
                    url: 'chatbot/.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>

        </div>
    </div>
</div>

    
</main>

<div class="customize-theme">
    <div class="card">
        <h2>Customize your experience</h2>
        <p class="text-muted">Manage your font size, color, and background</p>

        <div class="font-size">
            <h4>Font Size</h4>
            <div>
                <h6>Aa</h6>
                <div class="choose-size">
                    <span class="font-size-1"></span>
                    <span class="font-size-2"></span>
                    <span class="font-size-3 active"></span>
                    <span class="font-size-4"></span>
                    <span class="font-size-5"></span>
                </div>
                <h3>Aa</h3>
            </div>
        </div>

        <div class="color">
            <h4>Color</h4>
            <div class="choose-color">
                <span class="color-1 active"></span>
                <span class="color-2"></span>
                <span class="color-3"></span>
                <span class="color-4"></span>
                <span class="color-5"></span>
            </div>
        </div>
    </div>
</div>

<script src="./feed.js"></script>
<script src="./comment.js"></script>
<script>
// Script pentru gestionarea comentariilor
document.addEventListener('DOMContentLoaded', function() {
    const commentButtons = document.querySelectorAll('.comment-button');
    commentButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const commentPopup = document.querySelector(`.comment-popup[data-post-id="${postId}"]`);
            if (commentPopup.style.display === 'block') {
                commentPopup.style.display = 'none';
            } else {
                commentPopup.style.display = 'block';
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
            const commentButtons = document.querySelectorAll('.com-btn');
            commentButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const postId = button.dataset.postId;
                    const commentPopup = document.querySelector(`.comment-popup[data-post-id='${postId}']`);
                    if (commentPopup.style.display === 'none' || commentPopup.style.display === '') {
                        commentPopup.style.display = 'block';
                    } else {
                        commentPopup.style.display = 'none';
                    }
                });
            });

            // Submit comment form
            const commentForms = document.querySelectorAll('.comment-form');
            commentForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const postId = this.querySelector('.post_id').value;
                    const commentInput = this.querySelector('.comment-input');
                    const commentText = commentInput.value.trim();

                    if (commentText !== '') {
                        $.ajax({
                            url: 'post_comment.php',
                            type: 'POST',
                            data: {
                                post_id: postId,
                                comment_text: commentText
                            },
                            success: function(response) {
                                const commentsContainer = document.querySelector(`.comments-container[data-post-id='${postId}']`);
                                commentsContainer.innerHTML += response;
                                commentInput.value = ''; // Clear the comment input field
                            },
                            error: function(xhr, status, error) {
                                alert('Error: ' + error);
                            }
                        });
                    } else {
                        alert('Please enter a comment.');
                    }
                });
            });
        });
        
    document.addEventListener('DOMContentLoaded', function () {
    const chatCircle = document.querySelector('.chat-circle');
    const chatBox = document.querySelector('.chat-box');
    const closeBtn = document.querySelector('.close-btn');

    // Ascunde caseta de chat când pagina se încarcă
    chatBox.style.display = 'none';

    // Afișează caseta de chat când butonul este apăsat
    chatCircle.addEventListener('click', function() {
        chatBox.style.display = 'block';
    });

    // Ascunde caseta de chat când butonul de închidere este apăsat
    closeBtn.addEventListener('click', function() {
        chatBox.style.display = 'none';
    });
});

        


</script>
</body>
</html>