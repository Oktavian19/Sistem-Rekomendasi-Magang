<form action="{{ url('log-magang/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-tanggal-deskripsi" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Log Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Date Input -->
                <div class="form-group mb-4">
                    <label>Tanggal</label>
                    <div class="input-group">
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    </div>
                    <small id="error-tanggal" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Description Input -->
                <div class="form-group mb-4">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="8" required></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Image Upload -->
                <div class="form-group">
                    <label for="images">Upload Gambar (Maksimal 5)</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Anda bisa memilih lebih dari satu gambar</small>
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
                removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                removeBtn.innerHTML = '<i class="bi bi-x"></i>';
                removeBtn.onclick = function() {
                    colDiv.remove();
                    // You might want to implement actual file removal logic here
                };
                
                imgDiv.appendChild(img);
                imgDiv.appendChild(removeBtn);
                colDiv.appendChild(imgDiv);
                previewContainer.appendChild(colDiv);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush