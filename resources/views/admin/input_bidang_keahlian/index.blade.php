@extends('layouts.app') 

@section('content')
<div class="container card p-5">
    <h4>Input Bidang Keahlian</h4>
    <hr>

    <div class="row mb-3">
        <div class="col">
            <h5>Bidang Keahlian yang Sudah Ada</h5>
            <div id="keahlian-list" class="d-flex flex-wrap gap-2">
                @foreach($bidangKeahlian as $item)
                <div class="badge bg-light border text-dark d-flex align-items-center" data-id="{{ $item->id }}">
                    {{ $item->label }}
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
    
        
        // Fungsi untuk membuat badge
        function createBadge(id, text) {
            const badge = document.createElement('div');
            badge.className = 'badge bg-light border text-dark d-flex align-items-center';
            badge.dataset.id = id;
            badge.style.padding = '10px';
            badge.innerHTML = text; // Tanpa tambahan button
            
            return badge;
        }

        // Event tambah fasilitas
        tambahBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const kodee = inputkode.value.trim();
            const text = input.value.trim();
            
            if (text !== '' && kodee !== '') {
                fetch("{{ route('admin.input_bidang_keahlian.store_bidang_keahlian') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        kode: kodee, 
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
                        const badge = createBadge(data.fasilitas.id, data.fasilitas.nama);
                        list.appendChild(badge);
                        input.value = '';
                        inputkode.value = '';
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
                alert('Both code and name fields are required');
            }
        });
    });
</script>
@endpush
