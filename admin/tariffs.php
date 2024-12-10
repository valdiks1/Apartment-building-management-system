<?php
	ini_set('display_errors', 1);
    error_reporting(E_ALL);

	require "../connection.php";

	if(isset($_POST['logoutAdmin'])){
		setcookie("user", "", time() - 3600*24*30*12, "/");

		header("Location: ../");
	}

	$link = mysqli_connect($host, $user, $password, $datebase);

	$result = mysqli_query($link, "SELECT * FROM tariffs");
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

	if(isset($_POST['addSubmit'])){
		$name=$_POST['addName'];
		$ms=$_POST['addMs'];
		$tariff=$_POST['addTariff'];
		if(isset($_POST['hasMeter'])){
			$addTariff = mysqli_query($link, "INSERT INTO tariffs SET name='".$name."', ms='".$ms."', tariff='".$tariff."', hasMeter=true");	
		}else{
			$addTariff = mysqli_query($link, "INSERT INTO tariffs SET name='".$name."', ms='".$ms."', tariff='".$tariff."', hasMeter=false");
		}

		header("Location: tariffs.php");
	}

	if(isset($_POST['deleteSubmit'])){
		$id=$_POST['deleteId'];
		$deleteNews = mysqli_query($link, "DELETE FROM tariffs WHERE id='".$id."'");

		header("Location: tariffs.php");
	}

	if(isset($_POST['editSubmit'])){
		$editId = $_POST['editId'];
		$editName = $_POST['editName'];
		$editMs = $_POST['editMs'];
		$editTariff = $_POST['editTariff'];

		$editTariffQuery = mysqli_query($link, "UPDATE tariffs SET name='".$editName."', ms='".$editMs."', tariff='".$editTariff."' WHERE id=".$editId);

		header("Location: tariffs.php");
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

		<!-- <h1>Admin</h1>
		<form method="post" action="">
			<input type="submit" name="logoutAdmin" value="logout">
		</form> -->



		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  			<a class="navbar-brand" href="#">Admin panel</a>
  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Переключатель навигации">
    			<span class="navbar-toggler-icon"></span>
  			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			  <div class="navbar-nav">
			    <a class="nav-link" href="../">Hlavná </a>
			    <a class="nav-link" href="adminPage.php">Novinky</a>
			    <a href="contacts.php" class="nav-link">Kontakty</a>
			    <a href="mainInfo.php" class="nav-link">Pozdrav</a>
			    <a href="applications.php" class="nav-link">Žiadosti</a>
			    <a href="rule.php" class="nav-link">Riaditeľstvo</a>
			    <a href="tariffs.php" class="nav-link active">Tarify</a>
			    <a class="nav-link disabled" href="questions.php">Dotazník</a>
			    <form method="post" action="">
					<input class="btn btn-outline-light" type="submit" name="logoutAdmin" value="Odhlásiť sa">
				</form> 
			  </div>
			</div>
		</nav>

		<div class="container" style="padding-top: 15px;">

			<button style="margin-bottom: 15px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#tariffsModal">
				Pridať
			</button>

			<div class="modal fade" id="tariffsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class="modal-dialog" role="document">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="exampleModalLabel">Pridať tarif</h5>
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          						<span aria-hidden="true">&times;</span>
        					</button>
      					</div>
      					<div class="modal-body">
        					<form action="" method="post">
								<div class="form-group">
									<label for="addName">Názov:</label>
									<input id="addName" type="text" class="form-control" name="addName">
								</div>
								<div class="form-group">
									<label for="addMs">Sústava merania</label>
									<input type="text" id="addMs" name="addMs" class="form-control">
								</div>
								<div class="form-group">
									<label for="addTariff">Tarifa</label>
									<input name="addTariff" id="addTariff" type="number" class="form-control" step="any">
								</div>
								<div class="form-group">
									<input id="hasMeter" name="hasMeter" type="checkbox">
									<label for="hasMeter">Počíta sa s meračom</label>
								</div>
								<input value="Pridať" type="submit" name="addSubmit" class="btn btn-primary">
							</form>
      					</div>
    				</div>
  				</div>
			</div>

			


			<table class="table table-striped">
  				<thead>
    				<tr>
      					<th scope="col">Názov</th>
      					<th scope="col">Sústava merania</th>
      					<th scope="col">Tarifa</th>
						<th scope="col">Akcie</th>
    				</tr>
  				</thead>
				<tbody>
				    <?php
				    	foreach($rows as $row){
				    		echo "
				    			<tr>
									<form action='' method='post'>
										<input type='hidden' name='editId' value='" . $row['id'] . "'>
				      					<td><input class='form-control' type='text' name='editName' value='" . $row['name'] . "'></td>
				      					<td><input class='form-control' type='text' name='editMs' value='" . $row['ms'] . "'></td>
				      					<td>
											<div class='row'>
												<div class='col'><input class='form-control' type='number' step='any' name='editTariff' value='" . $row['tariff'] . "'></div>
												<div class='col'>&#8364;</div>
											</div>
										</td>
										<td>
										<input value='Zmeniť' name='editSubmit' type='submit' class='btn btn-warning'>
										<form action='' method='post'>
											<input value='" . $row['id'] . "' type='hidden' name='deleteId'>
											<input type='submit' name='deleteSubmit' value='Odstrániť' class='btn btn-danger'>
										</form>
									</form>
										
									</td>
				    			</tr>
				    		";
				    	}
				    ?>
				  </tbody>
				</table>
		</div>

<?php endif; ?>

	<?php if($_COOKIE['user'] !== 'admin') : ?>
		<h1>no Admin</h1>
	<?php endif; ?>

	

	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>