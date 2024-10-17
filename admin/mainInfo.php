<?php
	require "../connection.php";

	if(isset($_POST['logoutAdmin'])){
		setcookie("user", "", time() - 3600*24*30*12, "/");

		header("Location: ../");
	}

	$link = mysqli_connect($host, $user, $password, $datebase);


	$mainInfoAll = mysqli_query($link, "SELECT * FROM mainInfo");
    $mainInfo = mysqli_fetch_all($mainInfoAll, MYSQLI_ASSOC);

    if(isset($_POST['submit'])){
    	$title = $_POST['title'];
    	$text = $_POST['text'];

    	$query = mysqli_query($link, "UPDATE mainInfo SET title='".$title."',text='".$text."'");

    	header("Location: mainInfo.php");
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
			    <a href="mainInfo.php" class="nav-link active">Pozdrav</a>
			    <a href="applications.php" class="nav-link">Žiadosti</a>
			    <a href="rule.php" class="nav-link">Riaditeľstvo</a>
			    <a class="nav-link disabled" href="#">Dotazník</a>
			    <form method="post" action="">
					<input class="btn btn-outline-light" type="submit" name="logoutAdmin" value="Odhlásiť sa">
				</form> 
			  </div>
			</div>
		</nav>

		<div class="container" style="padding-top: 15px;">
			<div class="card">
				<div class="card-body">
					
					<form action="" method="post">
						<div class="form-group">
							<input  name="title" type="text" class="form-control" value="<?php echo $mainInfo[0]["title"]; ?>" required>
						</div>

						<div class="form-group">
							<textarea name="text" type="text" class="form-control" required><?php echo $mainInfo[0]["text"]; ?></textarea>
						</div>

						<input name="submit" type="submit" class="btn btn-warning" value="Zmeniť">
					</form>

				</div>
			</div>
		</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>