<div class="row">
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
                    <td>{{ $lamaran->lowongan->jenisPelaksanaan->label }}</td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td>{{ $lamaran->lowongan->durasiMagang->label }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>
                        {{ \Carbon\Carbon::parse($lamaran->lowongan->tanggal_buka)->translatedFormat('d F Y') }} -
                        {{ \Carbon\Carbon::parse($lamaran->lowongan->tanggal_tutup)->translatedFormat('d F Y') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if ($lamaran->lowongan->deskripsi)
    <div class="row">
        <div class="col-12">
            <h5>Deskripsi Lowongan</h5>
            <div class="card card-body bg-light">
                {!! nl2br(e($lamaran->lowongan->deskripsi)) !!}
            </div>
        </div>
    </div>
@endif

@if ($lamaran->lowongan->persyaratan)
    <div class="row mt-3">
        <div class="col-12">
            <h5>Persyaratan</h5>
            <div class="card card-body bg-light">
                {!! nl2br(e($lamaran->lowongan->persyaratan)) !!}
            </div>
        </div>
    </div>
@endif
