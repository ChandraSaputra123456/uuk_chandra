<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #444;
            font-size: 28px;
            margin-top: 30px;
        }

        p {
            text-align: center;
            font-size: 16px;
            color: #777;
        }

        /* Table Styling */
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
        }

        td {
            border-top: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Border Styling for the Table */
        table, th, td {
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 14px;
            }

            th, td {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <p>Tanggal: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>ID DETAIL</th>
                <th>ID PENJUALAN (ID Pelanggan - Nama Pelanggan)</th>
                <th>ID PRODUK (Nama Produk)</th>
                <th>JUMLAH PRODUK</th>
                <th>SUBTOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detailpenjualans as $detailpenjualan)
                @php
                    // Cari data produk dan pelanggan
                    $produk = $produks->firstWhere('id_produk', $detailpenjualan->id_produk);
                    $pelanggan = $detailpenjualan->penjualan->pelanggan ?? null;
        
                    // Format ID Penjualan dan ID Produk
                    $formattedIdPenjualan = str_pad($detailpenjualan->id_penjualan, 2, '0', STR_PAD_LEFT);
                    $formattedIdProduk = str_pad($detailpenjualan->id_produk, 3, '0', STR_PAD_LEFT);
                @endphp
                <tr>
                    <!-- Format ID Detail -->
                    <td>{{ str_pad($detailpenjualan->id_detail, 4, '0', STR_PAD_LEFT) }}</td>
        
                    <!-- Format ID Penjualan -->
                    <td>
                        {{ $formattedIdPenjualan }}
                        ({{ $detailpenjualan->penjualan->id_pelanggan ?? 'Tidak Ada' }} - 
                        {{ $pelanggan->nama_pelanggan ?? 'Tidak Diketahui' }})
                    </td>
        
                    <!-- Format ID Produk -->
                    <td>{{ $formattedIdProduk }} - {{ $produk->nama_produk ?? 'Tidak Diketahui' }}</td>
        
                    <!-- Jumlah Produk -->
                    <td>{{ $detailpenjualan->jumlah_produk }}</td>
        
                    <!-- Subtotal -->
                    <td>{{ 'Rp ' . number_format(floatval($detailpenjualan->subtotal), 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
</body>
</html>
