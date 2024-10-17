<?php
	require "../connection.php";

	if(isset($_POST['logoutAdmin'])){
		setcookie("user", "", time() - 3600*24*30*12, "/");

		header("Location: ../");
	}

	$link = mysqli_connect($host, $user, $password, $datebase);

	$ruleAll = mysqli_query($link, "SELECT * FROM rule");
    $rule = mysqli_fetch_all($ruleAll, MYSQLI_ASSOC);

    if(isset($_POST['changeRule']) && $_POST['name'] !== '' && $_POST['state'] !== ''){
    	$ruleChange = mysqli_query($link, "UPDATE rule SET name='".$_POST['name']."', state='".$_POST['state']."' WHERE id=".$_POST['idEdit']);

    	header("Location: rule.php");
    }

    if(isset($_POST['ruleAdd']) && $_POST['nameAdd'] !== '' && $_POST['stateAdd'] !== ''){
    	$ruleAdd = mysqli_query($link, "INSERT INTO rule SET name='".$_POST['nameAdd']."', state='".$_POST['stateAdd']."'");

    	header("Location: rule.php");
    }

    if(isset($_POST['deleteRule'])){
    	$ruleDelete = mysqli_query($link, "DELETE  FROM rule WHERE id=".$_POST['idDelete']);
    	
    	header("Location: rule.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Môj dom</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
	<?php if($_COOKIE['user'] == 'admin') : ?>

		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  			<a class="navbar-brand" href="#">Admin panel</a>
  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Переключатель навигации">
    			<span class="navbar-toggler-icon"></span>
  			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			  <div class="navbar-nav">
			    <a class="nav-link" href="../">Hlavná</a>
			    <a class="nav-link " href="adminPage.php">Novinky</a>
			    <a href="contacts.php" class="nav-link">Kontakty</a>
			    <a href="mainInfo.php" class="nav-link">Pozdrav</a>
			    <a href="applications.php" class="nav-link">Žiadosti</a>
			    <a href="rule.php" class="nav-link active">Riaditeľstvo</a>
			    <a class="nav-link disabled" href="questions.php">Dotazník</a>
			    <form method="post" action="">
					<input class="btn btn-outline-light" type="submit" name="logoutAdmin" value="Odhlásiť sa">
				</form> 
			  </div>
			</div>
		</nav>

		<div class="container">

			<button style='margin-top: 15px;' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  				Pridať 
			</button>

			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="exampleModalLabel">Pridať</h5>
        						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          							<span aria-hidden="true">&times;</span>
        						</button>
      					</div>
      					<div class="modal-body">
        					<form action="rule.php" method="post">
        						<div class="form-group">
        							<label for="">Pozícia:</label>
        							<input class='form-control' type="text" name="stateAdd">
        						</div>
        						<div class="form-group">
        							<label for="">Meno a priezvisko osoby:</label>
        							<input class='form-control' type="text" name="nameAdd">
        						</div>
        						<input type="submit" name='ruleAdd' value='Pridať' class="btn btn-primary">
        					</form>
      					</div>
    				</div>
  				</div>
			</div>

			<?php

			foreach ($rule as $item) {
				echo "<div class='card' style='margin-top: 15px;'>
				<div class='card-body'>
					<form action='rule.php' method='post'>
						<div class='form-group'>
							<input class='form-control' type='text' name='state' value='".$item['state']."'>
						</div>
						<div class='form-group'>
							<input class='form-control' type='text' name='name' value='".$item['name']."'>
						</div>
						<input type='hidden' name='idEdit' value='".$item['id']."'>
						<input type='submit' name='changeRule' value='Zmeniť' class='btn btn-warning'>
						<form action='rule.php'>
							<input type='hidden' name='idDelete' value='".$item['id']."'>
							<input type='submit' name='deleteRule' class='btn btn-danger' value='Odstrániť'>
						</form>
					</form>
				</div>
			</div>";
			}?>

			

		</div>

	<?php endif; ?>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>