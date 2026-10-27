<?php

// ini adalah cara untuk menampilkan data di browser
echo "Ini program PHP pertama saya <br>";

// ini adalah variable nama, untuk menyimpan nama
$nama = "A";
// ini adalah variable umur, untuk menyimpan umur
$umur = 19;

// tampilkan data nama dan umur
echo "Nama: $nama <br>";
echo "Umur: $umur <br>";
// br untuk menambahkan enter agar turun ke bawah

// Ini adalah fungsi untuk menghitung luas persegi
function luaspersegi($panjang, $lebar) {
    // fungsi yang harus mengembalikan nilai
    $luas = $panjang * $lebar;
    return $luas;
}

// Ini adalah fungsi untuk mencari bila sebuah angka adalah ganjil atau genap
function ganjilgenap ($angka) {
    if ($angka != 0) {
        if ($angka % 2 == 0) return "genap";
        else return "ganjil";
    } else {
        return "nol";
    }

}

// Ini adalah fungsi pendeteksi email valid atau tidak
function filtermail($email) {
    if (filter_var($email,FILTER_VALIDATE_EMAIL)) return "valid";
    else return "tidak valid";
}

// Ini adalah fungsi yang menghasilkan string random dengan panjang sesuka hati anda :v
function randomStr(int $length = 16): string {
    $bytes = random_bytes(ceil($length / 2));
    return substr(bin2hex($bytes), 0, $length);
}

// cara menggunakan function
$luas = luaspersegi(4, 2);
echo "Luas Persegi 4 x 2 Adalah $luas Meter <br><br>";

echo "angka 2394248328943 adalah angka ".ganjilgenap(2394248328943)."<br><br>";

echo "email test@gmail.com adalah email yang ".filtermail("test@gmail.com").".<br>";
echo "sedangkan email awawa@aaaaaaa adalah email yang ".filtermail("awawa@aaaaaaaa").".<br><br>";

echo "string random!! GO!! : ".randomStr(24);