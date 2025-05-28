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
                                    <h4 class="mb-0">{{ $statusLamaran['menunggu'] }}</h4>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $statusMagang['selesai'] }}</h4>
                                    <p class="mb-0">Jumlah Mahasiswa <br>Selesai Magang</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success text-heading">
                                        <i class="bx bx-check-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
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
                    </div>
                </div>
            </div>
        </div>    
    </div>
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

        {{-- Tren perusahaan 4 rating tertinggi dan total siswa magangnya --}}
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
    </div>
@endsection
@push('scripts')
{{-- <script src="{{ asset('sneat/assets/js/chart.js') }}"></script> --}}
<script>
    const tren = @json($trenBidangIndustri);
    // Ekstrak arrays untuk chart
    const labels = tren.map(item => item.nama_bidang);
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
        height: 250,
        width: '100%',
        stacked: true,
        foreColor: '#999',
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
        colors: ["#00C5A4", '#F3F2FC'],
        series: [{
        name: "Terealisasi",
        data: dataTerealisasi,
        }, {
        name: "Peminat",
        data: dataPeminat,
        }],
        labels: labels,
        xaxis: {
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
            show: false,
            style: {
            fontSize: '14px'
            }
        },
        },
        grid: {
        xaxis: {
            lines: {
            show: false
            },
        },
        yaxis: {
            lines: {
            show: false
            },
        }
        },
        yaxis: {
        axisBorder: {
            show: false
        },
        labels: {
            show: false
        },
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
    }

    var optionsDonutTop = {
        chart: {
        height: 265,
        type: 'donut',
        offsetY: 20
        },
        plotOptions: {
        pie: {
            customScale: 0.86,
            donut: {
            size: '72%',
            },
            dataLabels: {
            enabled: false
            }
        }
        },
        colors: ['#775DD0', '#00C8E1', '#FFB900'],
        title: {
        text: 'Status Lamaran'
        },
        series: [
            <?php echo (int) $statusLamaran['ditolak']; ?>,
            <?php echo (int) $statusLamaran['menunggu']; ?>,
            <?php echo (int) $statusLamaran['diterima']; ?>
        ],
        labels: ['Ditolak', 'Diproses', 'Diterima'],
        legend: {
        show: false
        }
    }

    var optionsCircle1 = {
        chart: {
        type: 'radialBar',
        height: 266,
        zoom: {
            enabled: false
        },
        offsetY: 20
        },
        colors: ['#E91E63'],
        plotOptions: {
        radialBar: {
            dataLabels: {
            name: {
                show: false
            },
            value: {
                offsetY: 0
            }
            }
        }
        },
        series: [<?php echo $persentaseMengikutiRekomendasi; ?>],
        theme: {
        monochrome: {
            enabled: false
        }
        },
        legend: {
        show: false
        },
        title: {
        text: 'Efektivitas Sistem Rekomendasi',
        align: 'left'
        }
    }

    var spark1 = {
        chart: {
        id: 'sparkline1',
        type: 'line',
        height: 140,
        sparkline: {
            enabled: true
        },
        group: 'sparklines'
        },
        series: [{
        name: 'purple',
        data: [25, 66, 41, 59]
        }],
        stroke: {
        curve: 'smooth'
        },
        markers: {
        size: 0
        },
        tooltip: {
        fixed: {
            enabled: true,
            position: 'right'
        },
        x: {
            show: false
        }
        },
        title: {
        text: '439',
        style: {
            fontSize: '26px'
        }
        },
        colors: ['#734CEA']
    }
    
    var spark2 = {
        chart: {
        id: 'sparkline2',
        type: 'line',
        height: 140,
        sparkline: {
            enabled: true
        },
        group: 'sparklines'
        },
        series: [{
        name: 'green',
        data: [12, 14, 2, 47]
        }],
        stroke: {
        curve: 'smooth'
        },
        markers: {
        size: 0
        },
        tooltip: {
        fixed: {
            enabled: true,
            position: 'right'
        },
        x: {
            show: false
        }
        },
        title: {
        text: '387',
        style: {
            fontSize: '26px'
        }
        },
        colors: ['#34bfa3']
    }
    
    var spark3 = {
        chart: {
        id: 'sparkline3',
        type: 'line',
        height: 140,
        sparkline: {
            enabled: true
        },
        group: 'sparklines'
        },
        series: [{
        name: 'red',
        data: [47, 45, 74, 32]
        }],
        stroke: {
        curve: 'smooth'
        },
        markers: {
        size: 0
        },
        tooltip: {
        fixed: {
            enabled: true,
            position: 'right'
        },
        x: {
            show: false
        }
        },
        colors: ['#f4516c'],
        title: {
        text: '577',
        style: {
            fontSize: '26px'
        }
        },
        xaxis: {
        crosshairs: {
            width: 1
        },
        }
    }
    
    var spark4 = {
        chart: {
        id: 'sparkline4',
        type: 'line',
        height: 140,
        sparkline: {
            enabled: true
        },
        group: 'sparklines'
        },
        series: [{
        name: 'teal',
        data: [15, 75, 47, 65]
        }],
        stroke: {
        curve: 'smooth'
        },
        markers: {
        size: 0
        },
        tooltip: {
        fixed: {
            enabled: true,
            position: 'right'
        },
        x: {
            show: false
        }
        },
        colors: ['#00c5dc'],
        title: {
        text: '615',
        style: {
            fontSize: '26px'
        }
        },
        xaxis: {
        crosshairs: {
            width: 1
        },
        }
    }

      var optionsArea = {
    chart: {
      height: 421,
      type: 'area',
      background: '#fff',
      stacked: true,
      offsetY: 39,
      zoom: {
        enabled: false
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: false
        }
      }
    },
    stroke: {
      curve: 'straight'
    },
    colors: ["#3F51B5", '#2196F3'],
    series: [{
        name: "Jumlah Magang",
        data: [15, 26, 20, 33, 27, 43, 17, 26, 19]
      },
      {
        name: "Jumlah Lamaran",
        data: [33, 21, 42, 19, 32, 25, 36, 29, 49]
      }
    ],
    fill: {
      type: 'gradient',
      gradient: {
        inverseColors: false,
        shade: 'light',
        type: "vertical",
        opacityFrom: 0.9,
        opacityTo: 0.6,
        stops: [0, 100, 100, 100]
      }
    },
    title: {
      text: 'Visitor Insights',
      align: 'left',
      offsetY: -5,
      offsetX: 20
    },
    subtitle: {
      text: 'Adwords Statistics',
      offsetY: 30,
      offsetX: 20
    },
    markers: {
      size: 0,
      style: 'hollow',
      strokeWidth: 8,
      strokeColor: "#fff",
      strokeOpacity: 0.25,
    },
    grid: {
      show: false,
      padding: {
        left: 0,
        right: 0
      }
    },
    yaxis: {
      show: false
    },
    labels: ['01/15/2002', '01/16/2002', '01/17/2002', '01/18/2002', '01/19/2002', '01/20/2002', '01/21/2002', '01/22/2002', '01/23/2002'],
    xaxis: {
      type: 'datetime',
      tooltip: {
        enabled: false
      }
    },
    legend: {
      offsetY: -50,
      position: 'top',
      horizontalAlign: 'right'
    }
  }
  
    new ApexCharts(document.querySelector('#bar'), optionsBar).render();
    new ApexCharts(document.querySelector('#donutTop'), optionsDonutTop).render();
    new ApexCharts(document.querySelector('#radialBar1'), optionsCircle1).render();
    new ApexCharts(document.querySelector("#spark1"), spark1).render();
    new ApexCharts(document.querySelector("#spark2"), spark2).render();
    new ApexCharts(document.querySelector("#spark3"), spark3).render();
    new ApexCharts(document.querySelector("#spark4"), spark4).render();
    new ApexCharts(document.querySelector('#area-adwords'), optionsArea).render();
</script>
@endpush
