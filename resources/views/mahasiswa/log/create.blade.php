<form action="{{ url('log-kegiatan/store') }}" method="POST" id="form-tambah" class="validate" enctype="multipart/form-data">
    @csrf
    <div id="modal-log" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Log Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Date Input -->
                <div class="form-group mb-4">
                    <label>Tanggal Kegiatan</label>
                    <div class="input-group">
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    </div>
                    <small id="error-tanggal" class="error-text form-text text-danger"></small>
                </div>

                <!-- Week Selector (Optional) -->
                <div class="form-group mb-4">
                    <label>Minggu Ke- (Opsional)</label>
                    <div class="input-group">
                        <select name="minggu" id="minggu" class="form-control">
                            <option value="" disabled selected>Pilih minggu</option>
                            @for ($i = 1; $i <= $jumlahMinggu; $i++)
                                @if (!in_array($i, $mingguTerpakai))
                                    <option value="{{ $i }}">Minggu ke-{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                        <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                    </div>
                </div>

                <!-- Description Input -->
                <div class="form-group mb-4">
                    <label>Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" class="form-control" rows="8" required></textarea>
                    <small id="error-deskripsi_kegiatan" class="error-text form-text text-danger"></small>
                </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label for="images">Upload Gambar (Maksimal 5)</label><br>
                    <small class="text-muted">Format: JPG, PNG (Maksimal 2MB per gambar)</small>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*" required>
                    <small id="error-images" class="error-text form-text text-danger"></small>
                </div>

                <!-- Image Preview -->
                <div class="row mt-3" id="image-preview-container">
                    <!-- Preview images will appear here -->
                </div>
            </div>
            <div class="modal-footer justify-content-start">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</form>