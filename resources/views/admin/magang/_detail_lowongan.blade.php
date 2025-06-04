<div class="row">
    <div class="col-12">
        <h4>Informasi Lowongan</h4>
        <table class="table table-sm">
            <tr>
                <th width="30%">Posisi</th>
                <td>{{ $magang->lamaran->lowongan->nama_posisi }}</td>
            </tr>
            <tr>
                <th>Perusahaan</th>
                <td>{{ $magang->lamaran->lowongan->perusahaan->nama_perusahaan }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{!! $magang->lamaran->lowongan->deskripsi ?? '-' !!}</td>
            </tr>
            <tr>
                <th>Kualifikasi</th>
                <td>{!! $magang->lamaran->lowongan->kualifikasi ?? '-' !!}</td>
            </tr>
        </table>
    </div>
</div>