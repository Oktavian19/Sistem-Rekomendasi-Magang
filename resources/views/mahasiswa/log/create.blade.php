<form action="{{ url('log-kegiatan/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('image-preview-container');
        const MAX_FILES = 5;
        const MAX_SIZE_MB = 2;

        imageInput.addEventListener('change', function(event) {
            const files = Array.from(event.target.files);
            previewContainer.innerHTML = ''; // Bersihkan pratinjau sebelumnya

            if (files.length > MAX_FILES) {
                alert(`Maksimal ${MAX_FILES} gambar yang dapat diunggah.`);
                imageInput.value = ''; // Reset input
                return;
            }

            const validFiles = [];

            files.forEach((file, index) => {
                if (!file.type.startsWith('image/')) {
                    alert(`File ${file.name} bukan gambar yang valid.`);
                    return;
                }

                if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                    alert(`Ukuran file ${file.name} melebihi ${MAX_SIZE_MB}MB.`);
                    return;
                }

                validFiles.push(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-4 mb-3';

                    const cardDiv = document.createElement('div');
                    cardDiv.className = 'card h-100 position-relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'card-img-top img-thumbnail';
                    img.style.maxHeight = '150px';
                    img.style.objectFit = 'cover';

                    const cardBody = document.createElement('div');
                    cardBody.className = 'card-body p-2';

                    const fileName = document.createElement('p');
                    fileName.className = 'card-text small text-truncate mb-0';
                    fileName.textContent = file.name;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className =
                        'btn btn-danger btn-sm position-absolute top-0 end-0 m-1';
                    removeBtn.innerHTML = '<i class="bi bi-x"></i>';
                    removeBtn.title = 'Hapus gambar';

                    removeBtn.addEventListener('click', function() {
                        const indexToRemove = validFiles.indexOf(file);
                        if (indexToRemove > -1) {
                            validFiles.splice(indexToRemove, 1);
                            updateFileInput(validFiles);
                            colDiv.remove();
                        }
                    });

                    cardBody.appendChild(fileName);
                    cardDiv.appendChild(img);
                    cardDiv.appendChild(cardBody);
                    cardDiv.appendChild(removeBtn);
                    colDiv.appendChild(cardDiv);
                    previewContainer.appendChild(colDiv);
                };

                reader.readAsDataURL(file);
            });

            updateFileInput(validFiles);
        });

        function updateFileInput(files) {
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            imageInput.files = dataTransfer.files;
        }
    });
</script>
