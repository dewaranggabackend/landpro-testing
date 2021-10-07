<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class properti extends Model
{
    use SoftDeletes;
    protected $table = 'properti';
    protected $fillable = ['user_id', 'category_id', 'jenis', 'nama', 'deskripsi', 'alamat_gmap', 'provinsi', 'kabupaten', 'kecamatan', 
    'kode_pos', 'luas_tanah', 'luas_bangunan', 'sertifikat', 'umur_bangunan', 'jumlah_lantai', 'kamar_tidur', 'kamar_mandi', 'kamar_tidur_art', 
    'kamar_mandi_art', 'daya_listrik', 'orientasi_bangunan', 'tahun_dibangun', 'interior', 'fasilitas', 'pdam', 'foto_tampak_depan', 
    'foto_tampak_jalan', 'foto_tampak_ruangan', 'foto_tampak_lain', 'harga', 'cicilan', 'uang_muka', 'nego', 'harga_uang_muka', 'longitude',
    'latitude', 'whatsapp', 'kontak', 'tayang', 'pet_allowed', 'exp'];

    public function category () {
        return $this->belongsTo('\App\Models\category', 'category_id', 'id');
    }

    public function pengguna () {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function properti () {
        return $this->belongsTo('\App\Models\properti', 'properti_id', 'id');
    }
}
