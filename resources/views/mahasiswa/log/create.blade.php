<form action="{{ route('log-kegiatan.store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-tanggal-deskripsi" class="modal-dialog modal-lg" role="document">
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
                            @for($i = 1; $i <= $jumlahMinggu; $i++)
                                <option value="{{ $i }}">Minggu ke-{{ $i }}</option>
                            @endfor
                        </select>
                        <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                    </div>
                </div>
                
                <!-- Description Input -->
                <div class="form-group mb-4">
                    <label>Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" class="form-control" rows="8" required></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Image Upload -->
                <div class="form-group">
                    <label for="images">Upload Gambar (Maksimal 5)</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Format: JPG, PNG (Maksimal 2MB per gambar)</small>
                    <small id="error-images" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Image Preview -->
                <div class="row mt-3" id="image-preview-container">
                    <!-- Preview images will appear here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script type="text/javascript">
    // Image preview functionality
    document.getElementById('images').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('image-preview-container');
        previewContainer.innerHTML = '';
        
        const files = event.target.files;
        if (files.length > 5) {
            alert('Maksimal 5 gambar yang dapat diupload');
            this.value = '';
            return;
        }
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!file.type.match('image.*')) continue;
            
            if (file.size > 2 * 1024 * 1024) { // 2MB limit
                alert('File ' + file.name + ' melebihi ukuran maksimal 2MB');
                continue;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const colDiv = document.createElement('div');
                colDiv.className = 'col-md-4 mb-2';
                
                const imgDiv = document.createElement('div');
                imgDiv.className = 'position-relative';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxHeight = '150px';
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                removeBtn.innerHTML = '<i class="bi bi-x"></i>';
                removeBtn.onclick = function() {
                    colDiv.remove();
                    // Create a new DataTransfer object to remove the file
                    const dataTransfer = new DataTransfer();
                    const input = document.getElementById('images');
                    for (let j = 0; j < input.files.length; j++) {
                        if (j !== i) {
                            dataTransfer.items.add(input.files[j]);
                        }
                    }
                    input.files = dataTransfer.files;
                };
                
                imgDiv.appendChild(img);
                imgDiv.appendChild(removeBtn);
                colDiv.appendChild(imgDiv);
                previewContainer.appendChild(colDiv);
            }
            reader.readAsDataURL(file);
        }
    });

    // Set default date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal').value = today;
    });
</script>
@endpush