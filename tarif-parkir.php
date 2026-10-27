<?php
/* -- atur data disini -- */
$jenis = 'mobil';
$lamaJam = 8;

/* -- konfigurasi -- */
$h_motor = 2000;   # harga parkir motor untuk 2 jam pertama
$h_mobil = 5000;   # harga parkir mobil untuk 2 jam pertama
$hpj_motor = 1000; # harga parkir motor per jam setelah 2 jam
$hpj_mobil = 3000; # harga parkir mobil per jam setelah 2 jam

/* -- kode -- */
$harga = 0;
if ($lamaJam > 2) {
    if ($jenis == 'motor') $harga += $h_motor;
    if ($jenis == 'mobil') $harga += $h_mobil;
    for ($i = 0; $i < ($lamaJam - 2); $i++) {
        if ($jenis == 'motor') $harga += $hpj_motor;
        if ($jenis == 'mobil') $harga += $hpj_mobil;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarif Parkir</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="flex min-h-screen items-center justify-center bg-slate-100 p-4">
        <div class="w-full max-w-sm rounded-xl border border-slate-200 bg-white p-6 shadow-md transition-all hover:shadow-lg">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Rincian Parkir</span>
            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-600">Menunggu Pembayaran</span>
            </div>

            <div class="space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Jenis Kendaraan</span>
                <span class="font-medium text-slate-800"><?php echo ucfirst($jenis); ?></span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Durasi Parkir</span>
                <span class="font-medium text-slate-800"><?php echo $lamaJam; ?> Jam</span>
            </div>

            <div class="my-3 border-t border-dashed border-slate-200"></div>

            <div class="flex items-baseline justify-between pt-1">
                <span class="text-base font-semibold text-slate-700">Total Tarif</span>
                <span class="text-2xl font-bold text-blue-600">
                Rp <?= number_format($harga, 0, ',', '.'); ?>
                </span>
            </div>
            </div>
        </div>
    </div>
</body>
</html>