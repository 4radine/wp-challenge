<?php
/* -- masukkan detail disini -- */
$namaBarang = "Bola Lampu Phillips 2W Warm";
$harga = 27000;
$jumlah = 2;



/* kode */
$total = $harga * $jumlah;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table { margin: 0 auto;}
        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th,td { padding: 10px; }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Qty</th>
        </tr>
        <tr>
            <td><?= $namaBarang ?></td>
            <td><?= "Rp ".number_format($harga, 0, "", ".") ?></td>
            <td><?= $jumlah ?></td>
        </tr>
        <tr>
            <td >Total</td>
            <td colspan="2"><?= "Rp ".number_format($total, 0, "", ".") ?></td>
        </tr>
    </table>
</body>
</html>