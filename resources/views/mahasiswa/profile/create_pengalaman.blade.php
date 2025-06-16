<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title fw-bolder w-100 text-center">Tambah Pengalaman</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="formExperience" method="POST" action="{{ url('profile/pengalaman/store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="required form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control form-control-sm" name="perusahaan"
                            placeholder="Masukkan Nama Perusahaan">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="required form-label">Jabatan Terakhir</label>
                        <input type="text" class="form-control form-control-sm" name="nama_posisi"
                            placeholder="Masukkan Jabatan Terakhir">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required form-label">Tanggal Mulai</label>
                        <div class="input-group input-group-sm">
                            <input type="date" class="form-control form-control-sm" name="tanggal_mulai" required>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required form-label">Tanggal Selesai</label>
                        <div class="input-group input-group-sm">
                            <input type="date" class="form-control form-control-sm" name="tanggal_selesai" required>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-footer justify-content-start">
        <button type="submit" class="btn btn-success" form="formExperience">Tambahkan</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batalkan</button>
    </div>
</div>
