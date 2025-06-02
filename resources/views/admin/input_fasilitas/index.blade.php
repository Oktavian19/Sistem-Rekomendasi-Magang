@extends('layouts.app') 

@section('content')
<div class="container card p-5">
    <h4><strong>Input Fasilitas Magang</strong></h4>
    <hr>

    <div class="row mb-3">
        <div class="col">
            <h5>Fasilitas yang Sudah Ada</h5>
            <div id="fasilitas-list" class="d-flex flex-wrap gap-2">
                @foreach($fasilitas as $f)
                <div class="badge bg-light border text-dark d-flex align-items-center" data-id="{{ $f->id }}">
                    {{ $f->label }}
                    <button type="button" class="btn-close ms-2" aria-label="Close"></button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="text-primary">+ Tambah Fasilitas</span>
            <div class="mt-2 d-flex">
                <input type="text" id="fasilitas-input" class="form-control me-2" placeholder="Masukkan nama fasilitas baru">
                <button id="tambah-btn" class="btn btn-outline-primary">Tambah</button>
            </div>
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
        
        // Dapatkan pola URL dengan placeholder
        const destroyRoutePattern = "{{ route('admin.input_fasilitas.destroy_fasilitas', ['id' => '::ID::']) }}";
        
        // Fungsi untuk membuat badge
        function createBadge(id, text) {
            const badge = document.createElement('div');
            badge.className = 'badge bg-light border text-dark d-flex align-items-center';
            badge.dataset.id = id;
            badge.style.padding = '10px';
            badge.innerHTML = `
                ${text}
                <button type="button" class="btn-close ms-2" aria-label="Close"></button>
            `;
            
            badge.querySelector('button').addEventListener('click', function() {
                const url = destroyRoutePattern.replace('::ID::', id);
                
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        badge.remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            });
            
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ nama: text })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const badge = createBadge(data.fasilitas.id, data.fasilitas.nama);
                        list.appendChild(badge);
                        input.value = '';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Inisialisasi untuk fasilitas yang sudah ada
        document.querySelectorAll('#fasilitas-list .badge').forEach(badge => {
            badge.querySelector('button').addEventListener('click', function() {
                const fasilitasId = badge.dataset.id;
                const url = destroyRoutePattern.replace('::ID::', fasilitasId);
                
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        badge.remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endpush