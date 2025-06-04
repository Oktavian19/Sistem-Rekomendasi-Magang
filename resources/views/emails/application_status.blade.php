<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status Lamaran Magang</title>
</head>
<body>
    <h2>Status Lamaran Magang</h2>

    @if($status === 'diterima')
        <p>Selamat! Lamaran magang Anda di <strong>{{ $lamaran->lowongan->perusahaan->nama_perusahaan }}</strong> telah <strong>diterima</strong>.</p>
        <p>Silakan menunggu informasi lebih lanjut mengenai proses magang.</p>
    @else
        <p>Maaf, lamaran magang Anda di <strong>{{ $lamaran->lowongan->perusahaan->nama_perusahaan }}</strong> telah <strong>ditolak</strong>.</p>
        <p>Anda dapat mencoba melamar ke lowongan lainnya.</p>
    @endif

    <br>

    <!-- Tombol Login -->
    <p>
        <a href="{{ url('/login') }}" style="
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        ">Login ke Sistem</a>
    </p>

    <br>
    <p>Terima kasih,<br>
    {{ config('app.name') }}</p>
</body>
</html>
