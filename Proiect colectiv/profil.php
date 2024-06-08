<?php 
session_start();
include_once "db_config.php";
if(!isset($_SESSION['unique_id'])){
    header("location: feed.php");
    exit(); // Add exit to prevent further execution
}

include_once "header.php"; 

// Fetch user posts
$user_id = $_SESSION['unique_id'];
$posts_query = mysqli_query($con, "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY created_at DESC");

if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['about_me'])){
    $user_id = $_SESSION['unique_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $about_me = $_POST['about_me'];

    // Update user data in the database
    $update_query = mysqli_query($con, "UPDATE users SET fname='$fname', lname='$lname', about_me='$about_me' WHERE unique_id='$user_id'");
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
        $sql = mysqli_query($con, "SELECT * FROM users WHERE unique_id = '$user_id'");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
        }
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
        <div class="edit-profile">
            <button onclick="editProfile()">Edit Profile</button>
        </div>
        <div class="profileForm" id="profileForm" style="display: none;">
            <h2>Edit Profile</h2>
            <form class="editProfileForm"id="editProfileForm" method="post">
                <label for="fname">First Name:</label>
                <input class ="search-bar" type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($row['fname']); ?>" required><br><br>
                <label for="lname">Last Name:</label>
                <input class ="search-bar" type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($row['lname']); ?>" required><br><br>
                <label for="about_me">About Me:</label>
                <textarea class ="search-bar" id="about_me" name="about_me" required><?php echo htmlspecialchars($row['about_me']); ?></textarea><br><br>
                <label for="email">Email:</label>
                <input class ="search-bar" type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" readonly><br><br>
                <div class="edit-profile button">
                <button type="submit">Save</button>
                <button type="button" onclick="cancelEdit()">Cancel</button>
                </div>
            </form>
        </div>
        <h2>Posts</h2>
        <div class="posts">
        <?php 
        while($post = mysqli_fetch_assoc($posts_query)) {
            echo '<div class="post">';
            // Check if the 'post_image' key exists and is not null
            if (!empty($post['post_image'])) {
                echo "<img src='uploads/{$post['post_image']}' alt='Post Image'>";
            } else {
                echo '<img src="post-placeholder.jpg" alt="New Post">';
            }
            echo '<div class="post-content"><p>' . htmlspecialchars($post['post_text']) . '</p></div>';
            echo '</div>';
        }
        ?>
        </div>

    <script src="./profil.js"></script>
    <script>
        function editProfile() {
            document.getElementById('profileForm').style.display = 'block';
        }

        function cancelEdit() {
            document.getElementById('profileForm').style.display = 'none';
        }
    </script>
</body>
</html>
