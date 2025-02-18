@extends('layout.main')

@section('isi')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Data Pelanggan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <h3 class="text-center my-4">Show Pelanggan</h3>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID PELANGGAN</th>
                                    <td>{{ $pelanggan->id_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <th>NAMA PELANGGAN</th>
                                    <td>{{ $pelanggan->nama_pelanggan }}</td>
                                </tr>
                                <tr>
                                    <th>ALAMAT</th>
                                    <td>{{ $pelanggan->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>NOMOR TELEPON</th>
                                    <td>{{ $pelanggan->nomor_telepon }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('pelanggans.index') }}" class="btn btn-md btn-primary mt-3">KEMBALI KE TABEL PELANGGAN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@endsection
