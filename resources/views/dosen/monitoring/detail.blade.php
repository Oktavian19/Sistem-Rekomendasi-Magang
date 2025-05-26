<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Magang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>Posisi</th>
                    <td>{{ $posisi }}</td>
                </tr>
                <tr>
                    <th>Perusahaan</th>
                    <td>{{ $perusahaan }}</td>
                </tr>
                <tr>
                    <th>Bidang Industri</th>
                    <td>{{ $bidang }}</td>
                </tr>
                <tr>
                    <th>Durasi Magang</th>
                    <td>{{ $durasi }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $alamat }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
