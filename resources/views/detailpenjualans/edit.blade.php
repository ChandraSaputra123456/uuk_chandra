@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Detail Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('detailpenjualans.update', $detailpenjualan->id_detail) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">ID DETAIL</label>
                                <input type="text" class="form-control" name="id_detail" value="{{ old('id_detail', $formattedIdDetail) }}" readonly>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">ID PENJUALAN</label>
                                <select class="form-control" name="id_penjualan">
                                    <option value="">-- Pilih Penjualan --</option>
                                    @foreach($penjualans as $penjualan)
                                    <option value="{{ $penjualan->id_penjualan }}" {{ $penjualan->id_penjualan == $detailpenjualan->id_penjualan ? 'selected' : '' }}>
                                        {{ $penjualan->id_penjualan }} - {{ $penjualan->pelanggan->nama_pelanggan ?? 'Nama Tidak Ditemukan' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="product-container">
                                <label class="font-weight-bold">PRODUK</label>
                                @foreach($detailpenjualan->products ?? [] as $product)
                                <div class="form-group row product-row">
                                    <div class="col-md-4">
                                        <select class="form-control product-select" name="id_produk[]">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach($produks ?? [] as $produk)
                                            <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}" data-stok="{{ $produk->stok }}"
                                                {{ $produk->id_produk == $product->id_produk ? 'selected' : '' }}>
                                                {{ $produk->id_produk }} - {{ $produk->nama_produk }} (Stok: {{ $produk->stok }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control product-quantity" name="jumlah_produk[]" min="1" step="1" value="{{ $product->jumlah_produk }}">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger" onclick="removeProductRow(this)">X</button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-success mb-3" onclick="addProductRow()">Tambah Produk</button>

                            <div class="form-group">
                                <label class="font-weight-bold">SUBTOTAL</label>
                                <input type="text" class="form-control" name="subtotal" value="{{ old('subtotal', $detailpenjualan->subtotal) }}" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">UPDATE</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">KEMBALI</a>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('change', '.product-select', updateSubtotal);
        $(document).on('input', '.product-quantity', function () {
            let jumlahInput = $(this);
            let jumlah = parseInt(jumlahInput.val()) || 0;
            let selectedProduct = jumlahInput.closest('.product-row').find('.product-select option:selected');
            let stok = parseInt(selectedProduct.data('stok')) || 0;

            if (jumlah > stok) {
                alert(`Stok tidak mencukupi! Maksimal ${stok} unit.`);
                jumlahInput.val(stok);
            }
            updateSubtotal();
        });

        function updateSubtotal() {
            let subtotal = 0;
            $('.product-row').each(function () {
                const harga = parseFloat($(this).find('.product-select option:selected').data('harga')) || 0;
                const jumlah = parseFloat($(this).find('.product-quantity').val()) || 0;
                subtotal += harga * jumlah;
            });
            $('input[name="subtotal"]').val(subtotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
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

        window.removeProductRow = function (button) {
            $(button).closest('.product-row').remove();
            updateSubtotal();
        };
    });
</script>
</body>
@endsection
