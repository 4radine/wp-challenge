<?php
// ============================================
// HALAMAN TENTANG TOKO
// ============================================
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/fungsi.php';

$judulHalaman = "Tentang Toko";
$halamanAktif = "tentang.php";

// Data profil toko (disimpan dalam array)
$profilToko = [
    "deskripsi" => "Kami adalah toko komputer online terpercaya yang menyediakan berbagai macam produk berkualitas tinggi dengan harga yang bersaing dan layanan terbaik.",
    "alamat" => "Jl. Raya Utama No. 123, Denpasar, Bali",
    "email" => "support@" . strtolower(str_replace(' ', '', $namaToko)) . ".com",
    "telepon" => "+62 812-3456-7890",
    "jamBuka" => [
        "Senin - Jumat" => "08.00 - 20.00 WITA",
        "Sabtu - Minggu" => "09.00 - 17.00 WITA"
    ],
    "layanan" => [
        "Pengiriman Cepat & Aman",
        "Jaminan Garansi Resmi / Retur",
        "Diskon Menarik Setiap Hari",
        "Layanan Pelanggan 24/7"
    ]
];

require __DIR__ . '/includes/header.php';
?>

<h1 class="text-3xl font-bold mb-1">Tentang <?= $namaToko ?></h1>
<p class="text-slate-500 mb-8">Mengenal lebih dekat toko dan layanan kami.</p>

<div class="grid md:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Deskripsi & Layanan -->
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-3 text-slate-800">Profil Toko</h2>
            <p class="text-slate-600 leading-relaxed"><?= $profilToko["deskripsi"] ?></p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Layanan Kami</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <?php foreach ($profilToko["layanan"] as $item): ?>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="text-blue-600 text-lg">✔</span>
                        <span class="text-sm font-medium text-slate-700"><?= $item ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Alamat & Jam Operasional -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Kontak & Lokasi</h2>
            <ul class="space-y-3 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <span>📍</span>
                    <span><?= $profilToko["alamat"] ?></span>
                </li>
                <li class="flex items-center gap-2">
                    <span>✉️</span>
                    <span><?= $profilToko["email"] ?></span>
                </li>
                <li class="flex items-center gap-2">
                    <span>📞</span>
                    <span><?= $profilToko["telepon"] ?></span>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Jam Operasional</h2>
            <ul class="space-y-2 text-sm">
                <?php foreach ($profilToko["jamBuka"] as $hari =>$jam): ?>
                    <li class="flex justify-between text-slate-600 border-b border-slate-100 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium"><?= $hari ?></span>
                        <span class="text-blue-700 font-semibold"><?= $jam ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>