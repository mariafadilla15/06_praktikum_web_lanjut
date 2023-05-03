@extends('mahasiswas.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('mahasiswas.create') }}"> Input Mahasiswa</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col-md-4">
            <form action="{{ route('mahasiswas.index') }}" method="GET" role="search">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nama">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <!-- tabel tampilan -->
    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No Handphone</th>
            <th>Email</th>
            <th>Tanggal Lahir</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($mahasiswas as $Mahasiswa)
        <tr>
            <td>{{ $Mahasiswa->Nim }}</td>
            <td>{{ $Mahasiswa->Nama }}</td>
            <td>{{ $Mahasiswa->Kelas ? $Mahasiswa->Kelas->nama_kelas : '-' }}</td>
            <td>{{ $Mahasiswa->Jurusan }}</td>
            <td>{{ $Mahasiswa->No_Handphone }}</td>
            <td>{{ $Mahasiswa->Email }}</td>
            <td>{{ $Mahasiswa->Tanggal_Lahir }}</td>
            <td>
            <form action="{{ route('mahasiswas.destroy',$Mahasiswa->Nim) }}" method="POST">

            <a class="btn btn-info" href="{{ route('mahasiswas.show',$Mahasiswa->Nim) }}">Show</a>
            <a class="btn btn-primary" href="{{ route('mahasiswas.edit',$Mahasiswa->Nim) }}">Edit</a> <!-- JS9 - Latihan -->
            <a class="btn btn-warning" href="/mahasiswas/nilai/{{ $Mahasiswa->Nim }}">Nilai </a>
        @csrf
        @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td>
            </tr>
        @endforeach
    </table>

    <!-- link ke mahasiswa berikutnya  -->
    {{ $mahasiswas->links() }}

    <a class="btn btn-success mt-3" href="{{ route('home') }}">Kembali</a>

@endsection