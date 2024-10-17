<?php

	require "connection.php";

	$err=[];

    
    // Create connection
    $link = mysqli_connect($host, $user, $password, $datebase);

    if (isset($_POST['register'])) {
    	if(strlen($_POST['registerName']) < 3 or strlen($_POST['registerName']) > 50) {
        	$err[] = "Ім'я має бути не менше 3-х символів і не більше 50";
    	}
    	$query = mysqli_query($link, "SELECT id FROM users WHERE email='".mysqli_real_escape_string($link, $_POST['registerEmail'])."'");
    	if(mysqli_num_rows($query) > 0){
        	$err[] = "Користувач із такою поштою вже існує у базі даних";
    	}
    	if(strlen($_POST['registerPassword']) < 8){
    		$err[] = "Пароль має містити більше 8 символів";
    	}

    	if(count($err) == 0) {
    		//echo "done!";

    		$email = $_POST['registerEmail'];
    		$password = $_POST['registerPassword'];
    		$name = $_POST['registerName'];

    		mysqli_query($link,"INSERT INTO users SET name='".$name."', email='".$email."', password='".$password."'");

        	header("Location: index.php"); exit();
    	}else {
        	//print "<b>При регистрации произошли следующие ошибки:</b><br>";
        	//foreach($err AS $error) {
            	//print $error."<br>";
        	//}
    	}
    	
    }


// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Мій дім</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>

	<div class="card" style="width: 25rem; margin: 40px auto;">
  		<div class="card-body">
    		<h5 class="card-title">Реєстрація</h5>
    		
    		<form method="post" action="">
  				<div class="form-group">
    				<label for="exampleInputEmail1">Email</label>
    				<input name="registerEmail" placeholder="Введіть свою адресу електронної пошти" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
  				</div>
  				<div class="form-group">
				   <label for="exampleInputName">Ім'я та Прізвище</label>
				   <input name="registerName" placeholder="Введіть своє Ім'я та Прізвище" type="text" class="form-control" id="exampleInputName" required>
				</div>
				<div class="form-group">
				   <label for="exampleInputPassword1">Пароль</label>
				   <input name="registerPassword" placeholder="Введіть пароль" type="password" class="form-control" id="exampleInputPassword1" required>

				   <p style="color: red">
				   	<?php
				   		foreach($err AS $error) {
            				print $error."<br>";
        					}
				   	?>
				   </p>
				</div>
  				<input name="register" type="submit" value="Створити акаунт" class="btn btn-primary">
			</form>

    		<a href="index.php" class="card-link">Повернутися на головну</a>
  		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>