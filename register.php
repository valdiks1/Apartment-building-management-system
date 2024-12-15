<?php

	require "connection.php";

	$err=[];

    
    $link = mysqli_connect($host, $user, $password, $datebase);

    if (isset($_POST['register'])) {
    	if(strlen($_POST['registerName']) < 3 or strlen($_POST['registerName']) > 50) {
        	$err[] = "Meno musí mať najmenej 3 znaky a najviac 50.";
    	}
    	$query = mysqli_query($link, "SELECT id FROM users WHERE email='".mysqli_real_escape_string($link, $_POST['registerEmail'])."'");
    	if(mysqli_num_rows($query) > 0){
        	$err[] = "Používateľ s takýmto e-mailom už existuje v databáze.";
    	}
    	if(strlen($_POST['registerPassword']) < 8){
    		$err[] = "Heslo musí obsahovať viac ako 8 znakov.";
    	}

    	if(count($err) == 0) {

    		$email = $_POST['registerEmail'];
    		$password = md5($_POST['registerPassword']);
    		$name = $_POST['registerName'];

    		mysqli_query($link,"INSERT INTO users SET name='".$name."', email='".$email."', password='".$password."'");
			
        	header("Location: index.php"); exit();
    	}
    	
    }


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
    		<h5 class="card-title">Registrácia</h5>
    		
    		<form method="post" action="">
  				<div class="form-group">
    				<label for="exampleInputEmail1">Email</label>
    				<input name="registerEmail" placeholder="Zadajte svoju e-mailovú adresu" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
  				</div>
  				<div class="form-group">
				   <label for="exampleInputName">Meno a priezvisko</label>
				   <input name="registerName" placeholder="Zadajte svoje meno a priezvisko" type="text" class="form-control" id="exampleInputName" required>
				</div>
				<div class="form-group">
				   <label for="exampleInputPassword1">Пароль</label>
				   <input name="registerPassword" placeholder="Zadajte heslo" type="password" class="form-control" id="exampleInputPassword1" required>

				   <p style="color: red">
				   	<?php
				   		foreach($err AS $error) {
            				print $error."<br>";
        					}
				   	?>
				   </p>
				</div>
  				<input name="register" type="submit" value="Vytvoriť účet" class="btn btn-primary">
			</form>

    		<a href="index.php" class="card-link">Vrátiť sa na hlavnú stránku</a>
  		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>