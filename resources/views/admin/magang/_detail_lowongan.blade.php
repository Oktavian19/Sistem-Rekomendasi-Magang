<div class="row">
    <div class="col-md-12">
        <h5>Informasi Lowongan</h5>
        <div class="mb-3">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="35%">Posisi</th>
                    <td>{{ $magang->lamaran->lowongan->nama_posisi }}</td>
                </tr>
                <tr>
                    <th>Perusahaan</th>
                    <td>{{ $magang->lamaran->lowongan->perusahaan->nama_perusahaan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Magang</th>
                    <td>{{ $magang->lamaran->lowongan->jenisPelaksanaan->label }}</td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td>{{ $magang->lamaran->lowongan->durasiMagang->label }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>
                        {{ \Carbon\Carbon::parse($magang->lamaran->lowongan->tanggal_buka)->translatedFormat('d F Y') }} -
                        {{ \Carbon\Carbon::parse($magang->lamaran->lowongan->tanggal_tutup)->translatedFormat('d F Y') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if ($magang->lamaran->lowongan->deskripsi)
    <div class="row">
        <div class="col-12">
            <h5>Deskripsi Lowongan</h5>
            <div class="card card-body bg-light">
                {!! nl2br(e($magang->lamaran->lowongan->deskripsi)) !!}
            </div>
        </div>
    </div>
@endif

@if ($magang->lamaran->lowongan->persyaratan)
    <div class="row mt-3">
        <div class="col-12">
            <h5>Persyaratan</h5>
            <div class="card card-body bg-light">
                {!! nl2br(e($magang->lamaran->lowongan->persyaratan)) !!}
            </div>
        </div>
    </div>
@endif
