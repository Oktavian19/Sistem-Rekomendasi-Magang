@extends('layouts.app') 

@section('content')
<div class="container card p-5">
    <h4><strong>Input Bidang Keahlian</strong></h4>
    <hr>

    <div class="row mb-3">
        <div class="col">
            <h5>Bidang Keahlian yang Sudah Ada</h5>
            <div id="keahlian-list" class="d-flex flex-wrap gap-2">
                <!-- Kotak bidang keahlian akan muncul di sini -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <span class="text-primary">+ Tambah Bidang Keahlian</span>
            <div class="mt-2 d-flex">
                <input type="text" id="keahlian-input" class="form-control me-2" placeholder="Masukkan nama bidang keahlian baru">
                <button id="tambah-btn-keahlian" class="btn btn-outline-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tambahBtn = document.getElementById('tambah-btn-keahlian');
        const input = document.getElementById('keahlian-input');
        const list = document.getElementById('keahlian-list');

        tambahBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const text = input.value.trim();
            if (text !== '') {
                const badge = document.createElement('div');
                badge.className = 'badge bg-light border text-dark d-flex align-items-center';
                badge.style.padding = '10px';
                badge.innerHTML = `
                    ${text}
                    <button type="button" class="btn-close ms-2" aria-label="Close"></button>
                `;

                badge.querySelector('button').addEventListener('click', function () {
                    badge.remove();
                });

                list.appendChild(badge);
                input.value = '';
            }
        });
    });
</script>
@endpush
