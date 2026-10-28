<?php
// ============================================
// HALAMAN NOTA PESANAN
// ============================================
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/fungsi.php';

$judulHalaman = "Pesanan";
$halamanAktif = "pesanan.php";

$totalBelanja = 0;
$totalBarang  = 0;

foreach ($pesanan as $kode => $jumlah) {
    $hargaAkhir    = hargaSetelahDiskon($produk[$kode]["harga"], $produk[$kode]["diskon"]);
    $totalBelanja += $hargaAkhir * $jumlah;
    $totalBarang  += $jumlah;
}

$potongan   = diskonBelanja($totalBelanja);
$totalBayar = $totalBelanja - $potongan;

require __DIR__ . '/includes/header.php';
?>

<h1 class="text-3xl font-bold mb-6">Nota Pesanan</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <table class="w-full text-left">
        <thead>
            <tr class="border-b text-sm text-slate-500">
                <th class="py-2">No</th>
                <th>Produk</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($pesanan as $kode => $jumlah): ?>
                <?php
                $item       = $produk[$kode];
                $hargaAkhir = hargaSetelahDiskon($item["harga"], $item["diskon"]);
                ?>
                <tr class="border-b">
                    <td class="py-2"><?= $no++ ?></td>
                    <td class="py-2 flex"><img src="<?= $item["ikon"] ?>" class="h-5 me-2" alt=""> <?= $item["nama"] ?></td>
                    <td class="text-right"><?= formatRupiah($hargaAkhir) ?></td>
                    <td class="text-center"><?= $jumlah ?></td>
                    <td class="text-right"><?= formatRupiah($hargaAkhir * $jumlah) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4 space-y-1">
        <p class="flex justify-between"><span>Total barang</span><span><?= $totalBarang ?> item</span></p>
        <p class="flex justify-between"><span>Total belanja</span><span><?= formatRupiah($totalBelanja) ?></span></p>
        <p class="flex justify-between text-red-600"><span>Diskon belanja</span><span>- <?= formatRupiah($potongan) ?></span></p>
        <p class="flex justify-between text-xl font-bold border-t pt-2"><span>Total bayar</span><span><?= formatRupiah($totalBayar) ?></span></p>
    </div>

    <?php if ($potongan === 0): ?>
        <p class="mt-4 text-sm text-slate-500">💡 Belanja minimal <?= formatRupiah(200000) ?> untuk mendapat diskon 10%.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>