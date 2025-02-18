@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div>
                <h3 class="text-center my-4">Tambah Data Penjualan</h3>
                <hr>
            </div>
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('penjualans.store') }}" method="POST">
                        @csrf

                        <!-- ID PENJUALAN -->
                        <div class="form-group">
                            <label class="font-weight-bold">ID PENJUALAN</label>
                            <input type="text" class="form-control @error('id_penjualan') is-invalid @enderror" name="id_penjualan" value="{{ old('id_penjualan', sprintf('%02d', $nextIdPenjualan)) }}" readonly>
                            @error('id_penjualan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TANGGAL PENJUALAN -->
                        <div class="form-group">
                            <label class="font-weight-bold">TANGGAL PENJUALAN</label>
                            <input type="date" class="form-control @error('tanggal_penjualan') is-invalid @enderror" name="tanggal_penjualan" value="{{ old('tanggal_penjualan') }}">
                            @error('tanggal_penjualan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TOTAL HARGA -->
                        <div class="form-group">
                            <label class="font-weight-bold">TOTAL HARGA</label>
                            <input type="text" class="form-control @error('total_harga') is-invalid @enderror" name="total_harga" value="{{ old('total_harga', '0,00') }}" placeholder="Masukkan Total Harga">
                            @error('total_harga')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PELANGGAN -->
                        <div class="form-group">
                            <label class="font-weight-bold">PELANGGAN</label>
                            <select class="form-control @error('id_pelanggan') is-invalid @enderror" name="id_pelanggan">
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id_pelanggan }}" {{ old('id_pelanggan') == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                                        {{ $pelanggan->id_pelanggan }} - {{ $pelanggan->nama_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_pelanggan')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                        <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        <a href="{{ route('penjualans.index') }}" class="btn btn-md btn-secondary">KEMBALI</a>
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
    CKEDITOR.replace( 'content' );
</script>
</body>
@endsection
