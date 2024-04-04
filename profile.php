<?php
require "functions.php";
// Verifică dacă utilizatorul este autentificat și profilul său este verificat
$loggedIn = check_login(false); // Verifică dacă utilizatorul este autentificat
$verified = check_verified(); // Verifică dacă profilul utilizatorului este verificat

?>



<?php if($loggedIn && $verified): ?>
    Hi, <?=$_SESSION['USER']->username;?>;

    <br><br>

   

    <?php else: ?>
        <a href="verify.php">
            <button>Verify Profile</button>
        </a>
<?php endif; ?>


<br><br><br>


