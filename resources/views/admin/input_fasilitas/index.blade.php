@extends('layouts.app') 

@section('content')
<div class="container card p-5">
    <h4>Input Fasilitas Magang</h4>
    <hr>

    <div class="row mb-3">
        <div class="col">
            <h5>Fasilitas yang Sudah Ada</h5>
            <div id="fasilitas-list" class="d-flex flex-wrap gap-2">
                @foreach($fasilitas as $item)
                <div class="badge bg-light border text-dark d-flex align-items-center" data-id="{{ $item->id }}">
                    {{ $item->label }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="text-primary">+ Tambah Fasilitas</span>
            <div class="mt-2 d-flex">
                <input type="text" id="fasilitas-input" class="form-control me-4" placeholder="Masukkan nama fasilitas baru">
                <button id="tambah-btn" class="btn btn-outline-primary">Tambah</button>
            </div>
            <small class="text-muted">Kode akan otomatis dibuat dari nama fasilitas</small>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tambahBtn = document.getElementById('tambah-btn');
        const input = document.getElementById('fasilitas-input');
        const list = document.getElementById('fasilitas-list');
        
        // Fungsi untuk membuat badge
        function createBadge(id, text, kode) {
            const badge = document.createElement('div');
            badge.className = 'badge bg-light border text-dark d-flex align-items-center';
            badge.dataset.id = id;
            badge.style.padding = '10px';
            badge.innerHTML = `${text}`;
            
            return badge;
        }

        // Event tambah fasilitas
        tambahBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const text = input.value.trim();
            
            if (text !== '') {
                fetch("{{ route('admin.input_fasilitas.store_fasilitas') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        nama: text 
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const badge = createBadge(data.fasilitas.id, data.fasilitas.nama, data.fasilitas.kode);
                        list.appendChild(badge);
                        input.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.errors) {
                        alert('Error: ' + Object.values(error.errors).join('\n'));
                    } else {
                        alert('An error occurred: ' + (error.message || 'Unknown error'));
                    }
                });
            } else {
                alert('Nama fasilitas harus diisi');
            }
        });
    });
</script>
@endpush