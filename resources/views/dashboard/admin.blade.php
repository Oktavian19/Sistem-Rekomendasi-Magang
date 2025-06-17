@extends('layouts.app')

@section('content')
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $statusLamaran['diprosesAdmin'] + $statusLamaran['diprosesPerusahaan'] }}</h4>
                                    <p class="mb-0">Jumlah Lamaran<br> Diproses</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-danger text-heading">
                                        <i class="bx bx-x-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $statusMagang['aktif'] }}</h4>
                                    <p class="mb-0">Jumlah Mahasiswa<br> Magang</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary text-heading">
                                        <i class="bx bx-file bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">{{ $statusMagang['selesai'] }}</h4>
                                    <p class="mb-0">Jumlah Mahasiswa <br>Selesai Magang</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-success text-heading">
                                        <i class="bx bx-check-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">1 : {{ $rasioDosenMahasiswa }}</h4>
                                    <p class="mb-0">Rasio Dosen :<br> Mahasiswa Magang</p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-warning text-heading">
                                        <i class="bx bx-loader-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="btn-group ms-auto">
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-export"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.export.lamaran-diproses') }}">Lamaran Diproses</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.export.mahasiswa-magang-aktif') }}">Mahasiswa Magang Aktif</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.export.mahasiswa-selesai-magang') }}">Mahasiswa Selesai Magang</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.export.rasio-dosen-mahasiswa') }}">Rasio Dosen:Mahasiswa</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded" style="height: 55vh">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container position-relative pb-4">
                    <button id="exportExcelBtn" class="btn btn-sm btn-outline-secondary position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                      <i class="bx bx-export"></i>
                    </button>
                    <div id="chart"></div>
                </div>
                <div id="bar"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mt-3">
            <div class="box shadow bg-white rounded p-2 position-relative" style="height: 45vh">
                <button id="exportDonutExcelBtn" class="btn btn-sm btn-outline-secondary position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <i class="bx bx-export"></i>
                </button>
                <div id="donutTop"></div> <!-- mt-4 biar donut-nya gak ketimpa tombol -->
            </div>
        </div>
        
        <div class="col-md-5 mt-3">
            <div class="box shadow bg-white rounded p-2 position-relative" style="height: 45vh">
                <button id="exportRadialExcelBtn" class="btn btn-sm btn-outline-secondary position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                    <i class="bx bx-export"></i>
                </button>
                <div id="radialBar1"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- <script src="{{ asset('sneat/assets/js/chart.js') }}"></script> --}}
<script>
    const tren = @json($trenBidangIndustri);
    const labels = tren.map(item => item.label);
    const dataPeminat = tren.map(item => item.total_peminat);
    const dataTerealisasi = tren.map(item => item.total_magang);

    window.Apex = {
        dataLabels: {
            enabled: false
        }
    };

    var optionsBar = {
        chart: {
            type: 'bar',
            height: 300,
            width: '100%',
            stacked: true,
            foreColor: '#999',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: false
                },
                columnWidth: '75%',
                borderRadius: 7
            }
        },
        colors: ["#00C5A4", '#E7E6EF'],
        series: [
            { name: "Terealisasi", data: dataTerealisasi },
            { name: "Peminat", data: dataPeminat }
        ],
        labels: labels,
        xaxis: {
            categories: labels, // pastikan ini ada (opsional, tapi baik untuk eksplisit)
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                show: false
            },
            labels: {
                show: true, // <--- ubah ini ke true
                rotate: -70, // opsional: rotasi agar tidak saling tumpang tindih
                style: {
                    fontSize: '12px'
                }
            }
        },

        grid: {
            xaxis: { lines: { show: false } },
            yaxis: { lines: { show: false } }
        },
        yaxis: {
            axisBorder: { show: false },
            labels: { show: false }
        },
        legend: {
            floating: true,
            position: 'top',
            horizontalAlign: 'right',
            offsetY: -36
        },
        title: {
            text: 'Peminatan Bidang',
            align: 'left',
        },
        subtitle: {
            text: 'Peminatan Mahasiswa Bidang Tertentu'
        },
        tooltip: {
            shared: true,
            intersect: false
        }
    };

    var optionsDonutTop = {
        chart: {
            height: 265,
            type: 'donut',
            offsetY: 20
        },
        plotOptions: {
            pie: {
                customScale: 0.86,
                donut: { size: '72%' },
                dataLabels: { enabled: false }
            }
        },
        colors: ['#E91E63', '#775DD0', '#00C8E1', '#FFB900'],
        title: {
            text: 'Status Lamaran'
        },
        series: [
            <?php echo (int) $statusLamaran['ditolak']; ?>,
            <?php echo (int) $statusLamaran['diprosesAdmin']; ?>,
            <?php echo (int) $statusLamaran['diprosesPerusahaan']; ?>,
            <?php echo (int) $statusLamaran['diterima']; ?>
        ],
        labels: ['Ditolak', 'Diproses Admin', 'Diproses Perusahaan', 'Diterima'],
        legend: {
            show: true,
            position: 'bottom',
            formatter: function(seriesName, opts) {
                return seriesName + ': ' + opts.w.globals.series[opts.seriesIndex];
            }
        }
    };

    var optionsCircle1 = {
        chart: {
            type: 'radialBar',
            height: 266,
            zoom: { enabled: false },
            offsetY: 20
        },
        colors: ['#E91E63'],
        plotOptions: {
            radialBar: {
                track: {
                    background: '#E7E6EF', 
                    strokeWidth: '100%',  
                },
                dataLabels: {
                    name: { show: false },
                    value: { offsetY: 0 }
                }
            }
        },
        series: [<?php echo $persentaseMengikutiRekomendasi; ?>],
        theme: {
            monochrome: { enabled: false }
        },
        legend: { show: false },
        title: {
            text: 'Efektivitas Sistem Rekomendasi',
            align: 'left'
        }
    };

    new ApexCharts(document.querySelector('#bar'), optionsBar).render();
    new ApexCharts(document.querySelector('#donutTop'), optionsDonutTop).render();
    new ApexCharts(document.querySelector('#radialBar1'), optionsCircle1).render();

    document.getElementById('exportExcelBtn').addEventListener('click', function() {
        // Prepare the data from your chart
        const chartData = {
            labels: optionsBar.labels,
            series: optionsBar.series
        };
        
        // Convert to worksheet
        const wsData = [
            ['Bidang', ...chartData.series.map(s => s.name)] // Header row
        ];
        
        // Add data rows
        chartData.labels.forEach((label, index) => {
            const row = [label];
            chartData.series.forEach(series => {
                row.push(series.data[index]);
            });
            wsData.push(row);
        });
        
        const ws = XLSX.utils.aoa_to_sheet(wsData);
        
        // Create workbook
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Peminatan Bidang");
        
        // Export the file
        XLSX.writeFile(wb, 'peminatan_bidang.xlsx');
    });

    document.getElementById('exportDonutExcelBtn').addEventListener('click', function() {
        // Get the active segment in the chart (if any)
        const activeSegment = document.querySelector('.apexcharts-pie-area.active');
        let status = null;
        
        if (activeSegment) {
            const segmentTitle = activeSegment.getAttribute('data:realIndex');
            // Map the index to status value
            const statusMap = {0: 'ditolak', 1: 'menunggu', 2: 'diterima'};
            status = statusMap[segmentTitle];
        }
        
        // Build the export URL
        let exportUrl = '{{ route("dashboard.export.status") }}';
        if (status) {
            exportUrl += `?status=${status}`;
        }
        
        // Trigger the download
        window.location.href = exportUrl;
    });

    // For radial bar chart export (lamaran rekomendasi)
    document.getElementById('exportRadialExcelBtn').addEventListener('click', function() {
        window.location.href = '{{ route("dashboard.export.rekomendasi") }}';
    });



</script>
@endpush
