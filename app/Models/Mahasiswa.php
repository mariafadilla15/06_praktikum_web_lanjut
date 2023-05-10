<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;

class Mahasiswa extends Model
{
    protected $table = "mahasiswas"; //Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswa
    //public $timestamps = false;
    protected $primaryKey = 'Nim'; //Memanggil isi DB dengan primarykey
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Nim',
        'Nama',
        'featured_image',
        'Kelas',
        'Jurusan',
        'No_Handphone',
        'Email',
        'Tanggal_Lahir'
    ];

    #JS9 - Latihan
    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }

    public function mataKuliah(){
        return $this->belongsToMany(Matakuliah::class, "mahasiswa_matakuliah", "mahasiswa_id", "matakuliah_id")->withPivot('nilai');
    }
};