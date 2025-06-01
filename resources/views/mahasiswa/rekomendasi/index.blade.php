@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Hasil Rekomendasi Magang (Metode CRITIC + WASPAS)</h1>

    <h3>Bobot CRITIC:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach ($kriteria as $k)
                    <th>{{ $k }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($bobot as $b)
                    <td>{{ number_format($b, 4) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <h3 class="mt-5">Ranking Perusahaan:</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nama Perusahaan</th>
                <th>Skor Q</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @foreach ($hasil as $nama => $nilai)
                <tr>
                    <td>{{ $rank++ }}</td>
                    <td>{{ $nama }}</td>
                    <td>{{ $nilai }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
