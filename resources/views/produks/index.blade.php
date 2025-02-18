@extends('layout.main')

@section('isi')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Tabel Produk</h3>
                        
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('produks.create') }}" class="btn btn-md btn-success mb-3">TAMBAH PRODUK</a>
                        
                        <div class="d-flex justify-content-end mb-3">
                            <input type="text" id="searchInput" class="form-control w-25" placeholder="&#128269; Cari...">
                        </div>
                        
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                              <tr>
                                <th scope="col">ID PRODUK</th>
                                <th scope="col">NAMA PRODUK</th>
                                <th scope="col">HARGA</th>
                                <th scope="col">STOK</th>
                                <th scope="col">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>

                                
                                @php
                                $sortedProduks = $produks->sortBy('id_produk');
                                @endphp
                              @forelse ($produks as $produk)
                              <tr>
                                <td>{{ sprintf('%03d', $produk->id_produk) }}</td>
                                <td>{{ $produk->nama_produk }}</td>
                                <!-- Kolom Harga -->
                                <td data-harga="{{ $produk->harga }}">{{ 'Rp' . number_format((float) $produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('produks.destroy', $produk->id_produk) }}" method="POST">
                                        <a href="{{ route('produks.show', $produk->id_produk) }}" class="btn btn-sm btn-dark">SHOW</a>
                                        <a href="{{ route('produks.edit', $produk->id_produk) }}" class="btn btn-sm btn-primary">EDIT</a>
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
@if ($produks->hasPages())
<nav>
    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($produks->onFirstPage())
            <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $produks->previousPageUrl() }}" rel="prev">Sebelumnya</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($produks->links()->elements[0] as $page => $url)
            @if ($page == $produks->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($produks->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $produks->nextPageUrl() }}" rel="next">Berikutnya</a>
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
