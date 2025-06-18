<!DOCTYPE html>
<html>

<head>
    <title>Selamat Ulang Tahun</title>
</head>

<body>
    <h2>Hai {{ $user->name }},</h2>

    <p>🎉 Selamat ulang tahun! Tim Sashop Gorontalo ingin merayakan momen spesialmu dengan kejutan istimewa 🎁</p>

    <p>Kamu mendapatkan <strong>Diskon Ulang Tahun sebesar 10%</strong> untuk semua produk pilihanmu!</p>

    <p>📅 <strong>Berlaku: Hanya tanggal {{ \Carbon\Carbon::parse($user->birth_date)->format('d F Y') }}</strong></p>

    <p>Jangan lewatkan kesempatan ini untuk belanja produk favoritmu dengan harga lebih hemat 💕</p>

    <p>Terima kasih sudah menjadi bagian dari keluarga Sashop. Semoga ulang tahunmu penuh kebahagiaan dan cinta!</p>

    <p>Salam hangat,<br>
        Tim Sashop Gorontalo</p>
</body>

</html>
