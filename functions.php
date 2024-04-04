<?php 

session_start();

function signup($data)
{
	$errors = array();
 
	//validate 
	if(!preg_match('/^[a-zA-Z]+$/', $data['username'])){
		$errors[] = "Please enter a valid username";
	}

	if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
		$errors[] = "Please enter a valid email";
	}

	if(strlen(trim($data['password'])) < 4){
		$errors[] = "Password must be atleast 4 chars long";
	}

	if($data['password'] != $data['password2']){
		$errors[] = "Passwords must match";
	}

	$check = database_run("select * from users where email = :email limit 1",['email'=>$data['email']]);
	if(is_array($check)){
		$errors[] = "That email already exists";
	}

	//save
	if(count($errors) == 0){

		$arr['username'] = $data['username'];
		$arr['email'] = $data['email'];
		$arr['password'] = hash('sha256',$data['password']);
		$arr['created_at'] = date("Y-m-d H:i:s");

		$query = "insert into users (username,email,password,created_at) values 
		(:username,:email,:password,:created_at)";

		database_run($query,$arr);
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
	if(count($errors) == 0){

		$arr['email'] = $data['email'];
		$password = hash('sha256', $data['password']);

		$query = "select * from users where email = :email limit 1";

		$row = database_run($query,$arr);

		if(is_array($row)){
			$row = $row[0];

			if($password === $row->password){
				
				$_SESSION['USER'] = $row;
				$_SESSION['LOGGED_IN'] = true;
				header("Location: profile.php");
			}else{
				$errors[] = "wrong email or password";
			}

		}else{
			$errors[] = "wrong email or password";
		}
	}
	return $errors;
}

function database_run($query,$vars = array())
{
	$string = "mysql:host=localhost;dbname=inspiresphere";
	$con = new PDO($string,'root','');

	if(!$con){
		return false;
	}

	$stm = $con->prepare($query);
	$check = $stm->execute($vars);

	if($check){
		
		$data = $stm->fetchAll(PDO::FETCH_OBJ);
		
		if(count($data) > 0){
			return $data;
		}
	}

	return false;
}

function check_login($redirect = true){

	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

		return true;
	}

	if($redirect){
		header("Location: login1.php");
		die;
	}else{
		return false;
	}
	
}

function check_verified(){

	$id = $_SESSION['USER']->id;
	$query = "select * from users where id = '$id' limit 1";
	$row = database_run($query);

	if(is_array($row)){
		$row = $row[0];

		if($row->email == $row->email_verificated){

			return true;
		}
	}
 
	return false;
 	
}






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