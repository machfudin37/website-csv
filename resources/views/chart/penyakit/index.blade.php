@extends('layout.app')
@extends('layout.sidebar')
@section('konten')
    <main>
        </div>
        <div class="table-data">
            <table class="mt-4">
                <div>
                    <h5>Grafik Jumlah Data Penyakit Per Bulan</h5>
                    <canvas id="chart"
                        style="width: 550px;
                margin:auto; 
                height:400px;"></canvas>
                </div>
                <div>
                    <h5>Grafik Daerah Jumlah Penyakit</h5>
                    <div id="containerdaerah"
                        style="width: 550px;
                    margin:auto; 
                    height:400px;"></div>
                </div>
                <div>
                    <h5>Grafik Jenis Penyakit Daerah Cakung</h5>
                    <div id="containerpenyakitcakung"
                        style="width: 550px;
                    margin:auto; 
                    height:400px;"></div>
                </div>
                <div>
                    <h5>Grafik Jenis Penyakit Daerah Jatinegara</h5>
                    <div id="containerpenyakitjatinegara"
                        style="width: 550px;
                    margin:auto; 
                    height:400px;"></div>
                </div>
            </table>
        </div>
        </div>
    </main>
@endsection
@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>s
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var penyakitChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: {!! json_encode($datasets) !!},
            },
        });
        //chart Daerah Jumlah Penyakit
        Highcharts.setOptions({
            chart: {
                backgroundColor: '#20242f', // Warna latar belakang gelap
            },
            title: {
                style: {
                    color: 'var(--dark)' // Warna teks judul
                }
            },
            subtitle: {
                style: {
                    color: 'var(--dark)' // Warna teks subjudul
                }
            },
            xAxis: {
                labels: {
                    style: {
                        color: 'var(--dark)' // Warna label sumbu X
                    }
                }
            },
            yAxis: {
                labels: {
                    style: {
                        color: 'var(--dark)' // Warna label sumbu Y
                    }
                }
            }
        });
        Highcharts.chart('containerdaerah', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent', // Atur latar belakang menjadi transparan
            },
            title: {
                text: '',
                align: 'left',
                style: {
                    color: 'var(--dark)' // Warna teks judul
                }
            },
            subtitle: {
                text: 'Tahun 2023',
                align: 'left',
                style: {
                    color: 'var(--dark)' // Warna teks subjudul
                }
            },
            xAxis: {
                categories: <?= $json_daerah ?>.map(item => 'Daerah Penyakit'),
                crosshair: false,
                accessibility: {
                    description: 'Daerah'
                },
                labels: {
                    style: {
                        color: 'var(--dark)' // Warna label sumbu X
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Orang',
                    style: {
                        color: 'var(--dark)'
                    }
                }
            },
            tooltip: {
                valueSuffix: ' Orang'

            },
            plotOptions: {
                column: {
                    pointPadding: 0.4,
                    borderWidth: 0
                }
            },
            series: <?= $totaldaerah ?>

        });
        // Chart Jenis Penyakit Daerah Cakung
        Highcharts.chart('containerpenyakitcakung', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent', // Atur latar belakang menjadi transparan
            },
            title: {
                text: '',
                align: 'left',
                style: {
                    color: 'var(--dark)' // Warna teks judul
                }
            },
            subtitle: {
                text: 'Tahun 2023',
                align: 'left',
                style: {
                    color: 'var(--dark)' // Warna teks subjudul
                }
            },
            xAxis: {
                categories: <?= $json_penyakitjatinegara ?>.map(item => 'Jenis Penyakit'),
                crosshair: false,
                accessibility: {
                    description: 'Daerah'
                },
                labels: {
                    style: {
                        color: 'var(--dark)' // Warna label sumbu X
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Orang',
                    style: {
                        color: 'var(--dark)'
                    }
                }
            },
            tooltip: {
                valueSuffix: ' Orang'

            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: <?= $totalpenyakitcakung ?>

        });
        // Chart Jenis Penyakit Daerah Jatinegara
        Highcharts.chart('containerpenyakitjatinegara', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent', // Atur latar belakang menjadi transparan
            },
            title: {
                text: '',
                align: 'left',
                style: {
                    color: 'var(--dark)' // Warna teks judul
                }
            },
            subtitle: {
                text: 'Tahun 2023',
                align: 'left',
                style: {
                    color: 'var(--dark)' // Warna teks subjudul
                }
            },
            xAxis: {
                categories: <?= $json_penyakitjatinegara ?>.map(item => 'Jenis Penyakit'),
                crosshair: false,
                accessibility: {
                    description: 'Daerah'
                },
                labels: {
                    style: {
                        color: 'var(--dark)' // Warna label sumbu X
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Orang',
                    style: {
                        color: 'var(--dark)'
                    }
                }
            },
            tooltip: {
                valueSuffix: ' Orang'

            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: <?= $totalpenyakitjatinegara ?>

        });
    </script>
@endsection
