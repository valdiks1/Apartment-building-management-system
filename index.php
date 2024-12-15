<?php
    /*ini_set('display_errors', 1);
    error_reporting(E_ALL);*/

    require "connection.php";

    $err="";

    // $host = "localhost";
    // $user = "admin";
    // $password = "admin";
    // $datebase = "myHome";
    
    // Create connection
    $link = mysqli_connect($host, $user, $password, $datebase);

    /* output news*/
    $result = mysqli_query($link, "SELECT * FROM `news` ORDER BY `news`.`id` DESC");
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $contactsAll = mysqli_query($link, "SELECT * FROM contacts");
    $contacts = mysqli_fetch_all($contactsAll, MYSQLI_ASSOC);

    $mainInfoAll = mysqli_query($link, "SELECT * FROM mainInfo");
    $mainInfo = mysqli_fetch_all($mainInfoAll, MYSQLI_ASSOC);

    $questionAll = mysqli_query($link, "SELECT * FROM question");
    $question = mysqli_fetch_all($questionAll, MYSQLI_ASSOC);

    $ruleAll = mysqli_query($link, "SELECT * FROM rule");
    $rule = mysqli_fetch_all($ruleAll, MYSQLI_ASSOC);

    

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
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Môj dom</title>
  </head>
  <body>
    
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!--<a class="navbar-brand" href="#">Панель навигации</a>-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Hlavná </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="applications.php">Žiadosti</a>
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

    <div class="container-fluid" style="margin-top: 20px;">
      <div class="row">
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <h5 class="card-header">Kontakty</h5>
                
                <div class="card-body">
                  <!-- <p class="card-text">Главная управляющая +380501111111</p> -->
                  <?php
                    if(empty($contacts)){
                      echo "<h3>Контактів немає</h3>";
                    }else{

                      foreach($contacts as $contact){
                        if($contact['phone'] == NULL && $contact['email'] !== NULL){
                          echo "<p class='card-text'>".$contact['name'].": ".$contact['email']."</p>";
                        }else if($contact['phone'] !== NULL && $contact['email'] == NULL){
                          echo "<p class='card-text'>".$contact['name'].": ".$contact['phone']."</p>";
                        }else if($contact['phone'] !== NULL && $contact['email'] !== NULL){
                          echo "<p class='card-text'>".$contact['name'].": ".$contact['phone']." и ".$contact['email']."</p>";
                        }
                        
                      }
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12" style="margin-top: 15px;">
              <div class="card">
                <h5 class="card-header">Riaditeľstvo bytového družstva 'KVAZAR-3'</h5>
                <div class="card-body">

                  <?php
                    foreach($rule as $item){
                      echo "<p class='card-text'>".$item['state'].": ".$item['name']."";
                    }
                  ?>


                  <!-- <p class="card-text">Голова правління: Горбунова Олександра Леонідівна</p>
                  <p class="card-text">Заступник Голови правління: Мартиненко Володомир Миколайович</p>
                  <p class="card-text">Член правління: Бабяк Ольга Миколаївна</p>
                  <p class="card-text">Член правління: Грищенко Олександр Григорович</p>
                  <p class="card-text">Член правління: Тонкодуб Любов Василівна</p> -->
                </div>
                <div class="card-footer">Rozhodnutie Valného zhromaždenia bytového družstva 01.12.2019</div>
              </div>
            </div>
          </div>

          <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
              
              <!-- <div class="card">
                <div class="card-header">Опитування</div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $question[0]["question"]; ?></h5>
                  <p class="card-text">
                    <?php echo $question[0]['fData']; ?> <?php echo $question[0]['fVariantAnswear']; ?>:
                    <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $question[0]['fData']; ?>" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </p>
                  <p class="card-text">
                     <?php echo $question[0]['sData']; ?> <?php echo $question[0]['sVariantAnswear']; ?>:
                    <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $question[0]['sData']; ?>" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </p>
                </div>
                <div class="card-footer">
                  <a href="question.php" class="card-link">Пройти тест</a>
                </div>
              </div> -->

            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $mainInfo[0]['title']; ?></h5>
                  <p class="card-text"><?php echo $mainInfo[0]['text']; ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6">

              <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="img/DJI_0008.JPG" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="img/DJI_0018.JPG" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="img/DJI_0163.JPG" class="d-block w-100" alt="...">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Предыдущий</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Следующий</span>
                </a>
              </div>

            </div>
          </div>

          <div class="row" style="margin-top: 15px">
            <div class="col-lg-12">
              <div class="card">
                <h5 class="card-header">Novinky</h5>
                <div class="card-body">

                  <!-- <div class="card" style="margin-bottom: 15px">
                    <div class="card-body">
                      <h5 class="card-title">Боржники по будинку "Зразковий" за Грудень 2015 року</h5>
                      <p class="card-text">Станом на 1 січня 2016, загальна заборгованість мешканців становить 10...</p>
                    </div>
                    <div class="card-footer">
                      <p class="card-text">Опубліковано: 29 січня 2016</p>
                    </div>
                  </div> -->

                  <?php
                  if(empty($rows)){
                    echo "<h3>Nie sú žiadne novinky</h3>";
                  } else {

                    foreach ($rows as $row){
                      echo "<div class='card' style='margin-bottom: 15px'>
                    <div class='card-body'>
                      <h5 class='card-title'>" . $row['title'] . "</h5>
                      <p class='card-text'>". $row['text'] . "</p>
                    </div>
                    <div class='card-footer'>
                      <p class='card-text'>Uverejnené: " . $row['date'] ."</p>
                    </div>
                  </div>";
                    }
                  }
                  ?>


                </div>
              </div>
            </div>
          </div>
        </div>
          
            
        
          
        </div>
      </div>
    </div>

    <script src="js/app.js"></script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
