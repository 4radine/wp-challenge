<?php
/*  */
$subtotal = 200000;//total awal





/* kode */
$diskon = 0;
if ($subtotal >= 500000) $diskon = 15;
else if ($subtotal >= 200000) $diskon = 10;
$total = ($subtotal - ($subtotal * ($diskon / 100)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            margin: 0 auto;
            text-align: left;
            border: 1px solid black;
            border-collapse: collapse;
        }
        td,th { padding: 8px; }
        table * { border-bottom: 1px solid black; }
        th { text-align: right; }
    </style>
</head>
<body>

    <table>
        <tr>
            <th>Total Awal</th>
            <td>:</td>
            <td>Rp <?= number_format($subtotal, 0, "", ".") ?></td>
        </tr>
        <tr>
            <th>Diskon</th>
            <td>:</td>
            <td><?= $diskon ?>%</td>
        </tr>
        <tr>
            <th>Total Akhir</th>
            <td>:</td>
            <td>Rp <?= number_format($total, 0, "", ".") ?></td>
        </tr>
    </table>
</body>
</html>