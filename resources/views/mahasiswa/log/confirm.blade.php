@empty($log)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan</h5>
                    Data log kegiatan yang anda cari tidak ditemukan
                </div>
                <a href="{{ route('log-kegiatan.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ route('log-kegiatan.destroy', $log->id) }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Log Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi</h5>
                        Apakah Anda yakin ingin menghapus log kegiatan berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Tanggal:</th>
                            <td class="col-9">{{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right align-top">Minggu Ke-:</th>
                            <td>{{ $log->minggu ? 'Minggu ke-'.$log->minggu : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right align-top">Deskripsi:</th>
                            <td>{{ Str::limit($log->deskripsi_kegiatan, 100) }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Jumlah Gambar:</th>
                            <td>{{ $log->images->count() }} gambar</td>
                        </tr>
                    </table>
                    <div class="alert alert-info mt-3">
                        <i class="icon fas fa-info-circle"></i> Perhatian: 
                        <ul class="mb-0 mt-2">
                            <li>Data yang sudah dihapus tidak dapat dikembalikan</li>
                            <li>Semua gambar terkait juga akan dihapus</li>
                        </ul>
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