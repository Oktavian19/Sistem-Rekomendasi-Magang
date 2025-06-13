<div class="row">
    <div class="col-12">
        <h5>Feedback</h5>
        @if ($magang->feedback->count() > 0)
        @foreach ($magang->feedback as $komen)
            <div class="card card-body bg-light">
                {!! nl2br(e($komen->komentar)) !!}
            </div>
            <br>
        @endforeach
        @else
        <div class="card card-body bg-light">
            Mahasiswa Belum Memberikan Feedback Magang.
        </div>
        @endif
    </div>
</div>