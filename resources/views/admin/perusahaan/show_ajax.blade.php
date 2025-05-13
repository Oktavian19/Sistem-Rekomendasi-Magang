<div id="modal-show-perusahaan" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Perusahaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Perusahaan</th>
                    <td>{{ $perusahaan->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <th width="30%">Bidang Industri</th>
                    <td>{{ $perusahaan->bidang_industri }}</td>
                </tr>
                <tr>
                    <th width="30%">Alamat</th>
                    <td>{{ $perusahaan->alamat }}</td>
                </tr>
                <tr>
                    <th width="30%">Email</th>
                    <td>{{ $perusahaan->email }}</td>
                </tr>
                <tr>
                    <th width="30%">Nomor Telepon</th>
                    <td>{{ $perusahaan->telepon }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>