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
        return properti::all();
    }

    public function headings(): array {
        return [
            'ID', 'User ID', 'ID Kategori', 'Jenis', 'Nama', 'Deskripsi',
            'Alamat Google Map', 'Provinsi', 'Kabupaten', 'Kecamatan', 'Kode Pos',
            'Luas Tanah', 'Luas Bangunan', 'Sertifikat', 'Umur Bangunan', 'Jumlah Lantai',
            'Kamar Tidur', 'Kamar Mandi', 'Kamar Tidur ART', 'Kamar Mandi ART', 'Daya Listrik',
            'Orientasi Bangunan', 'Tahun Dibangun', 'Interior', 'Fasilitas',
            'PDAM', 'URL Foto Tampak Depan', 'URL Foto Tampak Jalan',
            'URL Foto Tampak Ruangan', 'URL Foto Tampak Lain', 'Harga', 'Cicilan', 
            'Uang Muka', 'Nego', 'Harga Uang Muka', 'Longitude', 'Latitude',
            'WhatsApp', 'Kontak', 'Tayang', 'Pet Allowed', 'Dibuat Pada', 'Diupdate Pada',
            'Kadaluwarsa Pada'
        ];
    }
}
