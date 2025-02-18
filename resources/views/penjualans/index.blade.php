@extends('layout.main')

@section('isi')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Tabel Penjualan</h3>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('penjualans.create') }}" class="btn btn-md btn-success mb-3">TAMBAH PENJUALAN</a>
                        <a href="{{ route('generate-Second-PDF') }}" class="btn btn-md btn-warning mb-3"><i class="fas fa-file-pdf"></i>PRINT</a>
                       
                        <div class="d-flex justify-content-end mb-3">
                            <input type="text" id="searchInput" class="form-control w-25" placeholder="&#128269; Cari...">
                        </div>
                        
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                              <tr>
                                <th scope="col">ID PENJUALAN</th>
                                <th scope="col">TANGGAL PENJUALAN</th>
                                <th scope="col">TOTAL HARGA</th>
                                <th scope="col">ID PELANGGAN</th>
                                <th scope="col">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sortedPenjualan = $penjualans->sortBy('id_penjualan');
                                @endphp
                                @forelse ($sortedPenjualan as $penjualan)
                                    <tr>
                                        <td>{{ sprintf('%02d', (int)$penjualan->id_penjualan) }}</td> <!-- Format ID menjadi dua digit -->
                                        <td>{{ $penjualan->tanggal_penjualan }}</td>
                                        <td>{{ 'Rp ' . number_format(floatval($penjualan->total_harga), 2, ',', '.') }}</td>
                                        <td>
                                            {{ $penjualan->id_pelanggan }} - {{ $penjualan->pelanggan->nama_pelanggan ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('penjualans.destroy', $penjualan->id_penjualan) }}" method="POST">
                                                <a href="{{ route('penjualans.show', $penjualan->id_penjualan) }}" class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('penjualans.edit', $penjualan->id_penjualan) }}" class="btn btn-sm btn-primary">EDIT</a>
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

                        <!-- Pagination -->
                        @if ($penjualans->hasPages())
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                @if ($penjualans->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $penjualans->previousPageUrl() }}" rel="prev">Sebelumnya</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($penjualans->links()->elements[0] as $page => $url)
                                    @if ($page == $penjualans->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($penjualans->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $penjualans->nextPageUrl() }}" rel="next">Berikutnya</a>
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
