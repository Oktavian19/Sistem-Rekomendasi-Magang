
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Beri Feedback - {{ $magang->lamaran->lowongan->nama_posisi }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('feedback/store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_magang" value="{{ $magang->id_magang }}">
                    <div class="mb-2">
                        <label class="form-label">Komentar</label>
                        <textarea name="komentar" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim Feedback</button>
                </div>
            </form>
        </div>
    </div>

