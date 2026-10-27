<?php
/* isi */
$berat = 68;
$tinggi = 1.81;




/* kode */
$status = "???";
$bmi = ($berat / ($tinggi * $tinggi));
if ($bmi < 18.5) $status = "Kurus";
else if ($bmi >= 18.5 && $bmi <= 24.9) $status = "Normal";
else if ($bmi >= 25 && $bmi <= 29.9) $status = "Gemuk";
else if ($bmi > 30) $status = "Obesitas";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?= number_format($bmi, 1, ',') ?></h1>
    <h2><?= $status ?></h2>
</body>
</html>