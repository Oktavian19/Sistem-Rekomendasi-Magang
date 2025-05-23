<div class="row">
    <div class="col-md-12">
        <h5>Informasi Mahasiswa</h5>
        <div class="mb-3">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="35%">Nama</th>
                    <td>{{ $lamaran->mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td>{{ $lamaran->mahasiswa->nim }}</td>
                </tr>
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $lamaran->mahasiswa->program_studi->nama_prodi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $lamaran->mahasiswa->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No. HP</th>
                    <td>{{ $lamaran->mahasiswa->no_hp ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="col-md-12">
        <h5>Informasi Lowongan</h5>
        <div class="mb-3">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="35%">Posisi</th>
                    <td>{{ $lamaran->lowongan->nama_posisi }}</td>
                </tr>
                <tr>
                    <th>Perusahaan</th>
                    <td>{{ $lamaran->lowongan->perusahaan->nama_perusahaan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Magang</th>
                    <td>{{ $lamaran->lowongan->jenis_magang }}</td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td>{{ $lamaran->lowongan->durasi_magang }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>
                        {{ \Carbon\Carbon::parse($lamaran->lowongan->tanggal_buka)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($lamaran->lowongan->tanggal_tutup)->format('d M Y') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h5>Detail Lamaran</h5>
        <div class="mb-3">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="20%">Tanggal Lamar</th>
                    <td>{{ \Carbon\Carbon::parse($lamaran->tanggal_lamaran)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge 
                            @if($lamaran->status_lamaran == 'diterima') bg-success 
                            @elseif($lamaran->status_lamaran == 'ditolak') bg-danger 
                            @else bg-warning text-dark @endif">
                            {{ ucfirst($lamaran->status_lamaran) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Dari Rekomendasi</th>
                    <td>{{ $lamaran->dari_rekomendasi ? 'Ya' : 'Tidak' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if($lamaran->lowongan->deskripsi)
<div class="row">
    <div class="col-12">
        <h5>Deskripsi Lowongan</h5>
        <div class="card card-body bg-light">
            {!! nl2br(e($lamaran->lowongan->deskripsi)) !!}
        </div>
    </div>
</div>
@endif

@if($lamaran->lowongan->persyaratan)
<div class="row mt-3">
    <div class="col-12">
        <h5>Persyaratan</h5>
        <div class="card card-body bg-light">
            {!! nl2br(e($lamaran->lowongan->persyaratan)) !!}
        </div>
    </div>
</div>
@endif