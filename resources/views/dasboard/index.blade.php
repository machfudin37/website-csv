@extends('layout.app')
@extends('layout.sidebar')
@section('konten')
    <main>
        <div class="box-info">
            <li>
                <i class="fas fa-clinic-medical"></i>
                <span class="text">
                    <h3>{{ count($alldatapenyakit) }}</h3>
                    <p>Total Data Penyakit</p>
                </span>
            </li>
            <li>
                <i class="fas fa-tree"></i>
                <span class="text">
                    <h3>{{ count($alldatatanaman) }}</h3>
                    <p>Total Data Tanaman</p>
                </span>
            </li>
        </div>
        <div class="row">
            <div>
                <div class="table-data">
                    <div class="mt-4">
                        <div>
                            <h5>Grafik Jumlah Data Penyakit Per Bulan</h5>
                            <canvas id="chartpenyakit" style="width: 1190px; margin:auto; height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="table-data">
                    <div class="mt-4">
                        <div>
                            <h5>Grafik Jumlah Data Tanaman Per Bulan</h5>
                            <canvas id="charttanaman" style="width: 1190px; margin:auto; height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
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
        // Penyakit Per bulan
        var ctx = document.getElementById('chartpenyakit').getContext('2d');
        var penyakitChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelspenyakit) !!},
                datasets: {!! json_encode($datasetspenyakit) !!},
            },
        });
        // Tanaman Per bulan
        var ctx = document.getElementById('charttanaman').getContext('2d');
        var tanamanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelstanaman) !!},
                datasets: {!! json_encode($datasetstanaman) !!},
            },
        });
    </script>
@endsection
