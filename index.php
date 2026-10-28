<?php
// ============================================
// HALAMAN KATALOG PRODUK
// ============================================
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/fungsi.php';

$judulHalaman = "Katalog";
$halamanAktif = "index.php";

// Ringkasan toko
$jumlahProduk  = count($produk);
$jumlahDiskon  = hitungProdukDiskon($produk);
$nilaiStok     = hitungNilaiStok($produk);

$semuaHarga = array_column($produk, 'harga');
$rataRataHarga = array_sum($semuaHarga) / count($semuaHarga);

$kategoriDipilih = (isset($_GET['kategori'])) ? $_GET['kategori'] : "";

$jumlahPerKategori = [];
foreach ($produk as $item) {
    $kat = $item["kategori"];
    $jumlahPerKategori[$kat] = ($jumlahPerKategori[$kat] ?? 0) + 1;
}

require __DIR__ . '/includes/header.php';
?>

<h1 class="text-3xl font-bold mb-1">Katalog Produk</h1>
<p class="text-slate-500 mb-6">Produk untuk meningkatkan efisiensi dan produktivitas anda.</p>
<p class="text-sm text-slate-600 mb-6">
    Rata-rata harga produk: <span class="font-semibold text-blue-700"><?= formatRupiah($rataRataHarga) ?></span>
</p>
<!-- Ringkasan -->
<div class="grid sm:grid-cols-2 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-4">
        <p class="text-sm text-slate-500">Jumlah produk</p>
        <p class="text-2xl font-bold"><?= $jumlahProduk ?></p>
    </div>
    <div class="bg-white rounded-xl shadow p-4">
        <p class="text-sm text-slate-500">Sedang diskon</p>
        <p class="text-2xl font-bold"><?= $jumlahDiskon ?> produk</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4">
        <p class="text-sm text-slate-500">Total nilai stok</p>
        <p class="text-2xl font-bold"><?= formatRupiah($nilaiStok) ?></p>
    </div>
    <div class="bg-white rounded-xl shadow p-4">
        <p class="text-sm text-slate-500">Produk Termurah</p>
        <p class="text-2xl font-bold"><?= cariProdukTermurah($produk)['nama'] ?></p>
    </div>
</div>

<div class="mb-4 text-sm text-slate-600 font-medium">
    Kategori: 
    <?php 
    $output = [];
    foreach ($jumlahPerKategori as $kategori => $jumlah) {
        $output[] = "<a href=\"?kategori=$kategori\" class=\"hover:underline ".(($kategori == $kategoriDipilih) ? "text-blue-700" : "")."\">$kategori ($jumlah)<a>";
    }
    if ($kategoriDipilih !== "") $output[] = "<a href=\"index.php\" class=\"px-2 py-1 rounded-full text-red-700 bg-red-100\"> &times; <a>";
    echo implode(' &middot; ', $output);
    ?>
</div>
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
</div>

<!-- Daftar produk: satu kartu untuk setiap produk -->
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php 
    foreach ($produk as $kode => $item): 
        if ($kategoriDipilih !== "") {
            if ($kategoriDipilih !== $item['kategori']) {
                continue;
            }
        }    
        ?>
        <?php $hargaAkhir = hargaSetelahDiskon($item["harga"], $item["diskon"]); ?>
        <article class="bg-white rounded-xl shadow overflow-hidden flex flex-col">
            <div class="bg-slate-50 text-6xl text-center relative h-48">
                
                <img src="<?= $item["ikon"] ?>" alt="" class="w-full h-full object-cover">
                <?php if ($item["diskon"] > 0): ?>
                    <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        -<?= $item["diskon"] ?>%
                    </span>
                <?php endif; ?>
            </div>
            <div class="p-4 flex flex-col flex-1">
                <p class="text-xs text-slate-500"><?= $kode ?> &middot; <?= $item["kategori"] ?></p>
                <h2 class="font-semibold text-lg mb-2"><?= $item["nama"] ?></h2>

                <?php if ($item["diskon"] > 0): ?>
                    <p class="text-sm text-slate-400 line-through"><?= formatRupiah($item["harga"]) ?></p>
                <?php endif; ?>
                <p class="text-xl font-bold text-blue-700 mb-3"><?= formatRupiah($hargaAkhir) ?></p>

                <span class="mt-auto self-start text-xs font-semibold px-2 py-1 rounded-full <?= warnaStok($item["stok"]) ?>">
                    <?= labelStok($item["stok"]) ?>
                </span>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php 
    require __DIR__ . '/includes/footer.php'; 
?>