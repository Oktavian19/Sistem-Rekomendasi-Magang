@empty($periode)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan</h5>
                    Data periode magang yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/admin/periode') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('periode/' . $periode->id_periode . '/delete-ajax') }}" method="POST" id="form-delete">
        @csrf
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Periode Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi</h5>
                        Apakah Anda yakin ingin menghapus data periode magang berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Periode:</th>
                            <td class="col-9">{{ $periode->nama_periode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Tanggal Mulai:</th>
                            <td>{{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Tanggal Selesai:</th>
                            <td>{{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d F Y') }}</td>
                        </tr>
                    </table>
                    <div class="alert alert-info mt-3">
                        <i class="icon fas fa-info-circle"></i> Perhatian: Penghapusan periode akan mempengaruhi data magang yang terkait.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
@endif