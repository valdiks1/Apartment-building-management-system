<?php
    /*ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $host = "localhost";
    $user = "admin";
    $password = "admin";
    $datebase = "myHome";
    
    // Create connection
    $link = mysqli_connect($host, $user, $password, $datebase);
    

    if(isset($_POST['submit'])){
      $query = mysqli_query($link,"SELECT id, name, password FROM users WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1");
      $data = mysqli_fetch_assoc($query);
      //print_r($data);
      if($_POST['password'] == $data['password']){
        setcookie("user", $data['name'], time()+60*60*24*30, "/");
      }

    }*/
    

    //echo $_COOKIE['user'];
    

    if(isset($_POST['logout'])){
      setcookie("user", "", time() - 3600*24*30*12, "/");
      setcookie("email", "", time() - 3600*24*30*12, "/");
      setcookie("id", "", time() - 3600*24*30*12, "/");

      header("Location: index.php");
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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Hlavná</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="profile.php">Moje údaje</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="utility.php">Komunálne platby</a>
            </li>
                
        </ul>
        <form method="post" action="">
			<input class="btn btn-warning" type="submit" name="logout" value="Odhlásiť sa">
		</form> 
    </div>
</nav>
  </header>
  <h1 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Môj profil:</h1>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm"></div>
      <div class="col-sm">

        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title"><?php echo $_COOKIE['user'];?></h5>
            <p class="card-text"><?php echo $_COOKIE['email']; ?></p>
          </div>
        </div>

      </div>
      <div class="col-sm"></div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>