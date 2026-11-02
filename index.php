<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $_POST['nama'] ?? "";
    $nim = $_POST['nim'] ?? "";
    $jurusan = $_POST['jurusan'] ?? "";
} else {
    $nama = $nim = $jurusan = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM GET</title>
    <style>
        table { width: 100%; }
        th { text-align: left; }
        input,select { display: block; }
    </style>
</head>
<body>
    <h1>Praktikum Form GET</h1>
    <hr>
    <table>
        <tbody>
            <tr>
                <th width="100">NIM</th>
                <td width="10">:</td>
                <td><?= $nim ?></td>
            </tr>
            <tr>
                <th>NAMA</th>
                <td>:</td>
                <td><?= $nama ?></td>
            </tr>
            <tr>
                <th>JURUSAN</th>
                <td>:</td>
                <td><?= $jurusan ?></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <h2>Form Data</h2>
    <form action="" method="post">
        <label for="nim">NIM</label>
        <input type="number" name="nim" id="nim" required>
        
        <label for="nama">NAMA</label>
        <input type="text" name="nama" id="nama" required>
        
        <label for="jurusan">JURUSAN</label>
         <select name="jurusan" id="jurusan" required>
            <option value="">Pilih Jurusan</option>
            <option value="TI">TI</option>
            <option value="RSK">RSK</option>
            <option value="BD">BD</option>
            <option value="DKV">DKV</option>
         </select>

         <hr>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>