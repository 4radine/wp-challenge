<?php
// ============================================
// HALAMAN KATALOG PRODUK (SIDEBAR, MODAL & SEARCH)
// ============================================
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/fungsi.php';

$judulHalaman = "Katalog";
$halamanAktif = "index.php";

// --------------------------------------------
// 1. LOGIKA FILTER, SEARCH & PENCARIAN
// --------------------------------------------
$keyword         = isset($_GET['q']) ? trim($_GET['q']) : '';
$kategoriDipilih = $_GET['kategori'] ?? '';
$hargaMin        = isset($_GET['min_harga']) && $_GET['min_harga'] !== '' ? (int)$_GET['min_harga'] : null;
$hargaMax        = isset($_GET['max_harga']) && $_GET['max_harga'] !== '' ? (int)$_GET['max_harga'] : null;
$hanyaDiskon     = isset($_GET['hanya_diskon']) && $_GET['hanya_diskon'] === '1';
$bisaCod         = isset($_GET['bisa_cod']) && $_GET['bisa_cod'] === '1';
$urutkan         = $_GET['urutkan'] ?? '';

// Hitung statistik kategori & data produk terfilter
$jumlahPerKategori = [];
$produkTerfilter   = [];
$produkTermurah    = null;
$hargaTermurah     = INF;

foreach ($produk as $kode => $item) {
    // Hitung jumlah produk per kategori (untuk sidebar filter)
    $kat = $item["kategori"];
    $jumlahPerKategori[$kat] = ($jumlahPerKategori[$kat] ?? 0) + 1;

    $hargaAkhir = hargaSetelahDiskon($item["harga"], $item["diskon"]);

    // Cari Produk Termurah (dari seluruh katalog)
    if ($hargaAkhir < $hargaTermurah) {
        $hargaTermurah = $hargaAkhir;
        $produkTermurah = $item;
    }

    // Filter Search Keyword
    if ($keyword !== '' && stripos($item["nama"], $keyword) === false) {
        continue;
    }

    // Filter Kategori
    if ($kategoriDipilih !== '' && $item["kategori"] !== $kategoriDipilih) {
        continue;
    }

    // Filter Range Harga
    if ($hargaMin !== null && $hargaAkhir < $hargaMin) {
        continue;
    }
    if ($hargaMax !== null && $hargaAkhir > $hargaMax) {
        continue;
    }

    // Filter Hanya Diskon
    if ($hanyaDiskon && $item["diskon"] <= 0) {
        continue;
    }

    // Filter Bisa COD
    if ($bisaCod && empty($item["cod"])) {
        continue;
    }

    $produkTerfilter[$kode] = $item;
}

// Sorting / Pengurutan Produk
if ($urutkan === 'termurah') {
    uasort($produkTerfilter, function($a, $b) {
        return hargaSetelahDiskon($a['harga'], $a['diskon']) <=> hargaSetelahDiskon($b['harga'], $b['diskon']);
    });
} elseif ($urutkan === 'termahal') {
    uasort($produkTerfilter, function($a, $b) {
        return hargaSetelahDiskon($b['harga'], $b['diskon']) <=> hargaSetelahDiskon($a['harga'], $a['diskon']);
    });
} elseif ($urutkan === 'diskon') {
    uasort($produkTerfilter, function($a, $b) {
        return $b['diskon'] <=> $a['diskon'];
    });
}

// Fitur Rata-rata Harga & Statistik Ringkasan
$semuaHarga    = array_column($produk, 'harga');
$rataRataHarga = count($semuaHarga) > 0 ? array_sum($semuaHarga) / count($semuaHarga) : 0;
$jumlahProduk  = count($produk);
$jumlahDiskon  = hitungProdukDiskon($produk);
$nilaiStok     = hitungNilaiStok($produk);

require __DIR__ . '/includes/header.php';
?>

<!-- Header Katalog & Rata-rata Harga -->
<div class="mb-6">
    <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mb-1">Katalog Produk</h1>
    <p class="text-slate-500 text-xs md:text-sm">
        Rata-rata harga produk: 
        <span class="font-semibold text-purple-700"><?= formatRupiah($rataRataHarga) ?></span>
    </p>
</div>

<!-- Grid 4 Ringkasan Toko (2 Kolom 2 Row di HP, 4 Kolom di Desktop) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-3 md:p-4">
        <p class="text-[10px] md:text-xs font-semibold text-purple-600 uppercase tracking-wider">Total Produk</p>
        <p class="text-lg md:text-2xl font-bold text-slate-800"><?= $jumlahProduk ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-3 md:p-4">
        <p class="text-[10px] md:text-xs font-semibold text-purple-600 uppercase tracking-wider">Sedang Diskon</p>
        <p class="text-lg md:text-2xl font-bold"><?= $jumlahDiskon ?> produk</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-3 md:p-4">
        <p class="text-[10px] md:text-xs font-semibold text-purple-600 uppercase tracking-wider">Total Nilai Stok</p>
        <p class="text-lg md:text-2xl font-bold text-slate-800"><?= formatRupiah($nilaiStok) ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-3 md:p-4">
        <p class="text-[10px] md:text-xs font-semibold text-purple-600 uppercase tracking-wider">Produk Termurah</p>
        <p class="text-sm md:text-base font-bold truncate" title="<?= $produkTermurah['nama'] ?? '-' ?>">
            <?= formatRupiah($hargaTermurah) ?>
        </p>
        <p class="text-[10px] text-slate-400 truncate"><?= $produkTermurah['nama'] ?? '' ?></p>
    </div>
</div>

<!-- SEARCH BAR & TRIGGER FILTER MOBILE -->
<form method="GET" action="index.php" class="mb-6 flex gap-2">
    <!-- Simpan state filter saat melakukan search -->
    <?php if ($kategoriDipilih): ?><input type="hidden" name="kategori" value="<?= htmlspecialchars($kategoriDipilih) ?>"><?php endif; ?>
    <?php if ($hargaMin): ?><input type="hidden" name="min_harga" value="<?= htmlspecialchars($hargaMin) ?>"><?php endif; ?>
    <?php if ($hargaMax): ?><input type="hidden" name="max_harga" value="<?= htmlspecialchars($hargaMax) ?>"><?php endif; ?>
    <?php if ($hanyaDiskon): ?><input type="hidden" name="hanya_diskon" value="1"><?php endif; ?>
    <?php if ($bisaCod): ?><input type="hidden" name="bisa_cod" value="1"><?php endif; ?>
    <?php if ($urutkan): ?><input type="hidden" name="urutkan" value="<?= htmlspecialchars($urutkan) ?>"><?php endif; ?>

    <!-- Search Input dengan Tombol Cari di Dalam Kanan -->
    <div class="relative flex-1">
        <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nama produk..." class="w-full text-sm pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-purple-600 focus:ring-1 focus:ring-purple-600 shadow-sm">
        <button type="submit" class="absolute right-1.5 top-1.5 p-1.5 text-slate-400 hover:text-purple-700 transition" title="Cari">
            🔍
        </button>
    </div>

    <!-- Tombol Filter khusus Mobile di Sebelah Kanan Search Bar -->
    <button type="button" onclick="document.getElementById('mobile-filter-modal').classList.remove('hidden')" class="md:hidden flex items-center gap-1.5 bg-white border border-slate-200 text-slate-700 font-semibold px-3 py-2.5 rounded-xl text-sm shadow-sm hover:bg-slate-50 transition">
        <span>🎛️</span> Filter
    </button>
</form>

<!-- MODAL FILTER MOBILE (Pop-up / Bottom Sheet) -->
<div id="mobile-filter-modal" class="hidden fixed inset-0 bg-slate-900/50 z-50 flex items-end justify-center md:hidden">
    <div class="bg-white w-full max-h-[85vh] overflow-y-auto rounded-t-2xl p-5 space-y-5 shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="font-bold text-slate-800 text-base flex items-center gap-2">
                <span>🎛️</span> Filter Katalog
            </h2>
            <button type="button" onclick="document.getElementById('mobile-filter-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">
                ✕
            </button>
        </div>

        <form method="GET" action="index.php" class="space-y-4">
            <?php if ($keyword): ?><input type="hidden" name="q" value="<?= htmlspecialchars($keyword) ?>"><?php endif; ?>

            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kategori</h3>
                <div class="space-y-1 text-sm">
                    <label class="flex items-center justify-between cursor-pointer text-slate-600 py-1">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="kategori" value="" <?= $kategoriDipilih === '' ? 'checked' : '' ?> class="text-purple-600 focus:ring-purple-500">
                            Semua
                        </span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded-full text-slate-500"><?= $jumlahProduk ?></span>
                    </label>
                    <?php foreach ($jumlahPerKategori as $kat => $jumlah): ?>
                        <label class="flex items-center justify-between cursor-pointer text-slate-600 py-1">
                            <span class="flex items-center gap-2">
                                <input type="radio" name="kategori" value="<?= $kat ?>" <?= $kategoriDipilih === $kat ? 'checked' : '' ?> class="text-purple-600 focus:ring-purple-500">
                                <?= $kat ?>
                            </span>
                            <span class="text-xs bg-purple-50 text-purple-700 font-medium px-2 py-0.5 rounded-full"><?= $jumlah ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <hr class="border-slate-100">

            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Rentang Harga</h3>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" name="min_harga" value="<?= htmlspecialchars($_GET['min_harga'] ?? '') ?>" placeholder="Min Rp" class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-purple-600">
                    <input type="number" name="max_harga" value="<?= htmlspecialchars($_GET['max_harga'] ?? '') ?>" placeholder="Max Rp" class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-purple-600">
                </div>
            </div>

            <hr class="border-slate-100">

            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Penawaran</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="hanya_diskon" value="1" <?= $hanyaDiskon ? 'checked' : '' ?> class="rounded text-purple-600 focus:ring-purple-500">
                        <span>Sedang Diskon</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="bisa_cod" value="1" <?= $bisaCod ? 'checked' : '' ?> class="rounded text-purple-600 focus:ring-purple-500">
                        <span>Bisa COD</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white font-semibold py-2.5 rounded-xl text-sm transition shadow-sm mt-2">
                Terapkan Filter
            </button>
        </form>
    </div>
</div>

<!-- LAYOUT UTAMA: SIDEBAR (DESKTOP) + KATALOG -->
<div class="flex flex-col md:flex-row gap-6">

    <!-- SIDEBAR KIRI DESKTOP (PADAT & LENGKAP) -->
    <aside class="hidden md:block w-64 flex-shrink-0 space-y-4">
        
        <!-- Widget 1: Form Filter Utama -->
        <form method="GET" action="index.php" class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 space-y-5">
            <?php if ($keyword): ?><input type="hidden" name="q" value="<?= htmlspecialchars($keyword) ?>"><?php endif; ?>

            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <span>🎛️</span> Filter Katalog
                </h2>
                <?php if ($kategoriDipilih || $hargaMin || $hargaMax || $hanyaDiskon || $bisaCod || $keyword || $urutkan): ?>
                    <a href="index.php" class="text-xs text-purple-600 hover:underline">Reset</a>
                <?php endif; ?>
            </div>

            <!-- Urutkan Produk -->
            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Urutkan</h3>
                <select name="urutkan" class="w-full text-xs px-2.5 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-purple-600 text-slate-600">
                    <option value="">Paling Sesuai</option>
                    <option value="termurah" <?= $urutkan === 'termurah' ? 'selected' : '' ?>>Harga: Terrendah</option>
                    <option value="termahal" <?= $urutkan === 'termahal' ? 'selected' : '' ?>>Harga: Tertinggi</option>
                    <option value="diskon" <?= $urutkan === 'diskon' ? 'selected' : '' ?>>Diskon Terbesar</option>
                </select>
            </div>

            <hr class="border-slate-100">

            <!-- Filter Kategori -->
            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kategori</h3>
                <div class="space-y-1.5 text-sm">
                    <label class="flex items-center justify-between cursor-pointer text-slate-600 hover:text-purple-700 py-0.5">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="kategori" value="" <?= $kategoriDipilih === '' ? 'checked' : '' ?> class="text-purple-600 focus:ring-purple-500">
                            Semua
                        </span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded-full text-slate-500"><?= $jumlahProduk ?></span>
                    </label>

                    <?php foreach ($jumlahPerKategori as $kat => $jumlah): ?>
                        <label class="flex items-center justify-between cursor-pointer text-slate-600 hover:text-purple-700 py-0.5">
                            <span class="flex items-center gap-2">
                                <input type="radio" name="kategori" value="<?= $kat ?>" <?= $kategoriDipilih === $kat ? 'checked' : '' ?> class="text-purple-600 focus:ring-purple-500">
                                <?= $kat ?>
                            </span>
                            <span class="text-xs bg-purple-50 text-purple-700 font-medium px-2 py-0.5 rounded-full"><?= $jumlah ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Rentang Harga -->
            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Rentang Harga</h3>
                <div class="space-y-2">
                    <input type="number" name="min_harga" value="<?= htmlspecialchars($_GET['min_harga'] ?? '') ?>" placeholder="Harga Min (Rp)" class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-purple-600">
                    <input type="number" name="max_harga" value="<?= htmlspecialchars($_GET['max_harga'] ?? '') ?>" placeholder="Harga Max (Rp)" class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-purple-600">
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Penawaran -->
            <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Penawaran</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 hover:text-purple-700">
                        <input type="checkbox" name="hanya_diskon" value="1" <?= $hanyaDiskon ? 'checked' : '' ?> class="rounded text-purple-600 focus:ring-purple-500">
                        <span>Sedang Diskon</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 hover:text-purple-700">
                        <input type="checkbox" name="bisa_cod" value="1" <?= $bisaCod ? 'checked' : '' ?> class="rounded text-purple-600 focus:ring-purple-500">
                        <span>Bisa COD</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white font-semibold py-2 px-4 rounded-xl text-xs transition shadow-sm">
                Terapkan Filter
            </button>
        </form>

    </aside>

    <!-- KATALOG PRODUK (2 KOLOM DI MOBILE) -->
    <main class="flex-1">
        <?php if (empty($produkTerfilter)): ?>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                <p class="text-4xl mb-3">🔍</p>
                <h3 class="text-base md:text-lg font-bold text-slate-700 mb-1">Produk Tidak Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 mb-4">Coba ubah kata kunci atau kombinasi filter di sidebar.</p>
                <a href="index.php" class="inline-block bg-purple-100 text-purple-700 font-semibold px-4 py-2 rounded-lg text-xs md:text-sm hover:bg-purple-200 transition">
                    Lihat Semua Produk
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
                <?php foreach ($produkTerfilter as $kode => $item): ?>
                    <?php $hargaAkhir = hargaSetelahDiskon($item["harga"], $item["diskon"]); ?>
                    
                    <article class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-md transition">
                        
                        <!-- Image Container -->
                        <div class="bg-slate-50 h-36 md:h-48 flex items-center justify-center relative">
                            <?php if (file_exists($item["ikon"])): ?>
                                <img src="<?= $item["ikon"] ?>" alt="<?= $item["nama"] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-3xl md:text-5xl"><?= $item["ikon"] ?></span>
                            <?php endif; ?>

                            <?php if ($item["diskon"] > 0): ?>
                                <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] md:text-xs font-bold px-1.5 py-0.5 md:px-2 md:py-1 rounded-full shadow-sm">
                                    -<?= $item["diskon"] ?>%
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Content Detail -->
                        <div class="p-2.5 md:p-4 flex flex-col flex-1">
                            <p class="text-[10px] md:text-xs text-purple-700 font-semibold mb-0.5 md:mb-1"><?= $kode ?> &middot; <?= $item["kategori"] ?></p>
                            <h2 class="font-bold text-slate-800 text-xs md:text-base mb-1 line-clamp-1"><?= $item["nama"] ?></h2>
                            
                            <?php if (!empty($item["deskripsi"])): ?>
                                <p class="text-[10px] md:text-xs text-slate-500 mb-2 line-clamp-2 hidden sm:block"><?= $item["deskripsi"] ?></p>
                            <?php endif; ?>

                            <div class="mt-auto pt-1 md:pt-2">
                                <?php if ($item["diskon"] > 0): ?>
                                    <p class="text-[10px] md:text-xs text-slate-400 line-through"><?= formatRupiah($item["harga"]) ?></p>
                                <?php endif; ?>
                                <p class="text-sm md:text-lg font-bold text-purple-700 mb-2"><?= formatRupiah($hargaAkhir) ?></p>

                                <div class="flex items-center justify-between flex-wrap gap-1">
                                    <span class="text-[10px] md:text-xs font-semibold px-2 py-0.5 md:px-2.5 md:py-1 rounded-full <?= warnaStok($item["stok"]) ?>">
                                        <?= labelStok($item["stok"]) ?>
                                    </span>
                                    <?php if (!empty($item["cod"])): ?>
                                        <span class="text-[9px] md:text-[10px] bg-slate-100 text-slate-600 font-medium px-1.5 py-0.5 rounded border border-slate-200">
                                            🤝 COD
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>