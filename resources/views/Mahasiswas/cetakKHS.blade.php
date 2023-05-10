<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Hasil Studi (KHS)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 50px auto;
            max-width: 800px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        ul li {
            list-style: none;
            margin-bottom: 10px;
        }
        table {
            border-collapse: collapse;
            margin-top: 30px;
            width: 100%;
        }
        table th,
        table td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

    <div class="container mt-3">
        <div class="text-center">
            <h4>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h4>
        </div>
        <h2 class="text-center mt-4 mb-5">KARTU HASIL STUDI (KHS)</h2>
        <div class="row">
            <div class="col">
                <strong>Name: </strong> {{$mahasiswa->Nama}}<br>
                <strong>NIM: </strong> {{$mahasiswa->Nim}}<br>
                <strong>Class: </strong> {{$mahasiswa->Kelas->nama_kelas}}
            </div>
        </div>
        <br>
        <table class="table table-bordered">
                <tr>
                    <th scope="col">Mata Kuliah</th>
                    <th scope="col">SKS</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Nilai</th>
                </tr>
                @foreach ($mahasiswa->matakuliah as $matkul)
                <tr>
                    <td>{{ $matkul->nama_matkul }}</td>
                    <td>{{ $matkul->sks }}</td>
                    <td>{{ $matkul->semester }}</td>
                    <td>{{ $matkul->pivot->nilai }}</td>
                </tr>
                @endforeach
        </table>
    </div>
</body>