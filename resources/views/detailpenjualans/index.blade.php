@extends('layout.main')

@section('isi')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Tabel Detail Penjualan</h3>          
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('detailpenjualans.create') }}" class="btn btn-md btn-success mb-3">TAMBAH DETAIL PENJUALAN</a>
                        <a href="{{ route('generate-PDF') }}" class="btn btn-md btn-danger mb-3"><i class="fas fa-file-pdf"></i> PRINT</a>
                        
                        <!-- Search Input -->
                        <div class="d-flex justify-content-end mb-3">
                            <input type="text" id="searchInput" class="form-control w-25" placeholder="&#128269; Cari...">
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID DETAIL</th>
                                        <th scope="col">ID PENJUALAN (ID Pelanggan - Nama Pelanggan)</th>
                                        <th scope="col">ID PRODUK (Nama Produk)</th>
                                        <th scope="col">JUMLAH PRODUK</th>
                                        <th scope="col">SUBTOTAL</th>
                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sortedDetailPenjualans = $detailpenjualans->sortBy('id_detail');
                                    @endphp
                                    @forelse ($detailpenjualans as $detailpenjualan)
                                        @php
                                            // Cari nama produk berdasarkan id_produk
                                            $produk = $produks->firstWhere('id_produk', $detailpenjualan->id_produk);
                                        @endphp
                                        <tr>
                                            <td>{{ str_pad($detailpenjualan->id_detail, 4, '0', STR_PAD_LEFT) }}</td>
                                            
                                            <td>
                                                {{ $detailpenjualan->id_penjualan }} 
                                                ({{ $detailpenjualan->penjualan->id_pelanggan ?? 'Tidak Ada' }} - 
                                                {{ $detailpenjualan->penjualan->pelanggan->nama_pelanggan ?? 'Tidak Diketahui' }})
                                            </td>
                                            <td>{{ $detailpenjualan->id_produk }} - {{ $detailpenjualan->produk->nama_produk ?? 'Tidak Diketahui' }}</td>
                                            <td>{{ $detailpenjualan->jumlah_produk }}</td>
                                            <td>{{ 'Rp ' . number_format(floatval($detailpenjualan->subtotal), 2, ',', '.') }}</td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('detailpenjualans.destroy', $detailpenjualan->id_detail) }}" method="POST">
                                                    <a href="{{ route('detailpenjualans.show', $detailpenjualan->id_detail) }}" class="btn btn-sm btn-dark">SHOW</a>
                                                    <a href="{{ route('detailpenjualans.edit', $detailpenjualan->id_detail) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-danger">Data Detail Penjualan belum Tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>  
                            
                        </div>

                        <!-- Pagination -->
                        @if ($detailpenjualans->hasPages())
                            <nav>
                                <ul class="pagination justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if ($detailpenjualans->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $detailpenjualans->previousPageUrl() }}" rel="prev">Sebelumnya</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($detailpenjualans->links()->elements[0] as $page => $url)
                                        @if ($page == $detailpenjualans->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($detailpenjualans->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $detailpenjualans->nextPageUrl() }}" rel="next">Berikutnya</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Berikutnya</span></li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live Search Feature
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#dataTable tbody tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endsection
