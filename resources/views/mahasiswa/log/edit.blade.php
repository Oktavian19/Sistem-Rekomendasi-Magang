<form action="{{ route('log-kegiatan.update', $log->id) }}" method="POST" id="form-edit" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="modal-edit-log" class="modal-dialog modal-lg" role="document">
        <input type="hidden" name="id" id="edit_id" value="{{ $log->id }}">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title">Edit Log Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Date Input -->
                <div class="form-group mb-4">
                    <label>Tanggal Kegiatan</label>
                    <div class="input-group">
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control" value="{{ $log->tanggal }}" required>
                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    </div>
                    <small id="error-tanggal" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Week Selector (Optional) -->
                <div class="form-group mb-4">
                    <label>Minggu Ke- (Opsional)</label>
                    <div class="input-group">
                        <select name="minggu" id="edit_minggu" class="form-control">
                            <option value="" disabled>Pilih minggu</option>
                            @for($i = 1; $i <= $jumlahMinggu; $i++)
                                <option value="{{ $i }}" {{ $log->minggu == $i ? 'selected' : '' }}>
                                    Minggu ke-{{ $i }}
                                </option>
                            @endfor
                        </select>
                        <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                    </div>
                </div>
                
                <!-- Description Input -->
                <div class="form-group mb-4">
                    <label>Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" id="edit_deskripsi_kegiatan" class="form-control" rows="8" required>{{ $log->deskripsi_kegiatan }}</textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Existing Images -->
                <div class="form-group mb-4">
                    <label>Gambar Saat Ini</label>
                    <div class="row" id="existing-images">
                        @if($log->images && $log->images->count() > 0)
                            @foreach($log->images as $image)
                            <div class="col-md-4 mb-2">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="img-thumbnail" style="max-height: 150px;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image" data-image-id="{{ $image->id }}">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada gambar</p>
                        @endif
                    </div>
                </div>
                
                <!-- New Image Upload -->
                <div class="form-group">
                    <label for="edit_images">Upload Gambar Tambahan (Maksimal 5)</label>
                    <input type="file" name="images[]" id="edit_images" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Format: JPG, PNG (Maksimal 2MB per gambar)</small>
                    <small id="error-images" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- New Image Preview -->
                <div class="row mt-3" id="edit-image-preview-container">
                    <!-- Preview images will appear here -->
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Image preview functionality for edit form
    document.getElementById('edit_images').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('edit-image-preview-container');
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
                    const input = document.getElementById('edit_images');
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
    
    // Existing image removal
    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_image_ids[]';
            hiddenInput.value = imageId;
            document.getElementById('form-edit').appendChild(hiddenInput);
            
            this.closest('.col-md-4').remove();
        });
    });
</script>
@endpush