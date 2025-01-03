<?php
/*ini_set('display_errors', 1);
    error_reporting(E_ALL);*/

	require "../connection.php";

	if(isset($_POST['logoutAdmin'])){
		setcookie("user", "", time() - 3600*24*30*12, "/");

		header("Location: ../");
	}


	$link = mysqli_connect($host, $user, $password, $datebase);

	$result = mysqli_query($link, "SELECT * FROM `news` ORDER BY `news`.`id` DESC");
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);


	if(isset($_POST['addNewsSubmit'])) {
		$title=$_POST['addNewsTitle'];
		$text=$_POST['addNewsText'];
		$date=$_POST['addNewsDate'];
		$addNews = mysqli_query($link, "INSERT INTO news SET title='".$title."', text='".$text."', date='".$date."'");

		header("Location: adminPage.php");
	}

	if(isset($_POST['submitDeleteNews'])) {
		$idDeleteNews = $_POST['deleteNewsId'];
		$deleteNews = mysqli_query($link, "DELETE FROM news WHERE id='".$idDeleteNews."'");

		header("Location: adminPage.php");
	}

	if(isset($_POST['submitEditNews'])) {
		$editId = $_POST['editNewsId'];
		$editTitle = $_POST['editNewsTitle'];
		$editText = $_POST['editNewsText'];
		$editDate = $_POST['editNewsDate'];

		$editNewsQuery = mysqli_query($link, "UPDATE news SET title='".$editTitle."', text='".$editText."', date='".$editDate."' WHERE id=".$editId);
		

		header("Location: adminPage.php");
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
			    <a class="nav-link" href="../">Hlavná </a>
			    <a class="nav-link active" href="#">Novinky</a>
			    <a href="contacts.php" class="nav-link">Kontakty</a>
			    <a href="mainInfo.php" class="nav-link">Pozdrav</a>
			    <a href="applications.php" class="nav-link">Žiadosti</a>
			    <a href="rule.php" class="nav-link">Riaditeľstvo</a>
			    <a href="tariffs.php" class="nav-link">Tarify</a>
			    <a class="nav-link disabled" href="questions.php">Dotazník</a>
			    <form method="post" action="">
					<input class="btn btn-outline-light" type="submit" name="logoutAdmin" value="Odhlásiť sa">
				</form> 
			  </div>
			</div>
		</nav>

		<div class="container" style="padding-top: 15px;">

			<button style="margin-bottom: 15px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  				Pridať oznámenie
			</button>

			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      				<div class="modal-header">
        				<h5 class="modal-title" id="exampleModalLabel">Pridať oznámenie</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      				<div class="modal-body">

        				<form action="" method="post">
  							<div class="form-group">
    							<label for="exampleInputEmail1">Názov:</label>
    							<input name="addNewsTitle" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
  							</div>
  							<div class="form-group">
    							<label for="exampleFormControlTextarea1">Text:</label>
    							<textarea name="addNewsText" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
  							</div>
  							<div class="form-group">
    							<label for="exampleInputEmail1">Dátum</label>
    							<input value="<?php echo date('d.m.y') ?>" name="addNewsDate" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
  							</div>
  							<input name="addNewsSubmit" value="Pridať" type="submit" class="btn btn-primary">
						</form>

      				</div>
    				</div>
  				</div>
			</div>

			<?php


			foreach ($rows as $row){
                      echo "<div class='card' style='margin-bottom: 15px'>
                      <form action='' method='post'>
                    <div class='card-body'>
                    <div class='form-group'>
                    	<input name='editNewsTitle' class='form-control' type='text' value='" . $row['title'] . "''>
                    </div>
                      <!--<h5 class='card-title'>" . $row['title'] . "</h5>-->
                      <!--<p class='card-text'>". $row['text'] . "</p>-->
                      <div class='form-group'>
                      <textarea rows='3' name='editNewsText' class='form-control'>" . $row['text'] . "</textarea>
                      </div>
                    </div>
                    <div class='card-footer'>
                    <div class='form-group'>
                      <!--<p class='card-text'>Uverejnené: " . $row['date'] ."</p>-->
                      <input class='form-control' name='editNewsDate' value='". $row['date'] . "'>
                    </div>
                    <input type='hidden' name='editNewsId' value='".$row['id']."'>
                    	<input class='btn btn-warning' type='submit' name='submitEditNews' value='Zmeniť'>
                    	<form action='' method='post' style='margin-top: 15px;'>
                    	<input type='hidden' name='deleteNewsId' value='".$row['id']."'>
                    	<input class='btn btn-danger' type='submit' name='submitDeleteNews' value='Odstrániť'>
                    </form>
                      </form>
                      
                    </div>

                  </div>";
                    }

			?>

		</div>


	<?php endif; ?>

	<?php if($_COOKIE['user'] !== 'admin') : ?>
		<h1>no Admin</h1>
	<?php endif; ?>

	

	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>