@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Data Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <h3 class="text-center my-4">Show Produk</h3>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                
                                <tr>
                                    <th>ID PRODUK</th>
                                    <td>{{ $produk->id_produk }}</td>
                                </tr>
                                <tr>
                                    <th>NAMA PRODUK</th>
                                    <td>{{ $produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th>HARGA</th>
                                    <td>{{ $produk->harga }}</td>
                                </tr>
                                <tr>
                                    <th>STOK</th>
                                    <td>{{ $produk->stok }}</td>
                                </tr>
                                
                            </tbody>
                        </table>

                        <a href="{{ route('produks.index') }}" class="btn btn-md btn-primary mt-3">KEMBALI KE TABEL PRODUK</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@endsection