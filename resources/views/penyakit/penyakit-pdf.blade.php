<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>Laporan Penyakit</title>
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
    <h4 class="text-center">Laporan Penyakit</h4>
    <div class="text-right mb">

        <span>Tanggal : {{ date('d-M-Y') }}</span>/
        <span>Jam : {{ date('H:i') }}</span><br>
    </div>

    <div class="container">
        <table border="1" cellspacing="0" class="d-flex">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nik</th>
                    <th>Tanggal Lahir</th>
                    <th>No Hanphone</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Jenis Penyakit</th>
                    <th>Tanggal Berobat</th>
                    <th>Daerah</th>
                    <th>Waktu ditambahkan</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach ($penyakit as $p)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $p->nama_pasien }}</td>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->tanggal_lahir }}</td>
                        <td>{{ $p->nohp }}</td>
                        <td>{{ $p->jenis_kelamin }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->jenis_penyakit }}</td>
                        <td>{{ $p->tanggal_berobat }}</td>
                        <td>{{ $p->daerah }}</td>
                        <td>{{ $p->created_at->format('d F Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <span></span>
    </div>
</body>

</html>
