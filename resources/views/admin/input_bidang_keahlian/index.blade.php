@extends('layouts.app') 

@section('content')
<div class="container card p-5">
    <h4><strong>Input Bidang Keahlian</strong></h4>
    <hr>

    <div class="row mb-3">
        <div class="col">
            <h5>Bidang Keahlian yang Sudah Ada</h5>
            <div id="keahlian-list" class="d-flex flex-wrap gap-2">
                @foreach($bidangKeahlian as $item)
                <div class="badge bg-light border text-dark d-flex align-items-center" data-id="{{ $item->id }}">
                    {{ $item->label }}
                    <button type="button" class="btn-close ms-2" aria-label="Close"></button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="text-primary">+ Tambah Bidang Keahlian</span>
            <div class="mt-2 d-flex">
                <input type="text" id="kode-input" class="form-control me-4" placeholder="Masukkan kode bidang keahlian baru">
                <input type="text" id="keahlian-input" class="form-control me-4" placeholder="Masukkan nama bidang keahlian baru">
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
        const inputkode = document.getElementById('kode-input');
        const input = document.getElementById('keahlian-input');
        const list = document.getElementById('keahlian-list');
        
        // Dapatkan pola URL dengan placeholder
        const destroyRoutePattern = "{{ route('admin.input_bidang_keahlian.destroy_bidang_keahlian', ['id' => '::ID::']) }}";
        
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
            const kodee = inputkode.value.trim();
            const text = input.value.trim();
            
            if (text !== '') {
                fetch("{{ route('admin.input_bidang_keahlian.store_bidang_keahlian') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ label: text, kode = kodee })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const badge = createBadge(data.keahlian.id, data.keahlian.label);
                        list.appendChild(badge);
                        input.value = '';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Inisialisasi untuk keahliam yang sudah ada
        document.querySelectorAll('#keahlian-list .badge').forEach(badge => {
            badge.querySelector('button').addEventListener('click', function() {
                const keahlianId = badge.dataset.id;
                const url = destroyRoutePattern.replace('::ID::', keahlianId);
                
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
