<?php

namespace App\Exports;

use App\Models\properti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PropertiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return properti::get([
            'id', 'user_id', 'category_id', 'jenis', 'nama', 'deskripsi',
            'alamat_gmap', 'provinsi', 'kabupaten', 'kecamatan', 'kode_pos',
            'luas_tanah', 'luas_bangunan', 'sertifikat', 'umur_bangunan',
            'jumlah_lantai', 'kamar_tidur', 'kamar_mandi', 'kamar_tidur_art',
            'kamar_mandi_art', 'daya_listrik', 'orientasi_bangunan', 'tahun_dibangun',
            'interior', 'fasilitas', 'pdam', 'foto_tampak_depan', 'foto_tampak_jalan',
            'foto_tampak_ruangan', 'harga', 'cicilan', 'uang_muka', 'nego',
            'harga_uang_muka', 'longitude', 'latitude', 'whatsapp', 'kontak',
            'tayang', 'pet_allowed', 'created_at', 'updated_at', 'deleted_at',
            'exp'
        ]);
    }

    public function headings(): array {
        return [
            'ID', 'User ID', 'ID Kategori', 'Jenis', 'Nama', 'Deskripsi',
            'Alamat Google Map', 'Provinsi', 'Kabupaten', 'Kecamatan', 'Kode Pos',
            'Luas Tanah', 'Luas Bangunan', 'Sertifikat', 'Umur Bangunan', 'Jumlah Lantai',
            'Kamar Tidur', 'Kamar Mandi', 'Kamar Tidur ART', 'Kamar Mandi ART', 'Daya Listrik',
            'Orientasi Bangunan', 'Tahun Dibangun', 'Interior', 'Fasilitas',
            'PDAM', 'URL Foto Tampak Depan', 'URL Foto Tampak Jalan',
            'URL Foto Tampak Ruangan', 'Harga', 'Cicilan', 
            'Uang Muka', 'Nego', 'Harga Uang Muka', 'Longitude', 'Latitude',
            'WhatsApp', 'Kontak', 'Tayang', 'Pet Allowed', 'Dibuat Pada', 'Diupdate Pada',
            'Kadaluwarsa Pada'
        ];
    }
}
