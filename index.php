<?php
// Inisialisasi variabel & array error
$nama = $nim = $jurusan = "";
$errors = [];
$allowed_jurusan = ["TI", "RSK", "BD", "DKV"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Sanitasi String
    $raw_nama = trim($_POST['nama'] ?? "");
    $raw_nim = trim($_POST['nim'] ?? "");
    $raw_jurusan = trim($_POST['jurusan'] ?? "");

    // Validasi NIM (harus angka)
    if (empty($raw_nim)) {
        $errors[] = "NIM wajib diisi.";
    } elseif (!ctype_digit($raw_nim)) {
        $errors[] = "NIM harus berupa angka.";
    } else {
        $nim = htmlspecialchars($raw_nim, ENT_QUOTES, 'UTF-8');
    }

    // Validasi NAMA (hanya huruf, spasi, dan petik/titik)
    if (empty($raw_nama)) {
        $errors[] = "Nama wajib diisi.";
    } elseif (!preg_match("/^[a-zA-Z\s'.]+$/", $raw_nama)) {
        $errors[] = "Nama hanya boleh berisi huruf dan spasi.";
    } else {
        $nama = htmlspecialchars($raw_nama, ENT_QUOTES, 'UTF-8');
    }

    // Validasi JURUSAN (harus sesuai dengan opsi yang tersedia)
    if (empty($raw_jurusan)) {
        $errors[] = "Jurusan wajib dipilih.";
    } elseif (!in_array($raw_jurusan, $allowed_jurusan, true)) {
        $errors[] = "Pilihan jurusan tidak valid.";
    } else {
        $jurusan = htmlspecialchars($raw_jurusan, ENT_QUOTES, 'UTF-8');
    }
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
        input, select { display: block; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Praktikum Form GET</h1>
    <hr>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

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
        <input type="text" name="nim" id="nim" value="<?= $raw_nim ?>" required>
        
        <label for="nama">NAMA</label>
        <input type="text" name="nama" id="nama" value="<?= $raw_nama ?>" required>
        
        <label for="jurusan">JURUSAN</label>
         <select name="jurusan" id="jurusan" required>
            <option value="">Pilih Jurusan</option>
            <option value="TI" <?= $jurusan === "TI" ? "selected" : "" ?>>TI</option>
            <option value="RSK" <?= $jurusan === "RSK" ? "selected" : "" ?>>RSK</option>
            <option value="BD" <?= $jurusan === "BD" ? "selected" : "" ?>>BD</option>
            <option value="DKV" <?= $jurusan === "DKV" ? "selected" : "" ?>>DKV</option>
         </select>

         <hr>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>