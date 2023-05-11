<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\PDF;

class MahasiswaController extends Controller
{
    public function index()
    {   $mahasiswas = Mahasiswa::paginate(5);
        return view('mahasiswas.index', compact('mahasiswas'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // public function index(Request $request)
    // {
    //     if ($request->has('search')) {
    //         $mahasiswas = Mahasiswa::where('Nama', 'LIKE', '%'. request('search') . '%')->paginate(5);
    //         return view('mahasiswas.index', ['mahasiswas' => $mahasiswas]);
    //     }else{
    //     //fungsi eloquent menampilkan data menggunakan pagination
    //     // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
    //     $mahasiswas = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);
    //     return view('mahasiswas.index', compact('mahasiswas'))
    //     ->with('i', (request()->input('page', 1) - 1) * 5);
    //     }
    // }
    
    //otorisasi akses route mahasiswas
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function create()
    // {
    //     // return view('mahasiswas.create');
    //     $kelas = Kelas::all();
    //     return view('mahasiswas.create',['Kelas'=>$kelas]);
    // }

    public function create()
{
    $kelas = Kelas::all();
    return view('mahasiswas.create', compact('kelas'));
}

    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
            ]);

            //fungsi eloquent untuk menambah data
            //Mahasiswa::create($request->all());
            $image_name = null;
            if ($request->file('image')){
                $image_name = $request->file('image')->store('images', 'public');
            }
            $mahasiswas = new Mahasiswa;
            $mahasiswas->Nim=$request->get('Nim');
            $mahasiswas->Nama=$request->get('Nama');
            $mahasiswas->featured_image=$image_name;
            $mahasiswas->Jurusan=$request->get('Jurusan');
            $mahasiswas->No_Handphone=$request->get('No_Handphone');
            $mahasiswas->Email=$request->get('Email');
            $mahasiswas->Tanggal_Lahir=$request->get('Tanggal_Lahir');

            //fungsi eloquent untuk menambah data dengan relasi belongs to
            $kelas = new Kelas;
            $kelas->id = $request->get('Kelas');

            $mahasiswas->kelas()->associate($kelas);
            $mahasiswas->save();

            //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('mahasiswas.index')
                ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::find($Nim);
        $kelas = Kelas::all(); // mengambil seluruh data kelas dari database
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }

    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        //mencari mahasiswa berdasarkan nim
        $Mahasiswa = Mahasiswa::find($Nim);

        $mahasiswas = Mahasiswa::with('Kelas')->where('Nim', $Nim)->first();
        $mahasiswas->Nim = $request->get('Nim');
        $mahasiswas->Nama = $request->get('Nama');
        $mahasiswas->Jurusan = $request->get('Jurusan');
        $mahasiswas->No_Handphone = $request->get('No_Handphone');
        $mahasiswas->Email = $request->get('Email');
        $mahasiswas->Tanggal_Lahir = $request->get('Tanggal_Lahir');

        // menghapus gambar lama jika ada
        if ($Mahasiswa->featured_image && file_exists(storage_path('app/public/' . $Mahasiswa->featured_image))){
            Storage::delete('public/' . $Mahasiswa->featured_image);
        }
        // menyimpan file gambar yang baru
        $image_name = $request->file('image')->store('images', 'public');
        $mahasiswas->featured_image = $image_name;
        
        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //Fungsi eloquent untuk mengupdate data dengan relasi belongs to
        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save();

        //fungsi eloquent untuk mengupdate data inputan kita
            //Mahasiswa::find($Nim)->update($request->all());

        //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswas.index')
                ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }

    #JS9 - Latihan 
    public function khs($Nim)
    {
        $mahasiswa = Mahasiswa::find($Nim);

        return view('mahasiswas.khs', compact('mahasiswa'));
    }

    #JS10 - Tugas Praktikum
    public function cetak_khs($Nim){
        $mahasiswa = Mahasiswa::find($Nim);
        
        $pdf = PDF::loadview('mahasiswas.cetakKHS',['mahasiswa'=>$mahasiswa]);
        return $pdf->stream();
    }
};