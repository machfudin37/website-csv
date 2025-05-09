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
        @if ($errors->has('nama_daerah'))
            <div class="alert alert-danger">
                {{ $errors->first('nama_daerah') }}
            </div>
        @endif
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Daerah</h3>
                </div>

                <div class="row g-3 justify-content-start">
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            Tambah Data
                        </button>
                    </div>
                </div>

                <!-- Modal Tambah -->
                <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="{{ route('daerah.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama_daerah" class="col-form-label">Masukan Nama
                                            Daerah:</label>
                                        <input type="text" class="form-control" id="nama_daerah" name="nama_daerah"
                                            placeholder="Nama Daerah" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal Tambah -->
                <table class="mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Daerah</th>
                            <th>Update At</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1 @endphp
                        @foreach ($daerah as $index => $d)
                            <tr>
                                <td class="mt-2">{{ $index + $daerah->firstItem() }}</td>
                                <td>{{ $d->nama_daerah }}</td>
                                <td>{{ $d->updated_at->format('d F Y') }}</td>
                                <td>{{ $d->created_at->format('d F Y') }}</td>
                                <td><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $d->id }}">
                                        Edit
                                       </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#hapusModal{{ $d->id }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($daerah as $d)
                            <!-- Modal Edit Data -->
                            <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('daerah.update', $d->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- Input untuk mengedit data -->
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nama_daerah{{ $d->id }}" class="col-form-label">Nama
                                                        Daerah:</label>
                                                    <input type="text" id="nama_daerah{{ $d->id }}"
                                                        name="nama_daerah" class="form-control"
                                                        value="{{ $d->nama_daerah }}">
                                                </div>
                                            </div>
                                            <!-- Tambahkan input untuk kolom data lainnya yang ingin Anda edit -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal Hapus --}}
                            <div class="modal fade" id="hapusModal{{ $d->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi
                                                Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form action="{{ route('daerah.destroy', $d->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Modal Hapus --}}
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $daerah->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection
