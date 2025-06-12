<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title fw-bolder w-100 text-center">Edit Pengalaman</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="formEditExperience" method="POST" action="{{ url('profile/pengalaman', $pengalaman->id_pengalaman) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="required form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control form-control-sm" name="perusahaan"
                            id="edit_perusahaan" value="{{ old('perusahaan', $pengalaman->perusahaan) }}"
                            placeholder="Masukkan Nama Perusahaan">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="required form-label">Jabatan Terakhir</label>

                        <input type="text" class="form-control form-control-sm" name="nama_posisi"
                            id="edit_nama_posisi" value="{{ old('nama_posisi', $pengalaman->nama_posisi) }}"
                            placeholder="Masukkan Jabatan Terakhir">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required form-label">Tanggal Mulai</label>
                        <div class="input-group input-group-sm">
                            <input type="date" class="form-control form-control-sm" name="tanggal_mulai"
                                id="edit_tanggal_mulai" value="{{ old('tanggal_mulai', $pengalaman->tanggal_mulai) }}"
                                required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required form-label">Tanggal Selesai</label>
                        <div class="input-group input-group-sm">
                            <input type="date" class="form-control form-control-sm" name="tanggal_selesai"
                                id="edit_tanggal_selesai"
                                value="{{ old('tanggal_selesai', $pengalaman->tanggal_selesai) }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer justify-content-start">
        <button type="submit" class="btn btn-success" form="formEditExperience">Simpan Perubahan</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batalkan</button>
    </div>
</div>
