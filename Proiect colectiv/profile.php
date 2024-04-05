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
        <button id="verifyButton">Verify Profile</button>
<?php endif; ?>

<!-- Scriptul JavaScript -->
<script>
document.getElementById("verifyButton").addEventListener("click", function() {
  // Afisam mesajul sub forma unui pop-up
  var agreement = confirm("Prin continuarea, ești de acord cu termenii și condițiile și prelucrarea datelor. Apasă OK pentru a continua sau Anulează pentru a rămâne pe această pagină.");

  // Verificăm dacă utilizatorul a acceptat sau nu
  if (agreement) {
    // Utilizatorul a acceptat, continuăm cu verificarea profilului
    window.location.href = "verify.php";
  } else {
    // Utilizatorul a refuzat, nu facem nimic
  }
});
</script>