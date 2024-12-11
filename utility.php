<?php
    require "./connection.php";

    if(isset($_POST['logout'])){
        setcookie("user", "", time() - 3600*24*30*12, "/");
        setcookie("email", "", time() - 3600*24*30*12, "/");

        header("Location: index.php");
    }

    $currentDay = date('d');
    $currentMonth = date('m');
    $currentYear = date('y');

    $link = mysqli_connect($host, $user, $password, $datebase);

	$tariffs_rows = mysqli_fetch_all(mysqli_query($link, "SELECT * FROM tariffs"), MYSQLI_ASSOC);
    $tariffs = [];
    foreach($tariffs_rows as $tariff){
        $tariffs[$tariff['id']] = ["id" => $tariff["id"] ,"name" => $tariff["name"], "hasMeter" => $tariff['hasMeter'], "tariff" => $tariff['tariff']];
    }

    if(isset($_POST['submit'])){
        $selectedTariffs = array();
        foreach($tariffs as $tariff){
            if(array_key_exists($tariff['id'],$_POST)){
                array_push($selectedTariffs, $tariff['id']);
            }
        }
        $result = array();
        foreach($selectedTariffs as $selectedTariff){
            if($tariffs[$selectedTariff]['hasMeter']){
                array_push($result, ["id_t" => $selectedTariff, "value" => $_POST[$selectedTariff . "value"]]);
            }else{
                array_push($result, ["id_t" => $selectedTariff, "value" => $tariffs[$selectedTariff]['tariff']]);
            }
        }
        foreach($result as $query){
            mysqli_query($link, "INSERT INTO meter_readings SET 
            id_u='".$_COOKIE['id']."', id_t='".$query['id_t']."', value='".$query['value']."', 
            day=".$currentDay.", month=".$currentMonth.", year=".$currentYear."");
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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Hlavná</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Moje údaje</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="utility.php">Komunálne platby</a>
            </li>
                
        </ul>
        <form method="post" action="">
			<input class="btn btn-warning" type="submit" name="logout" value="Odhlásiť sa">
		</form> 
    </div>
</nav>
  </header>

  <main>
    <div class="container" style="margin-top: 15px">
        <form action="" method="post">
            <input type="submit" name="submit" value="Odoslať" class="btn btn-success" style="margin-bottom: 15px">
            <?php
                foreach($tariffs as $tariff){
                    
                    $previosMonth;
                    $previosYear;
                    if($currentMonth == 1){
                        $previosMonth = 12;
                        $previosYear = $currentYear-1;
                    }else{
                        $previosMonth = $currentMonth-1;
                        $previosYear = $currentYear;
                    }

                    $localQuery = mysqli_query($link, "SELECT * FROM `meter_readings` WHERE month=".$previosMonth." AND 
                        year=".$previosYear." AND id_u=".$_COOKIE['id']." AND id_t=".$tariff['id']."");
                    $localTarifData = mysqli_fetch_all($localQuery, MYSQLI_ASSOC);
        
                    echo "
                        <div class='card' style='margin-bottom: 15px'>
                    <div class='card-header'>
                        <input name='".$tariff['id']."' type='checkbox'> ".$tariff['name']."
                    </div>";
                    if(count($localTarifData) == 0 && $tariff['hasMeter']){
                        echo "
                            <div class='card-body'>
                                <div class='form-group'>
                                    <label>Hodnoty meračov za minulý mesiac chýbajú, prosím, zadajte hodnoty, za ktoré chcete zaplatiť.</label>
                                    <input name='".$tariff['id']."value' class='form-control' type='number' step='any'>
                                </div>
                            </div> ";
                    }elseif (count($localTarifData) != 0 && $tariff['hasMeter']) {
                        echo "
                            <div class='card-body'>
                                <div class='form-group'>
                                    <label>Predchádzajúca hodnota</label>
                                    <input placeholder='Predchádzajúca hodnota' value='".$localTarifData['value']."' class='form-control' type='number' step='any'>
                                </div>
                                <div class='form-group'>
                                    <label>Aktuálna hodnota</label>
                                    <input name='".$tariff['id']."value' class='form-control' type='number' step='any'>
                                </div>
                            </div> ";
                    }elseif(!$tariff['hasMeter']){
                        echo "
                            <div class='card-body'>
                                Ak chcete zaplatiť za službu, kliknite na začiarknutie.
                                Tariffa: ".$tariff['tariff']."&#8364;
                            </div> ";
                    }
                echo "</div>";
                    
                }
            ?>
            
        </form>

    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>
