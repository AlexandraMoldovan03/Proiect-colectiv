<?php
$email = $_GET['email'];

// Verificarea validității adresei de email
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    // Adresa de email este invalidă, ar trebui să redirecționăm utilizatorul către o pagină de eroare sau să-l întoarcem la pagina anterioară
    // Poți să adaugi aici logica necesară pentru redirecționare
    exit("Invalid email address");
}

// Verificare dacă adresa de email este deja în baza de date sau nu
// Aici trebuie să adaugi logica pentru a verifica dacă adresa de email este deja în baza de date sau nu
// Dacă adresa de email există deja, poți să decizi să-l redirecționezi către o altă pagină sau să-l trimiți înapoi la pagina anterioară
// În acest exemplu, vom presupune că adresa de email este validă și nu există deja în baza de date

// Trimitem emailul de verificare
$message = "Your verification code is: " . rand(10000, 99999);
$subject = "Email Verification";
send_mail($email, $subject, $message);

// Redirecționăm utilizatorul către pagina unde poate introduce codul de verificare
header("location: verify_email_code.php?email=$email");
exit();
?>
