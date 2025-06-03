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
    $(document).ready(function() {
        const $imageInput = $('#images');
        const $previewContainer = $('#image-preview-container');
        const MAX_FILES = 5;
        const MAX_SIZE_MB = 2; // Maksimal 2MB per file
        const MAX_TOTAL_SIZE_MB = 10; // Maksimal 10MB total
        let validFiles = [];

        $imageInput.on('change', function(event) {
            const files = Array.from(event.target.files);
            $previewContainer.empty();
            validFiles = [];
            let totalSize = 0;

            // Validasi jumlah file
            if (files.length > MAX_FILES) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terlalu Banyak File',
                    text: `Maksimal ${MAX_FILES} file yang dapat diupload.`,
                    confirmButtonText: 'OK'
                });
                $imageInput.val('');
                return;
            }

            // Validasi ukuran file
            for (const file of files) {
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: `File ${file.name} bukan gambar.`,
                        confirmButtonText: 'OK'
                    });
                    $imageInput.val('');
                    return;
                }

                if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran File Terlalu Besar',
                        text: `File ${file.name} melebihi ${MAX_SIZE_MB}MB.`,
                        confirmButtonText: 'OK'
                    });
                    $imageInput.val('');
                    return;
                }

                totalSize += file.size;
            }

            // Validasi total ukuran
            if (totalSize > MAX_TOTAL_SIZE_MB * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Total Ukuran Terlalu Besar',
                    text: `Total ukuran file melebihi ${MAX_TOTAL_SIZE_MB}MB.`,
                    confirmButtonText: 'OK'
                });
                $imageInput.val('');
                return;
            }

            // Proses preview gambar
            files.forEach((file, index) => {
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: `File ${file.name} bukan gambar yang valid.`,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Mengerti'
                    });
                    return;
                }

                validFiles.push(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const $colDiv = $('<div>').addClass('col-md-4 mb-3');
                    const $cardDiv = $('<div>').addClass('card h-100 position-relative');
                    const $img = $('<img>', {
                        src: e.target.result,
                        class: 'card-img-top img-thumbnail',
                        css: {
                            'max-height': '150px',
                            'object-fit': 'cover'
                        }
                    });
                    const $cardBody = $('<div>').addClass('card-body p-2');
                    const $fileName = $('<p>').addClass('card-text small text-truncate mb-0').text(file.name);
                    const $removeBtn = $('<button>', {
                        type: 'button',
                        class: 'btn btn-danger btn-sm position-absolute top-0 end-0 m-1',
                        html: '<i class="bi bi-x"></i>',
                        title: 'Hapus gambar'
                    }).on('click', function() {
                        Swal.fire({
                            title: 'Hapus Gambar?',
                            text: "Anda yakin ingin menghapus gambar ini?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const indexToRemove = validFiles.indexOf(file);
                                if (indexToRemove > -1) {
                                    validFiles.splice(indexToRemove, 1);
                                    updateFileInput(validFiles);
                                    $colDiv.remove();
                                }
                            }
                        });
                    });

                    $cardBody.append($fileName);
                    $cardDiv.append($img, $cardBody, $removeBtn);
                    $colDiv.append($cardDiv);
                    $previewContainer.append($colDiv);
                };

                reader.readAsDataURL(file);
            });

            updateFileInput(validFiles);
        });

        // Validasi sebelum submit form
        $('#form-tambah').on('submit', function(e) {
            const files = $('#images')[0].files;
            let totalSize = 0;

            if (files.length > MAX_FILES) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Terlalu Banyak File',
                    text: `Maksimal ${MAX_FILES} file yang dapat diupload.`,
                    confirmButtonText: 'OK'
                });
                return;
            }

            Array.from(files).forEach(file => {
                totalSize += file.size;
            });

            if (totalSize > MAX_TOTAL_SIZE_MB * 1024 * 1024) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Total Ukuran Terlalu Besar',
                    text: `Total ukuran file melebihi ${MAX_TOTAL_SIZE_MB}MB.`,
                    confirmButtonText: 'OK'
                });
            }
        });

        function updateFileInput(files) {
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            $imageInput[0].files = dataTransfer.files;
        }
    });
</script>
