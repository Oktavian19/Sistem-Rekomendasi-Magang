<div id="modal-show-lowongan" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Lowongan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Posisi</th>
                    <td>{{ $lowongan->nama_posisi }}</td>
                </tr>
                <tr>
                    <th width="30%">Perusahaan</th>
                    <td>{{ $lowongan->perusahaan->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <th width="30%">Deskripsi</th>
                    <td>{{ $lowongan->deskripsi }}</td>
                </tr>
                <tr>
                    <th width="30%">Kategori Keahlian</th>
                    <td>{{ $lowongan->bidangKeahlian->label }}</td>
                </tr>
                <tr>
                    <th width="30%">Kategori Keahlian</th>
                    <td>{{ $lowongan->jenisPelaksanaan->label }}</td>
                </tr>
                <tr>
                    <th width="30%">Kuota</th>
                    <td>{{ $lowongan->kuota }}</td>
                </tr>
                <tr>
                    <th width="30%">Persyaratan</th>
                    <td>{{ $lowongan->persyaratan }}</td>
                </tr>
                <tr>
                    <th>Tanggal Buka</th>
                    <td>{{ \Carbon\Carbon::parse($lowongan->tanggal_buka)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Tutup</th>
                    <td>{{ \Carbon\Carbon::parse($lowongan->tanggal_tutup)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th width="30%">Durasi Magang</th>
                    <td>{{ $lowongan->durasiMagang->label }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>