<div id="modal-show-periode" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Periode Magang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Periode</th>
                    <td>{{ $periode->nama_periode }}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d F Y') }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>