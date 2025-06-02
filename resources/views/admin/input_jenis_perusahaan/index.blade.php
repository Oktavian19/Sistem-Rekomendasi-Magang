@extends('layouts.app')

@section('content')
<div class="container card p-5">
    <h4>Input Jenis Perusahaan</h4>
    <hr>

    <div class="row mb-3">
        <div class="col">
            <h5>Jenis Perusahaan yang Sudah Ada</h5>
            <div id="jenis-list" class="d-flex flex-wrap gap-2">
                @foreach($jenisPerusahaan as $item)
                <div class="badge bg-light border text-dark d-flex align-items-center" data-id="{{ $item->id }}">
                    {{ $item->label }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="text-primary">+ Tambah Jenis Perusahaan</span>
            <div class="mt-2 d-flex">
                <input type="text" id="jenis-input" class="form-control me-4" placeholder="Masukkan jenis perusahaan baru">
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
        const input = document.getElementById('jenis-input');
        const list = document.getElementById('jenis-list');
        
        // Fungsi untuk membuat badge
        function createBadge(id, text) {
            const badge = document.createElement('div');
            badge.className = 'badge bg-light border text-dark d-flex align-items-center';
            badge.dataset.id = id;
            badge.style.padding = '10px';
            badge.textContent = text;
            
            return badge;
        }

        // Event tambah jenis perusahaan
        tambahBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const text = input.value.trim();
            
            if (text !== '') {
                fetch("{{ route('admin.input_jenis_perusahaan.store_jenis_perusahaan') }}", {
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
                        const badge = createBadge(data.jenis.id, data.jenis.nama);
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
                alert('Jenis perusahaan harus diisi');
            }
        });
    });
</script>
@endpush