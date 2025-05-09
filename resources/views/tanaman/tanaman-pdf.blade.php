<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>Laporan Tanaman</title>
    <style>
        .text-center {
            text-align: center;
        }

        tr {
            text-align: center;
        }

        td {
            text-align: center;
        }

        .container {}

        .text-right {
            text-align: right;
        }

        .mb {
            margin-bottom: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>

<body>
    <h4 class="text-center">Laporan Tanaman</h4>
    <div class="text-right mb">

        <span>Tanggal : {{ date('d-M-Y') }}</span>/
        <span>Jam : {{ date('H:i') }}</span><br>
    </div>

    <div class="container">
        <table border="1" cellspacing="0" class="d-flex">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tanaman</th>
                    <th>Jenis Tanaman</th>
                    <th>Tanggal Tanam</th>
                    <th>Kondisi Tanaman</th>
                    <th>Alamat</th>
                    <th>No Hanphone</th>
                    <th>Daerah</th>
                    <th>Waktu ditambahkan</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach ($tanaman as $t)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $t->nama_tanaman }}</td>
                        <td>{{ $t->jenis_tanaman }}</td>
                        <td>{{ $t->tanggal_tanam }}</td>
                        <td>{{ $t->kondisi_tanaman }}</td>
                        <td>{{ $t->alamat }}</td>
                        <td>{{ $t->nohp }}</td>
                        <td>{{ $t->daerah }}</td>
                        <td>{{ $t->created_at->format('d F Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <span></span>
    </div>
</body>

</html>
