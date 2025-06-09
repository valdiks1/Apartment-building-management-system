<?php
require_once __DIR__ . '/vendor/autoload.php';
require "./connection.php";
session_start();

$currentMonth = date('m');
$currentYear = date('y');

$link = mysqli_connect($host, $user, $password, $datebase);
$tariffsData = mysqli_fetch_all(mysqli_query($link, "SELECT * FROM tariffs"), MYSQLI_ASSOC);

$result = array();

foreach ($_SESSION["payment_data"] as $paymentTariff) {
    $name = "";
    $value = 0;
    $price = 0;
    $ms = "";

    foreach ($tariffsData as $tariff) {
        if ($paymentTariff["id_t"] == $tariff["id"]) {
            $name = $tariff['name'];
            $ms = $tariff['ms'];

            if ($tariff['hasMeter']) {
                $previosMonth = $currentMonth == 1 ? 12 : $currentMonth - 1;
                $previosYear = $currentMonth == 1 ? $currentYear - 1 : $currentYear;

                $tariffData = mysqli_query($link, "SELECT * 
                    FROM meter_readings 
                    WHERE id_u=" . $_COOKIE['id'] . " AND id_t=" . $tariff["id"] . " AND month=" . $previosMonth . " AND year=" . $previosYear);
                $tariffDataQuery = mysqli_fetch_all($tariffData, MYSQLI_ASSOC);

                if (count($tariffDataQuery) == 0) {
                    $value = $paymentTariff["value"];
                    $price = $value * (float)$tariff["tariff"];
                } else {
                    $value = $paymentTariff["value"] - $tariffDataQuery[0]['value'];
                    $price = $value * (float)$tariff["tariff"];
                }
            } else {
                $value = $paymentTariff["value"];
                $price = $value;
            }
        }
    }

    $result[] = [
        "name" => $name,
        "value" => $value,
        "price" => $price,
        "ms" => $ms
    ];
}

$mpdf = new \Mpdf\Mpdf();

$html = '
<h2 style="text-align: center;">Platobna instrukcia</h2>
<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <thead>
        <tr>
            <th style="text-align: center;">Nazov</th>
            <th style="text-align: center;">Hodnota</th>
            <th style="text-align: center;">Cena</th>
            <th style="text-align: center;">MS</th>
        </tr>
    </thead>
    <tbody>';

foreach ($result as $row) {
    $html .= '<tr>
        <td style="text-align: center;">' . htmlspecialchars($row['name']) . '</td>
        <td style="text-align: center;">' . htmlspecialchars($row['value']) . '</td>
        <td style="text-align: center;">' . htmlspecialchars($row['price']) . '</td>
        <td style="text-align: center;">' . htmlspecialchars($row['ms']) . '</td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

$mpdf->WriteHTML($html);
$mpdf->Output();
?>
