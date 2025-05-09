@extends('layout.app')
@extends('layout.sidebar')
@section('konten')
    <main>
        <!-- Tampilkan pesan sukses jika ada -->
        @if (Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif

        <!-- Tampilkan pesan kesalahan jika ada -->
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="table-data" style="height: 500px;">
            <div class="order">
                <div class="head">
                    <h3>Form Tanaman</h3>
                </div>
                <div class="row g-3 justify-content-start">
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Import CSV
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('exportpdftanaman') }}" class="btn btn-danger" target="_blank">Export PDF All</a>
                    </div>
                    <div class="dropdown col-auto">
                        <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            Filter Date
                        </button>
                        <form id="filter-form" class="dropdown-menu p-4" method="GET"
                            action="{{ route('filterdatatanaman') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="mb-3">
                                <label for "end_date" class="form-label">End Date:</label>
                                <input type="date" class="form-control" name="end_date">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="dropdown col-auto">
                        <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            Export PDF Date
                        </button>
                        <form id="filter-form" class="dropdown-menu p-4" method="GET"
                            action="{{ route('exportpdfdatetanaman') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="mb-3">
                                <label for "end_date" class="form-label">End Date:</label>
                                <input type="date" class="form-control" name="end_date">
                            </div>
                            <button type="submit" class="btn btn-primary">Export</button>
                        </form>
                    </div>
                    <div class="dropdown col-auto">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            Filter Search
                        </button>
                        <form class="dropdown-menu p-4" method="GET" action="{{ route('filterdatatanaman') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="search" class="form-label">Search :</label>
                                <input type="search" class="form-control" name="filtersearch" placeholder="Search...">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="dropdown col-auto">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            Export PDF Search
                        </button>
                        <form class="dropdown-menu p-4" method="GET" action="{{ route('exportpdfsearchtanaman') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="search" class="form-label">Search :</label>
                                <input type="search" class="form-control" name="filtersearch" placeholder="Search...">
                            </div>
                            <button type="submit" class="btn btn-primary">Export</button>
                        </form>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Isi Form</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('importcsvtanaman') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="daerah">Pilih Daerah &emsp;&emsp;:</label>
                                            <select name="daerah" id="daerah"required>
                                                <option value="" disabled selected>Pilih</option>
                                                @foreach ($daerah as $d)
                                                    <option value="{{ $d->nama_daerah }}">{{ $d->nama_daerah }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="fom-group mt-2">
                                            <label for="file">Masukkan File
                                                &emsp;:</label>
                                            <input type="file" name="file" accept=".csv" required>
                                            <div id="warning" class="form-text">* pastikan file yang dimasukan .csv.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
                    <div id="data-table">
                        <table class="mt-4">
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
                                @foreach ($tanaman as $index => $t)
                                    <tr>
                                        <td>{{ $index + $tanaman->firstItem() }}</td>
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
                        <div class="mt-2">
                            {{ $tanaman->links() }}
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
