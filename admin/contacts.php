<?php
	require "../connection.php";

	if(isset($_POST['logoutAdmin'])){
		setcookie("user", "", time() - 3600*24*30*12, "/");

		header("Location: ../");
	}

	$err='';

	$link = mysqli_connect($host, $user, $password, $datebase);

	$contactsAll = mysqli_query($link, "SELECT * FROM contacts");
    $contacts = mysqli_fetch_all($contactsAll, MYSQLI_ASSOC);

    if(isset($_POST['addContactsSubmit'])){
    	$name = $_POST['addContactsName'];
    	$addContactsPhone = $_POST['addContactsPhone'];
    	$addContactsEmail = $_POST['addContactsEmail'];

    	if($addContactsEmail == null && $addContactsPhone == null) {
    		$err="Мінімум одне з полів має бути заповнене";
    	}else if($addContactsEmail !== null && $addContactsPhone == null){
    		$addContactQuery = mysqli_query($link, "INSERT INTO contacts SET name='".$name."', email='". $addContactsEmail ."', phone='". NULL ."'");

    		header("Location: contacts.php");
    	}else if($addContactsEmail !== null && $addContactsPhone !== null){
    		$addContactQuery = mysqli_query($link, "INSERT INTO contacts SET name='".$name."', email='". $addContactsEmail ."', phone='". $addContactsPhone ."'");

    		header("Location: contacts.php");
    	}else if($addContactsEmail == null && $addContactsPhone !== null){
    		
    		$addContactQuery = mysqli_query($link, "INSERT INTO contacts SET name='".$name."', email='". NULL ."', phone='".$addContactsPhone."'");

    		header("Location: contacts.php");
    	}

    }

    if(isset($_POST['deleteContact'])){
    	$deleteContactId = $_POST['deleteContactId'];
    	$deleteContact = mysqli_query($link, "DELETE FROM contacts WHERE id='".$deleteContactId."'");

    	header("Location: contacts.php");
    }

    if(isset($_POST['submitEditContact'])){

    	$editNameContact = $_POST['editContactsName'];
    	$editContactsPhone = $_POST['editContactsPhone'];
    	$editContactsEmail = $_POST['editContactsEmail'];
    	$editContactId = $_POST['editContactId'];

    	if($editContactsEmail == null && $editContactsPhone == null) {
    		$err="Мінімум одне з полів має бути заповнене";
    	}else if($editContactsEmail !== null && $editContactsPhone == null){
    		$editContactQuery = mysqli_query($link, "UPDATE contacts SET name='".$editNameContact."', email='".$editContactsEmail."', phone='".NULL."' WHERE id=".$editContactId);

    		header("Location: contacts.php");
    	}else if($editContactsEmail !== null && $editContactsPhone !== null){
    		$editContactQuery = mysqli_query($link, "UPDATE contacts SET name='".$editNameContact."', email='".$editContactsEmail."', phone='".$editContactsPhone."' WHERE id=".$editContactId);

    		header("Location: contacts.php");
    	}else if($editContactsEmail == null && $editContactsPhone !== null){
    		$editContactQuery = mysqli_query($link, "UPDATE contacts SET name='".$editNameContact."', email='".NULL."', phone='".$editContactsPhone."' WHERE id=".$editContactId);

    		header("Location: contacts.php");
    	}

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
			    <a class="nav-link" href="adminPage.php">Novinky</a>
			    
			    <a href="contacts.php" class="nav-link active">Kontakty</a>
			    <a href="mainInfo.php" class="nav-link">Pozdrav</a>
			    <a href="applications.php" class="nav-link">Žiadosti</a>
			    <a href="rule.php" class="nav-link">Riaditeľstvo</a>
			    <a href="tariffs.php" class="nav-link">Tarify</a>
			    <a class="nav-link disabled" href="#">Dotazník</a>
			    <form method="post" action="">
					<input class="btn btn-outline-light" type="submit" name="logoutAdmin" value="Odhlásiť sa">
				</form> 
			  </div>
			</div>
		</nav>

		<div class="container" style="padding-top: 15px;">
			<button style='margin-bottom: 15px;' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  				Pridať kontakt
			</button>

			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="exampleModalLabel">Pridať kontakt</h5>
        						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          							<span aria-hidden="true">&times;</span>
        						</button>
      					</div>
      					<div class="modal-body">
        					<form action="" method="post">
        						<div class="form-group">
        							<label for="">Názov služby alebo meno osoby</label>
        							<input class='form-control' type="text" name="addContactsName">
        						</div>
        						<div class="form-group">
        							<label for="">Číslo telefónu (Musíte vyplniť buď toto pole, alebo nasledujúce)</label>
        							<input class='form-control' type="text" name="addContactsPhone">
        						</div>
        						<div class="form-group">
        							<label for="">Adresa elektronickej pošty (Musíte vyplniť buď toto pole, alebo predchádzajúce)</label>
        							<input class='form-control' type="email" name="addContactsEmail">
        							<p style="color: red;"><?php echo $err; ?></p>
        						</div>
        						<input type="submit" name='addContactsSubmit' value='Pridať kontakt' class="btn btn-primary">
        					</form>
      					</div>
    				</div>
  				</div>
			</div>
			<?php
				if(empty($contacts)){
                      echo "<h3>Контактов немає</h3>";
                    }else{
                      foreach($contacts as $contact){
                        echo "<div class='card' style='margin-bottom:15px;'>
                        <div class='card-body'>
                        <form action='' method='post'>
				<div class='form-group'>
					<input name='editContactsName' type='text' class='form-control' value='".$contact['name']."'>
				</div>
				<div class='form-group'>
					<input name='editContactsPhone' type='text' class='form-control'value='".$contact['phone']."'>
				</div>
				<div class='form-group'>
					<input name='editContactsEmail' type='text' class='form-control'value='".$contact['email']."'>

				</div>
				<input type='hidden' name='editContactId' value='".$contact['id']."'>
				<input name='submitEditContact' class='btn btn-warning' type='submit' value='Zmeniť'>
				<form action='' method='post' style='margin-top: 15px;'>
				<input name='deleteContactId' type='hidden' value='".$contact['id']."'>
				<input class='btn btn-danger' name='deleteContact' type='submit' value='Odstrániť'>
			</form>
			</form>
			
			</div>
			</div>";
                      }
                    }
			?>
			
		</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>