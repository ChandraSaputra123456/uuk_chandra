@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Detail Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <!-- Form HTML -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Script Anda di sini
    </script>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('detailpenjualans.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">ID DETAIL</label>
                                <input type="text" class="form-control @error('id_detail') is-invalid @enderror" name="id_detail" value="{{ $nextIdDetail }}" placeholder="ID Detail" readonly>

                                @error('id_detail')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            

                            <div class="form-group">
                                <label class="font-weight-bold">ID PENJUALAN</label>
                                <select class="form-control @error('id_penjualan') is-invalid @enderror" name="id_penjualan">
                                    <option value="">-- Pilih Penjualan --</option>
                                    @foreach($penjualans as $index => $penjualan)
                                    <option value="{{ str_pad($penjualan->id_penjualan, 2, '0', STR_PAD_LEFT) }}">
                                        {{ str_pad($penjualan->id_penjualan, 2, '0', STR_PAD_LEFT) }} - 
                                        {{ $index + 1 }} -  <!-- Menampilkan ID Pelanggan sebagai angka urut -->
                                        {{ $penjualan->pelanggan->nama_pelanggan ?? 'Nama Tidak Ditemukan' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_penjualan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            

                            <div id="product-container">
                                <label class="font-weight-bold">ID PRODUK</label>
                                <div class="form-group row product-row">
                                    <div class="col-md-4">
                                        <select class="form-control product-select" name="id_produk[]">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach($produks as $produk)
                                            <option value="{{ str_pad($produk->id_produk, 3, '0', STR_PAD_LEFT) }}" data-harga="{{ $produk->harga }}">
                                                {{ str_pad($produk->id_produk, 3, '0', STR_PAD_LEFT) }} - {{ $produk->nama_produk }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control product-quantity" name="jumlah_produk[]" min="1" step="1" placeholder="Jumlah">
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger" onclick="removeProductRow(this)">X</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success mb-3" onclick="addProductRow()">Tambah Produk</button>
                            

                            <div class="form-group">
                                <label class="font-weight-bold">SUBTOTAL</label>
                                <input type="text" class="form-control @error('subtotal') is-invalid @enderror" name="subtotal" value="{{ old('subtotal') }}" placeholder="Subtotal" readonly>
                                @error('subtotal')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
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
<script>

$(document).ready(function () {
    // Event ketika dropdown produk berubah
    $(document).on('change', '.product-select', function () {
        updateSubtotal();
    });

    // Event ketika jumlah produk berubah
    $(document).on('input', '.product-quantity', function () {
        updateSubtotal();
    });

    // Fungsi untuk menghitung subtotal total
    function updateSubtotal() {
        let subtotal = 0;

        // Iterasi melalui semua baris produk
        $('.product-row').each(function () {
            const harga = parseFloat($(this).find('.product-select option:selected').data('harga')) || 0;
            const jumlah = parseFloat($(this).find('.product-quantity').val()) || 0;

            subtotal += harga * jumlah;
        });

        // Format subtotal menjadi format mata uang
        const subtotalFormatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2,
        }).format(subtotal);

        // Set nilai subtotal ke input utama
        $('input[name="subtotal"]').val(subtotalFormatted);
    }

    // Fungsi untuk menambah baris produk
    window.addProductRow = function () {
        const rowHtml = `
            <div class="form-group row product-row">
                <div class="col-md-4">
                    <select class="form-control product-select" name="id_produk[]">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $produk)
                        <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}">
                            {{ $produk->id_produk }} - {{ $produk->nama_produk }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control product-quantity" name="jumlah_produk[]" min="1" step="1" placeholder="Jumlah">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger" onclick="removeProductRow(this)">X</button>
                </div>
            </div>`;
        $('#product-container').append(rowHtml);
    };

    // Fungsi untuk menghapus baris produk
    window.removeProductRow = function (button) {
        $(button).closest('.product-row').remove();
        updateSubtotal();
    };
});



</script>


</body>
@endsection
