@empty($programStudi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan</h5>
                    Data program studi yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/program-studi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('program-studi/' . $programStudi->id_program_studi . '/delete-ajax') }}" method="POST" id="form-delete">
        @csrf
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Program Studi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi</h5>
                        Apakah Anda yakin ingin menghapus data program studi berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Kode Program Studi:</th>
                            <td class="col-9">{{ $programStudi->kode_program_studi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Program Studi:</th>
                            <td class="col-9">{{ $programStudi->nama_program_studi }}</td>
                        </tr>
                    </table>
                    <div class="alert alert-info mt-3">
                        <i class="icon fas fa-info-circle"></i> Perhatian: Penghapusan program studi akan mempengaruhi data mahasiswa yang terkait.
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