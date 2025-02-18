@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Pelanggan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('pelanggans.update', $pelanggan->id_pelanggan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- ID PELANGGAN (Read-only) -->
                            <div class="form-group">
                                <label class="font-weight-bold">ID PELANGGAN</label>
                                <input type="text" class="form-control @error('id_pelanggan') is-invalid @enderror" name="id_pelanggan" value="{{ old('id_pelanggan', $pelanggan->id_pelanggan) }}" readonly>
                                @error('id_pelanggan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- NAMA PELANGGAN -->
                            <div class="form-group">
                                <label class="font-weight-bold">NAMA PELANGGAN</label>
                                <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" name="nama_pelanggan" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" placeholder="Masukkan Nama Pelanggan">
                                @error('nama_pelanggan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ALAMAT -->
                            <div class="form-group">
                                <label class="font-weight-bold">ALAMAT</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="5" placeholder="Masukkan Alamat">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- NOMOR TELEPON -->
                            <div class="form-group">
                                <label class="font-weight-bold">NOMOR TELEPON</label>
                                <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon', $pelanggan->nomor_telepon) }}" placeholder="Masukkan Nomor Telepon">
                                @error('nomor_telepon')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit and Reset Buttons -->
                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                            <a href="{{ url()->previous() }}" class="btn btn-md btn-secondary">KEMBALI</a>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
</body>
@endsection
