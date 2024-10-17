<?php
	require "../connection.php";

  if(isset($_POST['logoutAdmin'])){
    setcookie("user", "", time() - 3600*24*30*12, "/");

    header("Location: ../");
  }

	$link = mysqli_connect($host, $user, $password, $datebase);

	$result = mysqli_query($link, "SELECT * FROM `applications` ORDER BY `applications`.`id` DESC");
    $applicationsData = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(isset($_POST['deleteApp'])){
    	$delete = mysqli_query($link, "DELETE FROM applications WHERE id='" . $_POST['idDeleteApp'] . "'");

    	header("Location: applications.php");
    }

    if(isset($_POST['editApp'])){
    	$edit = mysqli_query($link, "UPDATE applications SET state = '" . $_POST['stateEdit'] . "' WHERE id='" . $_POST['idEditApp'] . "'");

      header("Location: applications.php");
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
			    <a class="nav-link" href="../">Hlavná </a>
          <a class="nav-link " href="adminPage.php">Novinky</a>
          <a href="contacts.php" class="nav-link">Kontakty</a>
          <a href="mainInfo.php" class="nav-link">Pozdrav</a>
          <a href="applications.php" class="nav-link active">Žiadosti</a>
          <a href="rule.php" class="nav-link">Riaditeľstvo</a>
          <a class="nav-link disabled" href="questions.php">Dotazník</a>
          <form method="post" action="">
          <input class="btn btn-outline-light" type="submit" name="logoutAdmin" value="Odhlásiť sa">
				</form> 
			  </div>
			</div>
		</nav>

		<div class="container" style='padding-top: 15px;'>
			<?php

        foreach ($applicationsData as $aplication) {
          $categoryText='';
          $categoryIcon='';
          if($aplication['category'] == 'light'){
            $categoryText = 'Problémy s elektrinou';
            $categoryIcon = "<i style='font-size: 35px; color: yellow;' class='fas fa-lightbulb'></i>";
          } else if($aplication['category'] == 'water') {
            $categoryText = 'Problémy s vodovodom';
            $categoryIcon = "<i style='font-size: 35px; color: blue;' class='fas fa-tint'></i>";
          } else if($aplication['category'] == 'home') {
            $categoryText = 'Dvorová zóna';
            $categoryIcon = "<i style='font-size: 35px; color: green;' class='fas fa-tree'></i>";
          } else if($aplication['category'] == 'none'){
            $categoryText = 'Iné';
            $categoryIcon = "<i style='font-size: 35px; color: violet;' class='fas fa-question'></i>";
          }
          echo "<div class='card ' style='margin-bottom: 15px;'>
        <div class='card-header'>
          <div style='display: flex;'>
            <div style='width: 5%;'>" . $categoryIcon . "</div>
            <div style='width: 55%;'><h4>" . $categoryText . "</h4></div>
            <div style='width: 40%;text-align: right;'>" . "<form style='display: flex;' action='' method='post'>
			<input type='hidden' name='idEditApp' value='" . $aplication['id'] . "'><p style='margin-right: 15px; width: 300px;'>
      " . $aplication['state'] ."</p>
			<select style='margin-right: 5px;' name='stateEdit' class='form-control'>
              <option value='Nová'>Nová</option>
              <option value='V spracovaní'>V spracovaní</option>
              <option value='Vyhotovené'>Vyhotovené</option>
            </select>
            <input type='submit' value='Zmeniť' name='editApp' class='btn btn-warning'>
		</form>" . "</div>
          </div>
          
        </div>
        <div class='card-body'>
          <h5 class='card-title'>" . $aplication['title'] . "</h5>
          <p class='card-text'>" . $aplication['text'] . "</p>
          
        </div>
        <div class='card-footer text-muted' style='display: flex; justify-content: space-between;'>
          " . $aplication['date'] . "
          <form action='' method='post'>
			<input type='hidden' name='idDeleteApp' value='" . $aplication['id'] . "'>
			<input type='submit' name='deleteApp' value='Odstrániť' class='btn btn-danger'>
		</form>
        </div>
      </div>";
        }       
      ?>
		</div>

		

		
	

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../js/all.js"></script>
</body>
</html>