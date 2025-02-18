@extends('layout.main')

@section('isi')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Tabel Pelanggan</h3>
                    
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('pelanggans.create') }}" class="btn btn-md btn-success mb-3">TAMBAH PELANGGAN</a>
                        
                        <div class="d-flex justify-content-end mb-3">
                            <input type="text" id="searchInput" class="form-control w-25" placeholder="&#128269; Cari...">
                        </div>
                        
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                              <tr>
                                <th scope="col">ID PELANGGAN</th>
                                <th scope="col">NAMA PELANGGAN</th>
                                <th scope="col">ALAMAT</th>
                                <th scope="col">NOMOR TELEPON</th>
                                <th scope="col">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>

                                
                                @php
                                $sortedPelanggan = $pelanggans->sortBy('id_pelanggan');
                                @endphp
                              @forelse ($pelanggans as $pelanggan)
                                <tr>
                                    <td>{{ $pelanggan->id_pelanggan }}</td>
                                    <td>{{ $pelanggan->nama_pelanggan }}</td>
                                    <td>{!! $pelanggan->alamat !!}</td>
                                    <td>{{ $pelanggan->nomor_telepon }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pelanggans.destroy', $pelanggan->id_pelanggan) }}" method="POST">
                                            <a href="{{ route('pelanggans.show', $pelanggan->id_pelanggan) }}" class="btn btn-sm btn-dark">SHOW</a>
                                            <a href="{{ route('pelanggans.edit', $pelanggan->id_pelanggan) }}" class="btn btn-sm btn-primary">EDIT</a>
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
@if ($pelanggans->hasPages())
<nav>
    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($pelanggans->onFirstPage())
            <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $pelanggans->previousPageUrl() }}" rel="prev">Sebelumnya</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($pelanggans->links()->elements[0] as $page => $url)
            @if ($page == $pelanggans->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($pelanggans->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $pelanggans->nextPageUrl() }}" rel="next">Berikutnya</a>
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