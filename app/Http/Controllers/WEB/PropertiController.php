<?php

namespace App\Http\Controllers\WEB;

use App\Exports\PropertiExport;
use App\Http\Controllers\Controller;
use App\Models\favorite;
use App\Models\properti;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PropertiController extends Controller
{
    public function properti () {
        $current = date('Y-m-d H:i:s');
        $properties = properti::where('exp', '>', $current)->orWhere('exp', null)->paginate(20);
        return view ('admin.properti', ['properties' => $properties]);
    }

    public function propertiExcel () {
        return Excel::download(new PropertiExport, 'properti_all.xlsx');
    }

    public function propertiExpire () {
        $current = date('Y-m-d H:i:s');
        $properties = properti::where('exp', '<', $current)->paginate(20);
        return view ('admin.properti_expire', ['properties' => $properties]);
    }

    public function nonaktif () {
        $properties = properti::onlyTrashed()->paginate(20);
        return view ('admin.nonaktif', compact('properties'));
    }

    public function fresh () {
        $current = date('Y-m-d H:i:s');
        $voucher = properti::where('exp', '<', $current);
        $voucher->update([
            'tayang' => 0,
        ]);

        return redirect ('properti/expire')->with('sukses', 'sukses! data properti berhasil diupdate');
    }

    public function off ($id) {
        $properti = properti::find($id);
        favorite::where('properti_id', $id)->delete();
        $properti->delete();

        return redirect ('properti')->with('sukses', 'Sukses! properti berhasil dipindahkan ke tong sampah.');
    }

    public function aktif ($id) {
        $properties = properti::withTrashed()->find($id);
        $properties->restore();
        return redirect ('/properti/nonaktif')->with('sukses', 'Sukses! properti berhasil dipulihkan kembali!');
    }

    public function hapusProperti ($id) {
        $user = properti::withTrashed()->find($id);
        $user->forceDelete();
        return redirect ('/properti/nonaktif')->with('sukses', 'Sukses! properti berhasil dihapus permanen.');
    }

    public function detailProperti ($id) {
        $properti = properti::where('id', $id)->get();
        return view ('admin.detail_properti', compact('properti'));
    }

    public function propertiStop ($id) {
        $data = properti::find($id);
        $data->update([
            'tayang' => 0,
            'exp' => null
        ]);

        return redirect('properti/expire')->with('sukses', 'sukses! penayangan berhasil di stop');
    }

    public function searchProperti (Request $request) {
        $data = $request->cari;
        $result = properti::where('nama', 'LIKE', '%'.$data.'%')->orWhere('deskripsi', 'LIKE', '%'.$data.'%')->orWhere('provinsi', 'LIKE', '%'.$data.'%')->orWhere('kabupaten', 'LIKE', '%'.$data.'%')->orWhere('kecamatan', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.properti_search', compact('result'));
    }

    public function tambahProperti () {
        return view ('admin.tambah_properti');
    }

    public function searchPropertiTrashed (Request $request) {
        $data = $request->cari;
        $result = properti::onlyTrashed()->where('id', $data)->paginate(20);
        return view ('admin.nonaktif_search', compact('result'));
    }

    public function tambahPropertiPost (Request $request) {
        $cek_kategori = "$request->category_id";
        if ($cek_kategori == 1) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/rumah/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/rumah/'.implode('|public/uploads/properti/rumah/', $foto_tampak_lain);
            properti::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'alamat_gmap' => $request->alamat_gmap,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'sertifikat' => $request->sertifikat,
                'umur_bangunan' => $request->umur_bangunan,
                'jumlah_lantai' => $request->jumlah_lantai,
                'kamar_tidur' => $request->kamar_tidur,
                'kamar_mandi' => $request->kamar_mandi,
                'kamar_tidur_art' => $request->kamar_tidur_art,
                'kamar_mandi_art' => $request->kamar_mandi_art,
                'daya_listrik' => $request->daya_listrik,
                'orientasi_bangunan' => $request->orientasi_bangunan,
                'tahun_dibangun' => $request->tahun_dibangun,
                'interior' => $request->interior,
                'fasilitas' => $request->fasilitas,
                'pdam' => $request->pdam,
                'foto_tampak_depan' => 'public/uploads/properti/rumah/'.$gambar_1_final,
                'foto_tampak_jalan' => 'public/uploads/properti/rumah/'.$gambar_2_final,
                'foto_tampak_ruangan' => 'public/uploads/properti/rumah/'.$gambar_3_final,
                'foto_tampak_lain' => $ftl,
                'harga' => $request->harga,
                'cicilan' => $request->cicilan,
                'uang_muka' => $request->uang_muka,
                'nego' => $request->nego,
                'harga_uang_muka' => $request->harga_uang_muka,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'whatsapp'=> $request->whatsapp,
                'kontak' => $request->kontak,
                'tayang' => $request->tayang,
                'pet_allowed' => $request->pet_allowed,
            ]);

            $gambar_1->move('public/uploads/properti/rumah/', $gambar_1_final);
            $gambar_2->move('public/uploads/properti/rumah/', $gambar_2_final);
            $gambar_3->move('public/uploads/properti/rumah/', $gambar_3_final);

            return redirect ('/properti')->with('sukses', 'properti rumah berhasil ditambahkan');
        }

        if ($cek_kategori == 2) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/resedensial/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/resedensial/'.implode('|public/uploads/properti/resedensial/', $foto_tampak_lain);
            properti::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'alamat_gmap' => $request->alamat_gmap,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'sertifikat' => $request->sertifikat,
                'umur_bangunan' => $request->umur_bangunan,
                'jumlah_lantai' => $request->jumlah_lantai,
                'kamar_tidur' => $request->kamar_tidur,
                'kamar_mandi' => $request->kamar_mandi,
                'kamar_tidur_art' => $request->kamar_tidur_art,
                'kamar_mandi_art' => $request->kamar_mandi_art,
                'daya_listrik' => $request->daya_listrik,
                'orientasi_bangunan' => $request->orientasi_bangunan,
                'tahun_dibangun' => $request->tahun_dibangun,
                'interior' => $request->interior,
                'fasilitas' => $request->fasilitas,
                'pdam' => $request->pdam,
                'foto_tampak_depan' => 'public/uploads/properti/resedensial/'.$gambar_1_final,
                'foto_tampak_jalan' => 'public/uploads/properti/resedensial/'.$gambar_2_final,
                'foto_tampak_ruangan' => 'public/uploads/properti/resedensial/'.$gambar_3_final,
                'foto_tampak_lain' => $ftl,
                'harga' => $request->harga,
                'cicilan' => $request->cicilan,
                'uang_muka' => $request->uang_muka,
                'nego' => $request->nego,
                'harga_uang_muka' => $request->harga_uang_muka,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'whatsapp'=> $request->whatsapp,
                'kontak' => $request->kontak,
                'tayang' => $request->tayang,
                'pet_allowed' => $request->pet_allowed,
            ]);

            $gambar_1->move('public/uploads/properti/resedensial/', $gambar_1_final);
            $gambar_2->move('public/uploads/properti/resedensial/', $gambar_2_final);
            $gambar_3->move('public/uploads/properti/resedensial/', $gambar_3_final);

            return redirect ('/properti')->with('sukses', 'properti resedensial berhasil ditambahkan');
        }

        if ($cek_kategori == 3) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();

            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/tanah/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/tanah/'.implode('|public/uploads/properti/tanah/', $foto_tampak_lain);
            properti::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'alamat_gmap' => $request->alamat_gmap,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'luas_tanah' => $request->luas_tanah,
                'sertifikat' => $request->sertifikat,
                'foto_tampak_depan' => 'public/uploads/properti/tanah/'.$gambar_1_final,
                'foto_tampak_jalan' => 'public/uploads/properti/tanah/'.$gambar_2_final,
                'foto_tampak_ruangan' => 'public/uploads/properti/tanah/'.$gambar_3_final,
                'foto_tampak_lain' => $ftl,
                'harga' => $request->harga,
                'uang_muka' => $request->uang_muka,
                'nego' => $request->nego,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'whatsapp'=> $request->whatsapp,
                'kontak' => $request->kontak,
                'tayang' => $request->tayang
            ]);

            $gambar_1->move('public/uploads/properti/tanah/', $gambar_1_final);
            $gambar_2->move('public/uploads/properti/tanah/', $gambar_2_final);
            $gambar_3->move('public/uploads/properti/tanah/', $gambar_3_final);

            return redirect ('/properti')->with('sukses', 'properti tanah berhasil ditambahkan');
        }

        if ($cek_kategori == 4) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();

            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/kantor/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/kantor/'.implode('|public/uploads/properti/kantor/', $foto_tampak_lain);
            properti::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'alamat_gmap' => $request->alamat_gmap,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'sertifikat' => $request->sertifikat,
                'umur_bangunan' => $request->umur_bangunan,
                'jumlah_lantai' => $request->jumlah_lantai,
                'kamar_tidur' => $request->kamar_tidur,
                'kamar_mandi' => $request->kamar_mandi,
                'kamar_tidur_art' => $request->kamar_tidur_art,
                'kamar_mandi_art' => $request->kamar_mandi_art,
                'daya_listrik' => $request->daya_listrik,
                'orientasi_bangunan' => $request->orientasi_bangunan,
                'tahun_dibangun' => $request->tahun_dibangun,
                'interior' => $request->interior,
                'fasilitas' => $request->fasilitas,
                'pdam' => $request->pdam,
                'foto_tampak_depan' => 'public/uploads/properti/kantor/'.$gambar_1_final,
                'foto_tampak_jalan' => 'public/uploads/properti/kantor/'.$gambar_2_final,
                'foto_tampak_ruangan' => 'public/uploads/properti/kantor/'.$gambar_3_final,
                'foto_tampak_lain' => $ftl,
                'harga' => $request->harga,
                'cicilan' => $request->cicilan,
                'uang_muka' => $request->uang_muka,
                'nego' => $request->nego,
                'harga_uang_muka' => $request->harga_uang_muka,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'whatsapp'=> $request->whatsapp,
                'kontak' => $request->kontak,
                'tayang' => $request->tayang,
                'pet_allowed' => $request->pet_allowed,
            ]);

            $gambar_1->move('public/uploads/properti/kantor/', $gambar_1_final);
            $gambar_2->move('public/uploads/properti/kantor/', $gambar_2_final);
            $gambar_3->move('public/uploads/properti/kantor/', $gambar_3_final);

            return redirect ('/properti')->with('sukses', 'properti kantor berhasil ditambahkan');
        }

        if ($cek_kategori == 5) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();

            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/ruang/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/ruang/'.implode('|public/uploads/properti/ruang/', $foto_tampak_lain);
            properti::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'alamat_gmap' => $request->alamat_gmap,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'sertifikat' => $request->sertifikat,
                'umur_bangunan' => $request->umur_bangunan,
                'jumlah_lantai' => $request->jumlah_lantai,
                'kamar_tidur' => $request->kamar_tidur,
                'kamar_mandi' => $request->kamar_mandi,
                'kamar_tidur_art' => $request->kamar_tidur_art,
                'kamar_mandi_art' => $request->kamar_mandi_art,
                'daya_listrik' => $request->daya_listrik,
                'orientasi_bangunan' => $request->orientasi_bangunan,
                'tahun_dibangun' => $request->tahun_dibangun,
                'interior' => $request->interior,
                'fasilitas' => $request->fasilitas,
                'pdam' => $request->pdam,
                'foto_tampak_depan' => 'public/uploads/properti/ruang/'.$gambar_1_final,
                'foto_tampak_jalan' => 'public/uploads/properti/ruang/'.$gambar_2_final,
                'foto_tampak_ruangan' => 'public/uploads/properti/ruang/'.$gambar_3_final,
                'foto_tampak_lain' => $ftl,
                'harga' => $request->harga,
                'cicilan' => $request->cicilan,
                'uang_muka' => $request->uang_muka,
                'nego' => $request->nego,
                'harga_uang_muka' => $request->harga_uang_muka,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'whatsapp'=> $request->whatsapp,
                'kontak' => $request->kontak,
                'tayang' => $request->tayang,
                'pet_allowed' => $request->pet_allowed,
            ]);

            $gambar_1->move('public/uploads/properti/ruang/', $gambar_1_final);
            $gambar_2->move('public/uploads/properti/ruang/', $gambar_2_final);
            $gambar_3->move('public/uploads/properti/ruang/', $gambar_3_final);

            return redirect ('/properti')->with('sukses', 'properti ruang berhasil ditambahkan');
        }

        if ($cek_kategori == 6) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();

            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/apartemen/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/apartemen/'.implode('|public/uploads/properti/apartemen/', $foto_tampak_lain);
            properti::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'alamat_gmap' => $request->alamat_gmap,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'sertifikat' => $request->sertifikat,
                'umur_bangunan' => $request->umur_bangunan,
                'jumlah_lantai' => $request->jumlah_lantai,
                'kamar_tidur' => $request->kamar_tidur,
                'kamar_mandi' => $request->kamar_mandi,
                'kamar_tidur_art' => $request->kamar_tidur_art,
                'kamar_mandi_art' => $request->kamar_mandi_art,
                'daya_listrik' => $request->daya_listrik,
                'orientasi_bangunan' => $request->orientasi_bangunan,
                'tahun_dibangun' => $request->tahun_dibangun,
                'interior' => $request->interior,
                'fasilitas' => $request->fasilitas,
                'pdam' => $request->pdam,
                'foto_tampak_depan' => 'public/uploads/properti/apartemen/'.$gambar_1_final,
                'foto_tampak_jalan' => 'public/uploads/properti/apartemen/'.$gambar_2_final,
                'foto_tampak_ruangan' => 'public/uploads/properti/apartemen/'.$gambar_3_final,
                'foto_tampak_lain' => $ftl,
                'harga' => $request->harga,
                'cicilan' => $request->cicilan,
                'uang_muka' => $request->uang_muka,
                'nego' => $request->nego,
                'harga_uang_muka' => $request->harga_uang_muka,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'whatsapp'=> $request->whatsapp,
                'kontak' => $request->kontak,
                'tayang' => $request->tayang,
                'pet_allowed' => $request->pet_allowed,
            ]);

            $gambar_1->move('public/uploads/properti/apartemen/', $gambar_1_final);
            $gambar_2->move('public/uploads/properti/apartemen/', $gambar_2_final);
            $gambar_3->move('public/uploads/properti/apartemen/', $gambar_3_final);

            return redirect ('/properti')->with('sukses', 'properti apartemen berhasil ditambahkan');
        }

        if ($cek_kategori == 7) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();

            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/ruko/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/ruko/'.implode('|public/uploads/properti/ruko/', $foto_tampak_lain);
            properti::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'alamat_gmap' => $request->alamat_gmap,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'sertifikat' => $request->sertifikat,
                'umur_bangunan' => $request->umur_bangunan,
                'jumlah_lantai' => $request->jumlah_lantai,
                'kamar_tidur' => $request->kamar_tidur,
                'kamar_mandi' => $request->kamar_mandi,
                'kamar_tidur_art' => $request->kamar_tidur_art,
                'kamar_mandi_art' => $request->kamar_mandi_art,
                'daya_listrik' => $request->daya_listrik,
                'orientasi_bangunan' => $request->orientasi_bangunan,
                'tahun_dibangun' => $request->tahun_dibangun,
                'interior' => $request->interior,
                'fasilitas' => $request->fasilitas,
                'pdam' => $request->pdam,
                'foto_tampak_depan' => 'public/uploads/properti/ruko/'.$gambar_1_final,
                'foto_tampak_jalan' => 'public/uploads/properti/ruko/'.$gambar_2_final,
                'foto_tampak_ruangan' => 'public/uploads/properti/ruko/'.$gambar_3_final,
                'foto_tampak_lain' => $ftl,
                'harga' => $request->harga,
                'cicilan' => $request->cicilan,
                'uang_muka' => $request->uang_muka,
                'nego' => $request->nego,
                'harga_uang_muka' => $request->harga_uang_muka,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'whatsapp'=> $request->whatsapp,
                'kontak' => $request->kontak,
                'tayang' => $request->tayang,
                'pet_allowed' => $request->pet_allowed,
            ]);

            $gambar_1->move('public/uploads/properti/ruko/', $gambar_1_final);
            $gambar_2->move('public/uploads/properti/ruko/', $gambar_2_final);
            $gambar_3->move('public/uploads/properti/ruko/', $gambar_3_final);

            return redirect ('/properti')->with('sukses', 'properti ruko berhasil ditambahkan');
        }
    }
}
