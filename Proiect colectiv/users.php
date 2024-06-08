<?php 
  session_start();
  include_once "php/db_config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: feed.php");
  }
?>
<?php include_once "header.php"; ?>
<link rel="stylesheet" href="users.css">
<body>
<nav>
        <div class="container">
            <h2 class="log">
                InspireSphere
            </h2>
            <div class="create">
                <div class="profile-photo">
                <?php 
              $sql = mysqli_query($con, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
              if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
              }
            ?>
            <img src="php/images/<?php echo $row['img']; ?>" alt="">
                </div>
            </div>
        </div>
    </nav>
  <div class="container">
    <div class="left">
    <a class="profile">
                    <div class="profile-photo">
                    <?php 
              $sql = mysqli_query($con, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
              if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
              }
            ?>
            <img src="php/images/<?php echo $row['img']; ?>" alt="">
                    </div>
                    <div class="handle">
                        <h4><?php echo $row['fname']. " " . $row['lname'] ?></h4>
                        <p class="text-muted">
                          <div class="email">
                        <?php echo "{$row['email']}" ?>
            </div>
                        </p>
                    </div>
                </a>
      <div class="sidebar">
        <a class="menu-item" id="homeLink">
          <span><i class="fas fa-home"></i></span><h3>Home</h3>
        </a>
        <a class="menu-item" id="profileLink">
          <span><i class="fas fa-user"></i></span><h3>Profile</h3>
        </a>
        <a class="menu-item active" id="messagesLink">
          <span><i class="fas fa-envelope"></i></span><h3>Messages</h3>
        </a>
      </div>
    </div>
</div>
    <div class="container">
    <div class="middle">
    <div class="wrapper">
      <section class="users">
        <header>
          <div class="content">
            <?php 
              $sql = mysqli_query($con, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
              if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
              }
            ?>
            <img src="php/images/<?php echo $row['img']; ?>" alt="">
            <div class="details">
              <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
              <p><?php echo $row['status']; ?></p>
            </div>
          </div>
          <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
        </header>
        <div class="search">
          <span class="text">Select a user to start chat</span>
          <input type="text" placeholder="Enter name to search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        <div class="users-list">
          <!-- User list content goes here -->
        </div>
      </section>
    </div>
  </div>
  <div class="right">
        <!-- Right sidebar or additional content -->
    </div>
            </div>
            </div>

  <script src="javascript/users.js"></script>

</body>
</html>
