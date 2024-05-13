<?php

session_start();

function signup($data)
{
    $errors = array();

    // Validează datele de intrare
    if(!preg_match('/^[a-zA-Z]+$/', $data['username'])){
        $errors[] = "Please enter a valid username";
    }

    if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    if(strlen(trim($data['password'])) < 4){
        $errors[] = "Password must be at least 4 chars long";
    }

    if($data['password'] != $data['password2']){
        $errors[] = "Passwords must match";
    }

    // Verifică dacă există deja un utilizator cu adresa de email furnizată
    $check = database_run("SELECT * FROM users WHERE email = :email LIMIT 1", ['email' => $data['email']]);
    if(is_array($check)){
        $errors[] = "That email already exists";
    }

    // Salvează datele în baza de date dacă nu există erori
    if(count($errors) == 0){
        $arr['username'] = $data['username'];
        $arr['email'] = $data['email'];
        $arr['password'] = hash('sha256',$data['password']);
        $arr['created_at'] = date("Y-m-d H:i:s");

        // Generare unique_id și status
        $unique_id = rand(100000,999999); // Generare random pentru unique_id
        $status = "Active"; // Setarea statusului

        // Adăugarea unique_id și status în array-ul de date pentru inserare în baza de date
        $arr['unique_id'] = $unique_id;
        $arr['status'] = $status;

        // Interogare SQL pentru inserarea datelor în baza de date
        $query = "INSERT INTO users (username, email, password, created_at, unique_id, status) VALUES (:username, :email, :password, :created_at, :unique_id, :status)";
        database_run($query, $arr);
    }

    return $errors;
}






function login($data)
{
		$errors = array();
	 
		$adminEmail = 'admin@gmail.com';
		$adminPassword = 'parola_admin';
	
		$inputEmail = isset($data['email']) ? $data['email'] : null;
		$inputPassword = isset($data['password']) ? $data['password'] : null;
	


		// Verifica dacă array-ul $data conține cheia 'username' înainte de a încerca să o accesezi
		$inputUsername = isset($data['email']) ? $data['email'] : null;
		$inputPassword = isset($data['password']) ? $data['password'] : null;
	
		if ($inputEmail == $adminEmail && $inputPassword == $adminPassword) {
			// Autentificare cu succes pentru administrator
			$_SESSION['admin_authenticated'] = true;
			header("Location: admin.php");
			die();
		}


	//validate 
	if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
		$errors[] = "Please enter a valid email";
	}

	if(strlen(trim($data['password'])) < 4){
		$errors[] = "Password must be atleast 4 chars long";
	}
 
	//check
	 if (count($errors) == 0) {
    $arr['email'] = $data['email'];
    $password = hash('sha256', $data['password']);

    $query = "select * from users where email = :email limit 1";

    $row = database_run($query, $arr);

    if (is_array($row)) {
      $row = $row[0];

      if ($password === $row->password) {
        // Check user verification status
        if ($row->email_verified === $row->email) {
          // User is verified, redirect to feed
          $_SESSION['USER'] = $row;
          $_SESSION['LOGGED_IN'] = true;
          header("Location: feed.html");
          die();
        } else {
          // User is not verified, redirect to verification page
          header("Location: verify.php");
          die();
        }
      } else {
        $errors[] = "wrong email or password";
      }
    } else {
      $errors[] = "wrong email or password";
    }
  }
  return $errors;
}

function database_run($query, $vars = array())
{
    try {
        $string = "mysql:host=localhost;dbname=inspiresphere";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        echo "SQL Query: $query <br>";
        echo "Bound Variables: ";
        var_dump($vars);

        $stm = $con->prepare($query);
        $check = $stm->execute($vars);

        if ($check) {

            $data = $stm->fetchAll(PDO::FETCH_OBJ);

            if (count($data) > 0) {
                return $data;
            }
        }

        return false;
    } catch (PDOException $e) {
        echo "Error connecting to database: " . $e->getMessage();
        return false;
    }
}


// function check_login($redirect = true){

// 	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

// 		return true;
// 	}

// 	if($redirect){
// 		header("Location: login.php");
// 		die;
// 	}else{
// 		return false;
// 	}
	
// }


function check_login($redirect = true) {

	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])) {
	  // Check user verification status
	  if (check_verified()) {
		return true; // User is verified, allow access
	  } else {
		// User is not verified, redirect to verification
		header("Location: verify.php");
		die();
	  }
	}
  
	if($redirect) {
	  header("Location: login.php");
	  die;
	} else {
	  return false;
	}
  }

// function check_verified(){
	
// 	$user_id = $_SESSION['USER']->user_id;
// 	$query = "select * from users where user_id = '$user_id' limit 1";
// 	$row = database_run($query);

// 	if(is_array($row)){
// 		$row = $row[0];

// 		if($row->email == $row->email_verificated){

// 			return true;
// 		}
// 	}
 
// 	return false;
 	
// }


function check_verified(){
  // Verificăm dacă utilizatorul este autentificat și dacă profilul său este verificat
  if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){
      // Verificăm dacă email-ul utilizatorului a fost verificat
      if($_SESSION['USER']->email == $_SESSION['USER']->email_verified){
          // Profilul este verificat
          return true;
      }
  }
  // Dacă nu este îndeplinită condiția de mai sus, returnăm false
  return false;
}



// function check_verified(){
//     // Verificăm dacă utilizatorul este autentificat și dacă profilul său este verificat
//     if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){
//         // Verificăm dacă email-ul utilizatorului a fost verificat
//         if($_SESSION['USER']->email == $_SESSION['USER']->email_verificated){
//             // Profilul este verificat
//             return true;
//         }
//     }
//     // Dacă nu este îndeplinită condiția de mai sus, returnăm false
//     return false;
// }




function addNews($title, $content) {
    try {
        $string = "mysql:host=localhost;dbname=inspiresphere";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        $query = "INSERT INTO news (title, content) VALUES (:title, :content)";
        $stm = $con->prepare($query);
        $stm->bindParam(':title', $title, PDO::PARAM_STR);
        $stm->bindParam(':content', $content, PDO::PARAM_STR);
        $result = $stm->execute();

        return $result;
    } catch (PDOException $e) {
        return false;
    }
}




function getAllNews() {
    try {
        $string = "mysql:host=localhost;dbname=inspiresphere";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        $query = "SELECT * FROM news ORDER BY date DESC";
        $stm = $con->query($query);
        $news = $stm->fetchAll(PDO::FETCH_OBJ);

        return $news;
    } catch (PDOException $e) {
        return false;
    }
}
?>

