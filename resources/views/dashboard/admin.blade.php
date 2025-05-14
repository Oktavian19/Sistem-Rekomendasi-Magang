@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 rounded">
        <div class="row mt-4">
            <div class="col-md-5">
            <div class="box shadow">
                <div id="bar"></div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="box shadow">
                <div id="donutTop"></div>
            </div>
            </div>
            <div class="col-md-3">
            <div class="box shadow">
                <div id="radialBar1"></div>
            </div>
            </div>
        </div>

        <div class="row mt-4 mb-5">
            <div class="col-md-6">
            <div class="row sparkboxes mt-4">
                <div class="col-md-6">
                <div class="box box1">
                    <div id="spark1"></div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="box box2">
                    <div id="spark2"></div>
                </div>
                </div>
            </div>
            <div class="row sparkboxes mt-3">
                <div class="col-md-6">
                <div class="box box3">
                    <div id="spark3"></div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="box box4">
                    <div id="spark4"></div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="box body-bg">
                <div
                id="area-adwords"
                style="background: #fff"
                class="shadow"
                ></div>
            </div>
            </div>
        </div>

        <div class="row mt-4 mb-5">
            <div class="col-md-5">
            <div class="box shadow">
                <div id="radialBarBottom"></div>
            </div>
            </div>
            <div class="col-md-7">
            <div class="box shadow">
                <div id="bubbleChart"></div>
            </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{ asset('sneat/assets/js/chart.js') }}"></script>
@endpush
