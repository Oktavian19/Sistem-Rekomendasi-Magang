<!DOCTYPE html>
<html>
<head>
    <title>Daftar Lamaran Magang</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .filter-info { margin-bottom: 15px; font-size: 14px; }
        .badge-success { background-color: #d1e7dd; color: #0f5132; padding: 3px 6px; border-radius: 4px; }
        .badge-warning { background-color: #fff3cd; color: #664d03; padding: 3px 6px; border-radius: 4px; }
        .badge-danger { background-color: #f8d7da; color: #842029; padding: 3px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">DAFTAR LAMARAN MAGANG</div>
        <div>Universitas Anda</div>
    </div>

    @if($filterStatus || $filterProdi)
    <div class="filter-info">
        <strong>Filter:</strong>
        @if($filterStatus) Status: {{ ucfirst($filterStatus) }} @endif
        @if($filterStatus && $filterProdi), @endif
        @if($filterProdi) Program Studi: {{ \App\Models\ProgramStudi::find($filterProdi)->nama_program_studi }} @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Lowongan</th>
                <th>Perusahaan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lamaran as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->mahasiswa->nim }}</td>
                <td>{{ $item->mahasiswa->nama }}</td>
                <td>{{ $item->lowongan->nama_posisi }}</td>
                <td>{{ $item->lowongan->perusahaan->nama_perusahaan }}</td>
                <td>
                    <span class="badge-{{ $item->status_lamaran }}">
                        {{ ucfirst($item->status_lamaran) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>