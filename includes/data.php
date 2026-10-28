<?php
// ============================================
// DATA TOKO (sementara disimpan di array)
// Pada Pertemuan 7, data ini akan dipindah ke database MySQL.
// ============================================

$namaToko = "Computah";

// Array multidimensi: kode produk => data produk (array asosiatif)
$produk = [
    "P001" => [
        "nama"     => "Kabel HDMI 5 Meter",
        "kategori" => "Kabel",
        "harga"    => 125000,
        "diskon"   => 5,          // dalam persen
        "stok"     => 5,
        "ikon"     => "assets/products/hdmi-cable.png",
    ],
    "P002" => [
        "nama"     => "VGA to HDMI (Bidirectional)",
        "kategori" => "Adapter",
        "harga"    => 105000,
        "diskon"   => 5,
        "stok"     => 7,
        "ikon"     => "assets/products/vga-hdmi-converter.png",
    ],
    "P003" => [
        "nama"     => "USB-C to USB-A 2 Meter (3A Max)",
        "kategori" => "Kabel",
        "harga"    => 57000,
        "diskon"   => 0,
        "stok"     => 2,
        "ikon"     => "assets/products/usbc-usba.png",
    ],
    "P004" => [
        "nama"     => "USB-C to USB-C 2 Meter (240W Max)",
        "kategori" => "Kabel",
        "harga"    => 235000,
        "diskon"   => 0,
        "stok"     => 0,
        "ikon"     => "assets/products/usbc-usbc.png",
    ],
    "P005" => [
        "nama"     => "USB-C (male) to USB-A (female, 3.0)",
        "kategori" => "Adapter",
        "harga"    => 45000,
        "diskon"   => 10,
        "stok"     => 12,
        "ikon"     => "assets/products/usbc-usba.png",
    ],
    "P006" => [
        "nama"     => "Keyboard Wireless Membrane 70%",
        "kategori" => "Aksesoris",
        "harga"    => 350000,
        "diskon"   => 20,
        "stok"     => 4,
        "ikon"     => "assets/products/wireless-keyboard.png",
    ],
    "P007" => [
        "nama"     => "Flashdisk 128GB USB-A 3.0",
        "kategori" => "Penyimpanan",
        "harga"    => 310000,
        "diskon"   => 0,
        "stok"     => 4,
        "ikon"     => "assets/products/generic-flashdisk.png",
    ],
    "P008" => [
        "nama"     => "Headset Flex (3.5mm)",
        "kategori" => "Aksesoris",
        "harga"    => 75000,
        "diskon"   => 15,
        "stok"     => 4,
        "ikon"     => "assets/products/headset.webp",
    ],
    "P009" => [
        "nama"     => "Webcam HD USB-A 2.0",
        "kategori" => "Aksesoris",
        "harga"    => 115000,
        "diskon"   => 30,
        "stok"     => 4,
        "ikon"     => "assets/products/generic-webcam.png",
    ],
];

// Contoh pesanan pelanggan: kode produk => jumlah yang dibeli
$pesanan = [
    "P001" => 2,
    "P003" => 3,
    "P006" => 1,
];