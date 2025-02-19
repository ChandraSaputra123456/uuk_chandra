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
                                            <option value="{{ str_pad($produk->id_produk, 3, '0', STR_PAD_LEFT) }}" 
                                                    data-harga="{{ $produk->harga }}" 
                                                    data-stok="{{ $produk->stok }}">
                                                {{ str_pad($produk->id_produk, 3, '0', STR_PAD_LEFT) }} - {{ $produk->nama_produk }} (Stok: {{ $produk->stok }})
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
    updateSubtotal();
    updateStockDisplay();

    $(document).on('change', '.product-select', function () {
        updateStockDisplay();
        updateSubtotal();
    });

    $(document).on('input', '.product-quantity', function () {
        let jumlahInput = $(this);
        let jumlah = parseInt(jumlahInput.val()) || 0;
        let selectedProduct = jumlahInput.closest('.product-row').find('.product-select option:selected');
        let stok = parseInt(selectedProduct.data('stok')) || 0;
        let selectedProductId = selectedProduct.val();

        let totalUsed = calculateTotalUsed(selectedProductId);

        if (totalUsed > stok) {
            alert(`Stok tidak mencukupi! Hanya tersisa ${stok - (totalUsed - jumlah)} unit.`);
            jumlahInput.val(stok - (totalUsed - jumlah));
        }

        updateSubtotal();
        updateStockDisplay();
    });

    function calculateTotalUsed(productId) {
        let total = 0;
        $('.product-row').each(function () {
            let selectedProduct = $(this).find('.product-select option:selected').val();
            let jumlah = parseInt($(this).find('.product-quantity').val()) || 0;

            if (selectedProduct === productId) {
                total += jumlah;
            }
        });
        return total;
    }

    function updateStockDisplay() {
        let productStockMap = {};

        $('.product-select option').each(function () {
            let productId = $(this).val();
            let stok = $(this).data('stok');

            if (productId) {
                productStockMap[productId] = stok;
            }
        });

        $('.product-row').each(function () {
            let selectedProduct = $(this).find('.product-select option:selected').val();
            let jumlah = parseInt($(this).find('.product-quantity').val()) || 0;

            if (selectedProduct && productStockMap[selectedProduct] !== undefined) {
                productStockMap[selectedProduct] -= jumlah;
            }
        });

        $('.product-row').each(function () {
            let selectElement = $(this).find('.product-select');
            let stokLabel = $(this).find('.stok-label');

            let selectedProduct = selectElement.find("option:selected").val();
            let stokTersisa = productStockMap[selectedProduct] || 0;

            if (stokLabel.length) {
                stokLabel.text(`Stok tersisa: ${stokTersisa}`);
            } else {
                selectElement.closest('.product-row').append(`<small class="stok-label text-muted ml-2">Stok tersisa: ${stokTersisa}</small>`);
            }
        });
    }

    function updateSubtotal() {
        let subtotal = 0;

        $('.product-row').each(function () {
            const harga = parseFloat($(this).find('.product-select option:selected').data('harga')) || 0;
            const jumlah = parseFloat($(this).find('.product-quantity').val()) || 0;

            subtotal += harga * jumlah;
        });

        const subtotalFormatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2,
        }).format(subtotal);

        $('input[name="subtotal"]').val(subtotalFormatted);
    }

    window.addProductRow = function () {
        const rowHtml = `
            <div class="form-group row product-row">
                <div class="col-md-4">
                    <select class="form-control product-select" name="id_produk[]">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $produk)
                        <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}" data-stok="{{ $produk->stok }}">
                            {{ $produk->id_produk }} - {{ $produk->nama_produk }} (Stok: {{ $produk->stok }})
                        </option>
                        @endforeach
                    </select>
                    <small class="stok-label text-muted ml-2"></small>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control product-quantity" name="jumlah_produk[]" min="1" step="1" placeholder="Jumlah">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger" onclick="removeProductRow(this)">X</button>
                </div>
            </div>`;
        $('#product-container').append(rowHtml);
        updateStockDisplay();
    };

    window.removeProductRow = function (button) {
        $(button).closest('.product-row').remove();
        updateSubtotal();
        updateStockDisplay();
    };
});




</script>
    


</body>
@endsection
