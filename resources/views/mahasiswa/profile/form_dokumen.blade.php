<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title fw-bolder w-100 text-center">Tambah Dokumen</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="formDocument" method="POST" action="{{ url('profile/dokumen/store') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required form-label">Jenis Dokumen</label>
                            <select class="form-select form-select-sm" name="jenis_dokumen" required>
                                <option value="">Pilih Jenis Dokumen</option>
                                <option value="Curriculum Vitae (CV)">Curriculum Vitae (CV)</option>
                                <option value="Ijazah">Ijazah</option>
                                <option value="Transkrip Nilai">Transkrip Nilai</option>
                                <option value="Sertifikat">Sertifikat</option>
                                <option value="KTP">KTP</option>
                                <option value="NPWP">NPWP</option>
                                <option value="SIM">SIM</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required form-label">File Dokumen</label>
                            <input type="file" class="form-control form-control-sm" name="path_file" accept=".pdf" required>
                            <small class="text-muted">Format: PDF (Max 5MB)</small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batalkan</button>
            <button type="submit" class="btn btn-success" form="formDocument">Simpan</button>
        </div>
    </div>
</div>