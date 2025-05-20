<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title fw-bolder w-100 text-center">Edit Dokumen</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="formEditDocument" method="POST" action="{{ url('profile/dokumen', $dokumen->id_dokumen) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required form-label">Jenis Dokumen</label>
                            <select class="form-select form-select-sm" name="jenis_dokumen" required>
                                <option value="">Pilih Jenis Dokumen</option>
                                @php
                                    $jenis = [
                                        'Curriculum Vitae (CV)',
                                        'Ijazah',
                                        'Transkrip Nilai',
                                        'Sertifikat',
                                        'KTP',
                                        'NPWP',
                                        'SIM',
                                        'Lainnya'
                                    ];
                                @endphp
                                @foreach ($jenis as $item)
                                    <option value="{{ $item }}" {{ $dokumen->jenis_dokumen == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">File Dokumen (opsional)</label>
                            <input type="file" class="form-control form-control-sm" name="path_file" accept=".pdf">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah. Format: PDF (Max 5MB)</small>
                            @if ($dokumen->path_file)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File Saat Ini</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batalkan</button>
            <button type="submit" class="btn btn-warning" form="formEditDocument">Perbarui</button>
        </div>
    </div>
</div>
