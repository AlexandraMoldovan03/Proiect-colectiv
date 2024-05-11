<?php 
session_start();
require_once "functions.php";

if(isset($_SESSION['unique_id'])){
    // Verificăm dacă contul este verificat sau nu
    $verified = check_verified(); // Ai deja o funcție `check_verified` implementată în `functions.php`?
    if(!$verified) {
        // Contul nu este verificat, redirecționăm utilizatorul către pagina de verificare
        header("location: profile.php");
        exit();
    } else {
        // Contul este verificat, redirecționăm utilizatorul către pagina feed.html
        header("location: feed.html");
        exit();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validare adresa de email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        // Email invalid, redirecționăm utilizatorul către pagina de verificare a emailului
        header("location: verify_email.php?email=$email");
        exit();
    }

    // Verificăm autentificarea
    $loggedIn = login($email, $password);

    if($loggedIn) {
        // Verificăm dacă profilul este verificat
        $verified = check_verified(); // Ai deja o funcție `check_verified` implementată în `functions.php`?

        if(!$verified) {
            // Contul nu este verificat, redirecționăm utilizatorul către pagina de verificare
           // header("location: verify.php");
           header("location: profile.php");
            exit();
        } else {
            // Contul este verificat, redirecționăm utilizatorul către pagina feed.html
            header("location: feed.html");
            exit();
        }
    } else {
        // Autentificarea a eșuat
        echo "Invalid email or password. Please try again.";
    }
}
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>Realtime Chat App</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
  <input type="submit" name="submit" value="Continue to Chat">
</div>
<div class="field button">
  <input type="button" class="button-feed" value="Continue to Feed">
</div>
      </form>
      <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
  </div>
  
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>

</body>
</html>
