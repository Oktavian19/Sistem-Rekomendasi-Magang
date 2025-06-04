<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Perusahaan</title>
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
        <div class="title">DATA PERUSAHAAN MITRA</div>
        <div class="subtitle">Daftar Perusahaan Mitra Kerjasama</div>
    </div>
    
    <div class="filter-info">
        Filter: {{ $filter }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perusahaan</th>
                <th>Alamat</th>
                <th>Jenis Perusahaan</th> <!-- Kolom ditambahkan -->
                <th>Bidang Industri</th>
                <th>Telepon</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nama_perusahaan }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->jenisPerusahaan ? $item->jenisPerusahaan->label : '-' }}</td>
                <td>{{ $item->bidang_industri }}</td>
                <td>{{ $item->telepon }}</td>
                <td>{{ $item->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>