<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Beri Feedback</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="{{ url('logs/' . $log->id_log . '/feedback') }}" method="POST" id="form-feedback">
        @csrf
        <div class="modal-body">
            <!-- Komentar Input -->
            <div class="form-group mb-4">
                <label for="komentar" class="form-label">Komentar</label>
                <textarea name="komentar" id="komentar" class="form-control" rows="5" required></textarea>
                <small id="error-komentar" class="error-text form-text text-danger"></small>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Kirim Feedback</button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        // Validasi form sebelum submit
        document.getElementById('form-feedback').addEventListener('submit', function(e) {
            let isValid = true;

            // Validasi komentar
            const komentar = document.getElementById('komentar').value.trim();
            if (komentar === '') {
                document.getElementById('error-komentar').textContent = 'Komentar wajib diisi';
                isValid = false;
            } else {
                document.getElementById('error-komentar').textContent = '';
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
@endpush
