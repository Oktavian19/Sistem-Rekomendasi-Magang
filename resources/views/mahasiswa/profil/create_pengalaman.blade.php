<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title fw-bolder w-100 text-center">Tambah Pengalaman</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="formExperience" method="POST" action="https://diploy.id/user/experience">
            <input type="hidden" name="_token" value="nGSD3veJkzgc2yJAowmJm0R1uJB4UKMKJ3jYINtT">
            <div class="row g-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="required form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control form-control-sm" name="company_name" placeholder="Masukkan Nama Perusahaan">
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="form-group">
                        <label class="required form-label">Jabatan Terakhir</label>
                        <input type="text" class="form-control form-control-sm" name="position" placeholder="Masukkan Jabatan Terakhir">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required form-label">Waktu Mulai</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" name="start_date" placeholder="MM/YYYY" autocomplete="off" data-inputmask="'mask': '99/9999'">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required form-label">Waktu Selesai</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm f-endDate" name="end_date" placeholder="MM/YYYY" autocomplete="off" data-inputmask="'mask': '99/9999'">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batalkan</button>
        <button type="submit" class="btn btn-success" form="formExperience">Tambahkan</button>
    </div>
</div>