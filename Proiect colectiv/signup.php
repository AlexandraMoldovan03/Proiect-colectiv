<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = signup($_POST);

	if(count($errors) == 0)
	{
		header("Location: login1.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Signup</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
</head>
<body>
	

	<?//php include('navbar.php')?>
<h1>Signup</h1>
	<div>
		<div>
			<?php if(count($errors) > 0):?>
				<?php foreach ($errors as $error):?>
					<?= $error?> <br>	
				<?php endforeach;?>
			<?php endif;?>

		</div>
		<form method="post">
			<input type="text" name="username" placeholder="Username"><br>
			<input type="text" name="email" placeholder="Email"><br>
			<input type="text" name="password" placeholder="Password"><br>
			<input type="text" name="password2" placeholder="Retype Password"><br>
			<br>
			<input type="submit" value="Signup">
		</form>
	</div>
</body>
</html>