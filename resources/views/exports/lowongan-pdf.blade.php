<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Lowongan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
        }
        .filter-info {
            font-size: 14px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DATA LOWONGAN MAGANG</div>
        <div class="subtitle">Daftar Lowongan Magang yang Tersedia</div>
    </div>
    
    <div class="filter-info">
        {{ $filter_posisi }} | {{ $filter_pelaksanaan }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Perusahaan</th>
                <th>Posisi</th>
                <th>Jenis Pelaksanaan</th>
                <th>Durasi</th>
                <th>Kuota</th>
                <th>Tanggal Buka</th>
                <th>Tanggal Tutup</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->perusahaan->nama_perusahaan ?? '-' }}</td>
                <td>{{ $item->nama_posisi }}</td>
                <td>{{ $item->jenisPelaksanaan->label ?? '-' }}</td>
                <td>{{ $item->durasiMagang->label ?? '-' }}</td>
                <td>{{ $item->kuota }}</td>
                <td>{{ $item->tanggal_buka ? date('d/m/Y', strtotime($item->tanggal_buka)) : '-' }}</td>
                <td>{{ $item->tanggal_tutup ? date('d/m/Y', strtotime($item->tanggal_tutup)) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>