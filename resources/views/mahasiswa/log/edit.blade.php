<div id="modal-log" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="{{ url('log-kegiatan/' . $log->id_log) }}" method="POST" id="form-edit"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Log Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', $log->tanggal) }}">
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="minggu" class="form-label">Minggu Ke-</label>
                    <select name="minggu" id="minggu" class="form-select">
                        @for ($i = 1; $i <= $jumlahMinggu; $i++)
                            <option value="{{ $i }}"
                                {{ old('minggu', $log->minggu) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan"
                        class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" rows="3">{{ old('deskripsi_kegiatan', $log->deskripsi_kegiatan) }}</textarea>
                    @error('deskripsi_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Upload Gambar (Maksimal 5)</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    <div class="row image-preview-container mt-2"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form-edit');
        const imageInput = document.getElementById('images');
        const previewContainer = form.querySelector('.image-preview-container');
        let selectedFiles = [];

        function updateImagePreview() {
            previewContainer.innerHTML = '';
            const dt = new DataTransfer();
            const MAX_FILES = 5;

            if (selectedFiles.length > MAX_FILES) {
                alert(`Maksimal ${MAX_FILES} gambar yang diizinkan`);
                selectedFiles = selectedFiles.slice(0, MAX_FILES);
                imageInput.value = '';
                return;
            }

            selectedFiles.forEach((file, index) => {
                if (!file.type.match('image.*')) return;
                dt.items.add(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-4 mb-2';

                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'position-relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';
                    img.style.width = '100%';
                    img.alt = 'Preview gambar';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                    removeBtn.innerHTML = '<i class="bi bi-x"></i>';
                    removeBtn.setAttribute('aria-label', 'Hapus gambar');
                    removeBtn.dataset.index = index;

                    removeBtn.addEventListener('click', function() {
                        const container = this.closest('.col-md-4');
                        container.style.transition = 'opacity 0.3s';
                        container.style.opacity = '0';
                        setTimeout(() => {
                            selectedFiles.splice(parseInt(this.dataset.index), 1);
                            updateImagePreview();
                        }, 300);
                    });

                    imgDiv.appendChild(img);
                    imgDiv.appendChild(removeBtn);
                    colDiv.appendChild(imgDiv);
                    previewContainer.appendChild(colDiv);
                };

                reader.readAsDataURL(file);
            });

            imageInput.files = dt.files;
        }

        imageInput.addEventListener('change', function(e) {
            selectedFiles = Array.from(e.target.files);

            if (selectedFiles.length >= 5) {
                previewContainer.innerHTML = ''; // Reset preview lama (opsional)
                alert('Gambar lama akan digantikan karena Anda mengunggah 5 gambar baru.');
            }

            if (selectedFiles.length > 5) {
                alert('Maksimal 5 gambar yang diizinkan');
                selectedFiles = selectedFiles.slice(0, 5);
            }

            updateImagePreview();
        });

    });
</script>
