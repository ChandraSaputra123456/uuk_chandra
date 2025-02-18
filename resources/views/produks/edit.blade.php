@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('produks.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- ID Produk (tidak dapat diedit) -->
                            <div class="form-group">
                                <label class="font-weight-bold">ID PRODUK</label>
                                <input type="text" class="form-control" value="{{ sprintf('%03d', $produk->id_produk) }}" disabled>
                            </div>

                            <!-- Nama Produk -->
                            <div class="form-group">
                                <label class="font-weight-bold">NAMA PRODUK</label>
                                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" placeholder="Masukkan Nama Produk">
                                @error('nama_produk')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga Produk -->
                            <div class="form-group">
                                <label class="font-weight-bold">HARGA</label>
                                <input type="text" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga', $produk->harga) }}" placeholder="Masukkan Harga">
                                @error('harga')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stok Produk -->
                            <div class="form-group">
                                <label class="font-weight-bold">STOK</label>
                                <input type="text" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok', $produk->stok) }}" placeholder="Masukkan Banyak Stok">
                                @error('stok')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Button Actions -->
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
