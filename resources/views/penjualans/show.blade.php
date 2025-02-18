@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Data Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <h3 class="text-center my-4">Show Penjualan</h3>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID PENJUALAN</th>
                                    <td>{{ $penjualan->id_penjualan }}</td>
                                </tr>
                                <tr>
                                    <th>TANGGAL PENJUALAN</th>
                                    <td>{{ $penjualan->tanggal_penjualan }}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL PENJUALAN</th>
                                    <td>{{ 'Rp ' . number_format(floatval($penjualan->total_penjualan), 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>ID PELANGGAN</th>
                                    <td>{{ $penjualan->id_pelanggan }} - {{ $penjualan->pelanggan->nama_pelanggan ?? 'Tidak Diketahui' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('penjualans.index') }}" class="btn btn-md btn-primary mt-3">KEMBALI KE TABEL PENJUALAN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection