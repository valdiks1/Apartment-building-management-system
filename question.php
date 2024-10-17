<?php
require "connection.php";

$link = mysqli_connect($host, $user, $password, $datebase);

$compleatedUsersAll = mysqli_query($link, "SELECT * FROM compleatedUsers");
$compleatedUsers = mysqli_fetch_all($compleatedUsersAll, MYSQLI_ASSOC);

$questionAll = mysqli_query($link, "SELECT * FROM question");
$question = mysqli_fetch_all($questionAll, MYSQLI_ASSOC);

$repeatQuestionUsers=true;



foreach ($compleatedUsers as $user) {
	if($user['nameUsers'] == $_COOKIE['user']){
		$repeatQuestionUsers=true;
	} else {
		$repeatQuestionUsers=false;
	}
}

if(!empty($_POST['submitQues'])){
	var_dump($_POST);
	$addCompleatedUser = mysqli_query($link, "INSERT INTO compleatedUsers SET nameUsers='" . $_COOKIE['user'] . "'");
	$fData=$question[0]['fData'];
	$sData=$question[0]['sData'];

	if (empty($_POST['fVariontAnswear']) && !empty($_POST['sVariontAnswear'])) {
		$sData++;
		
		$sDataQuery= mysqli_query($link, "UPDATE question SET sData='" . $sData . "' WHERE id=1");
	} else if(!empty($_POST['fVariontAnswear']) && empty($_POST['sVariontAnswear'])){
		$fData++;
		
		$fDataQuery= mysqli_query($link, "UPDATE question SET fData='" . $fData . "' WHERE id=1");
	}

	//header("Location: index.php");
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>

	<a href="index.php" class="btn btn-primary">На головну</a>

	<?php if(empty($_COOKIE)) : ?>
		<h4 style="text-align: center;">Войдите в аккаунт, что бы продолжить.</h4>
	<?php endif; ?>

	<?php if($repeatQuestionUsers == true && !empty($_COOKIE)) : ?>
		<h4>Вы уже прошли тест, пожалуйста вернитесь на главную страницу</h4>
	<?php //endif; ?>

	<?php elseif($repeatQuestionUsers == false  && !empty($_COOKIE)) : ?>
		
		<div class="container">
			<h4 style="text-align: center"><?php echo $question[0]["question"]; ?></h4>
			<form action="" method="post">
				<div class="form-group">
					<label><?php echo $question[0]['fVariantAnswear']; ?></label>
					<input type="radio" name="fVariontAnswear" >
				</div>
				<div class="form-group">
					<label><?php echo $question[0]['sVariantAnswear']; ?></label>
					<input type="radio" name="sVariontAnswear" >
				</div>
				<input type="submit" name="submitQues" class="btn btn-primary">
			</form>
		</div>

	<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>