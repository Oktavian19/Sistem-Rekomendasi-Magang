<!DOCTYPE html>
<html>
<head>
    <title>Data Magang</title>
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
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
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
        <div class="title">DATA MAGANG MAHASISWA</div>
        <div class="filter-info">
            @if($statusFilter || $prodiFilter)
                Filter: 
                @if($statusFilter) Status: {{ ucfirst($statusFilter) }} @endif
                @if($statusFilter && $prodiFilter), @endif
                @if($prodiFilter) Prodi: {{ $prodiFilter }} @endif
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Program Studi</th>
                <th>Lowongan</th>
                <th>Perusahaan</th>
                <th>Status</th>
                <th>Dosen Pembimbing</th>
            </tr>
        </thead>
        <tbody>
            @foreach($magang as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->lamaran->mahasiswa->nama }}</td>
                    <td>{{ $item->lamaran->mahasiswa->nim }}</td>
                    <td>{{ $item->lamaran->mahasiswa->programStudi->nama_program_studi }}</td>
                    <td>{{ $item->lamaran->lowongan->nama_posisi }}</td>
                    <td>{{ $item->lamaran->lowongan->perusahaan->nama_perusahaan }}</td>
                    <td>{{ ucfirst($item->status_magang) }}</td>
                    <td>{{ $item->dosenPembimbing ? $item->dosenPembimbing->nama : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>