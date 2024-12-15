<?php
	require "connection.php";
  $err="";

	$link = mysqli_connect($host, $user, $password, $datebase);

	$result = mysqli_query($link, "SELECT * FROM `applications` ORDER BY `applications`.`id` DESC");
    $applicationsData = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if(isset($_POST['submitAplicationAdd'])){
    if(!empty($_POST['title-aplication']) && !empty($_POST['text-aplication'])){
      $addAplicationQuery = mysqli_query($link, "INSERT INTO applications SET title='" . $_POST['title-aplication'] . "', state='Nová', date='" . date('d.m.y') . "', text='". $_POST['text-aplication'] . "', category='". $_POST['category'] . "'");
    }
    

    header("Location: applications.php");
  }

  if(isset($_POST['submit'])){

      $query = mysqli_query($link,"SELECT id, name, password, isAdmin FROM users WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1");
      $data = mysqli_fetch_assoc($query);
      if(md5($_POST['password']) == $data['password'] && $data['isAdmin']){
        
        setcookie("user", "admin", time()+60*60*24*30, "/");


        header("Location: admin/adminPage.php");
      }else if(md5($_POST['password']) == $data['password']){
        setcookie("user", $data['name'], time()+60*60*24*30, "/");
        setcookie("email", $_POST['email'], time()+60*60*24*30, "/");
        setcookie("id", $data['id'], time()+60*60*24*30, "/");

        header("Location: profile.php");
      } else {
        $err="Zadali ste nesprávne heslo";
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

	<header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Hlavná</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Žiadosti </a>
            </li>
            <li class="nav-item">
              <?php if(!isset($_COOKIE['user'])) : ?>
                <a href="" class="nav-link" data-toggle="modal" data-target="#exampleModal">Prihlásiť sa</a>
              <?php endif; ?>
              <?php if(isset($_COOKIE["user"]) && $_COOKIE["user"] !== 'admin') : ?>
                <a class="nav-link" href="profile.php">Môj profil(<?php echo $_COOKIE["user"]; ?>)</a>
              <?php endif; ?>
              <?php if(isset($_COOKIE["user"]) && $_COOKIE["user"] == 'admin') : ?>
                <a class="nav-link" href="admin/adminPage.php">Admin panel</a>
              <?php endif; ?>
            </li>
          </ul>
        
        </div>
      </nav>
    </header>

     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Prihlásiť sa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="exampleInputEmail1" >E-mailová adresa</label>
                <input name="email" type="email" class="form-control"  id="exampleInputEmail1" aria-describedby="emailHelp" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1" >Heslo</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" required>
                <p style="color: red;"><?php echo $err; ?></p>
              </div>
              <input name="submit" value="Prihlásiť sa" type="submit" class="btn btn-primary" id="submitAuth" required>
              <a href="register.php" class="btn btn-primary">Vytvoriť účet</a>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container" style="padding-top: 15px;"> 
      <?php  if(empty($_COOKIE)): ?>
        <h4>Aby ste vytvorili žiadosť, prihláste sa do svojho účtu</h4>
      <?php endif; ?>
      <?php  if(!empty($_COOKIE)): ?>
        <button style='margin-bottom: 15px;' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">
          Vytvoriť žiadosť
        </button>
      <?php endif; ?>
    	<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vytvoriť žiadosť</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">

          <div class="form-group">
            <label for="title-aplication">Názov: </label>
            <input type="text" name='title-aplication' class="form-control">
          </div>
          <div class="form-group">
            <label for="title-text">Popis problému: </label>
            <input type="text" name='text-aplication' class="form-control">
          </div>
          <div class="form-group">
            <label for="title-text">Výber kategórie: </label>
            <select name='category' class="form-control">
              <option value='water'>Problémy s vodovodom</option>
              <option value='home'>Dvorová zóna</option>
              <option value='light'>Problémy s elektrinou</option>
              <option value='none'>Svoj variant</option>
            </select>
          </div>
          <input class='btn btn-primary' type="submit" name='submitAplicationAdd' value='Vytvoriť'>

        </form>
      </div>
    </div>
  </div>
</div>

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
            <div style='width: 70%;'><h4>" . $categoryText . "</h4></div>
            <div style='width: 25%;text-align: right;'>" . $aplication['state'] . "</div>
          </div>
          
        </div>
        <div class='card-body'>
          <h5 class='card-title'>" . $aplication['title'] . "</h5>
          <p class='card-text'>" . $aplication['text'] . "</p>
          
        </div>
        <div class='card-footer text-muted'>
          " . $aplication['date'] . "
        </div>
      </div>";
        }       
      ?>

    </div>
	

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="js/all.js"></script>
</body>
</html>