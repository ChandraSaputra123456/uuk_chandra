@extends('layout.main')

@section('isi')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 30px;
            gap: 20px;
        }

        .card {
            background-color: #e0e0e0;
            width: 150px;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(10, 10, 10, 0.2);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .count {
            margin-top: 10px;
            font-size: 14px;
            font-weight: normal;
            color: #555;
        }

        .dashboard-image {
            display: block;
            margin: 30px auto;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(10, 10, 10, 0.2);
        }
    </style>
</head>
<body>
    <div>
        <h3 class="text-center my-4">Dashboard</h3>
        <hr>
    </div>

    <div class="container">
        <div class="card">
            Pelanggan
            <div class="count"> total : {{ DB::table('pelanggans')->count() }}</div>
        </div>
        <div class="card">
            Penjualan
            <div class="count"> total : {{ DB::table('penjualans')->count() }}</div>
        </div>
        <div class="card">
            Produk
            <div class="count"> total : {{ DB::table('produks')->count() }}</div>
        </div>
        <div class="card">
            Detail
            <div class="count"> total : {{ DB::table('detailpenjualans')->count() }}</div>
        </div>
    </div>

    <!-- Gambar di bawah container -->
    <img src="{{ asset("assets/img/user.jpg") }}" alt="Dashboard Image" class="dashboard-image">
</body>
@endsection
