<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Hash;
use Validator;

class adminApiController extends Controller
{
    public function usersDelFavorite (Request $request) {
        if ($request->user_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom user_id tidak boleh kosong'
            ], 400);
        }

        if ($request->agen_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom agen_id tidak boleh kosong'
            ], 400);
        }

        $data = \App\Models\agenf::where('user_id', $request->user_id)->where('agen_id', $request->agen_id);
        $data->delete();
        return response()->json([
            'status' => 'sukses'
        ], 200);
    }

    public function gantiPassword (Request $request) {
        $users = \App\Models\User::where('id', $request->id)->first();
        if (!isset ($users)) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ]);
        }
       
        if (Hash::check($request->password, $users->password)) { 
            $user = \App\Models\User::where('id', $request->id);
            $user->update([
             'password' => Hash::make($request->new_password)
             ]);
             
             return response()->json([
                'status' => 'sukses',
                'data' => 'Sukes! data berhasil dirubah'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => 'Maaf! password yang anda masukkan tidak sesuai'
        ], 400);
    }

    public function profileUsers ($id) {
        $user = \App\Models\User::where('id', $id)->get();
        if (!isset($user[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ]);
        }

        $properti = \App\Models\properti::with('pengguna')->where('user_id', $id)->where('tayang', 1)->get();
        return response()->json([
            'status' => 'status',
            'profile' => $user,
            'data' => $properti,
        ]);
    }

    public function usersAddFavorite (Request $request) {
        if ($request->user_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom users_id tidak boleh kosong'
            ], 400);
        }

        if ($request->agen_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom agen_id tidak boleh kosong'
            ], 400);
        }

        \App\Models\agenf::create($request->all());
        return response()->json([
            'status' => 'sukses'
        ], 200);
    }

    public function usersFavorite ($id) {
        $favorit = \App\Models\agenf::with('pengguna')->where('user_id', $id)->get();

        if (!isset($favorit[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }

        foreach ($favorit as $fav) {
            $hasil = (int) $fav->agen_id;
            $properti = \App\Models\properti::where('user_id', $hasil)->where('tayang', 1)->get();
            $propertis = \App\Models\properti::where('user_id', $hasil)->where('jenis', 0)->where('tayang', 1)->get();
            $propertiz = \App\Models\properti::where('user_id', $hasil)->where('jenis', 1)->where('tayang', 1)->get();
            $fav['properti'] = (object)[];
            $fav['jumlah_properti'] = count($properti);
            $fav['jumlah_properti_sewa'] = count($propertis);
            $fav['jumlah_properti_jual'] = count($propertiz);
        }

        return response()->json([
            'status' => 'sukses',
            'data' => [
                'main' => $favorit
            ]
        ], 200);
    }

    public function properti () {
        $properties = \App\Models\properti::with('pengguna')->where('tayang', 1)->paginate(10);
        foreach ($properties as $properti) {
            return response()->json($properties);
        }
    }

    public function detailProperti ($id) {
        $properti = \App\Models\properti::with('pengguna')->find($id);
        if ($properti === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, properti yang anda cari tidak ada.'
            ], 404);
        }

        if ($properti->tayang === 0) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, properti belum tayang'
            ], 403);
        }

        return response()->json([
            'status' => 'sukses',
            'data' => $properti
        ], 200);
    }

    public function delFavorite (Request $request) {
        if ($request->users_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom users_id tidak boleh kosong'
            ], 400);
        }

        if ($request->properti_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom properti_id tidak boleh kosong'
            ], 400);
        }
        $data = \App\Models\favorite::where('users_id', $request->users_id)->where('properti_id', $request->properti_id);
        $data->delete();
        return response()->json([
            'status' => 'sukses'
        ], 200);
    }

    public function addFavorite (Request $request) {
        if ($request->users_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom users_id tidak boleh kosong'
            ], 400);
        }

        if ($request->properti_id === null) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, kolom properti_id tidak boleh kosong'
            ], 400);
        }

        \App\Models\favorite::create($request->all());
        return response()->json([
            'status' => 'sukses'
        ], 200);
    }

    public function favorite ($id) {
        $favorit = \App\Models\favorite::with('properti.pengguna')->where('users_id', $id)->get();
       
        if (!isset($favorit[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'status' => 'sukses',
            'data' => [
                'main' => $favorit
            ]
        ], 200);
    }

    public function editProfile (Request $request) {
        $user = \App\Models\User::where('id', $request->user_id)->get();
        if (!isset($user[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }
        return response()->json($user);
    }

    public function editProfilePost (Request $request) {
        $user = \App\Models\User::where('id', $request->id)->first();
        if (!isset($user)) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }
        $nama = $request->nama;
        $no_telp = $request->no_telp;

        \App\Models\User::where('id', $request->id)->update([
            'name' => $nama,
            'no_telp' => $no_telp
        ]);

        return response()->json([
            'status' => 'sukses',
            'data' => 'Sukses! data anda berhasil diupdate',
            'nama' => $nama,
            'no_telp' => $no_telp
        ]);
    }

    public function avatar (Request $request) {
        $user = \App\Models\User::where('id', $request->user_id);
        $gambar_1 = $request->avatar;
        $gambar_1_final = time().$gambar_1->getClientOriginalName();

        $user->update([
            'avatar' => 'public/uploads/avatar/'.$gambar_1_final,
        ]);

        $gambar_1->move('public/uploads/avatar/', $gambar_1_final);
        return response()->json([
            'status' => 'sukses',
            'data' => 'sukses! avatar berhasil dirubah',
            'path' => 'public/uploads/avatar/'.$gambar_1_final
        ], 200);
    }

    public function gambar_kategori () {
        $gambar = \App\Models\setting_kategori::all();
        return response()->json([
            'status' => 'sukses',
            'data' => $gambar,
        ], 200);
    }

    public function privasi () {
        $privasi = \App\Models\privacy::where('id', 1)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $privasi
        ], 200);
    }

    public function syarat () {
        $syarat = \App\Models\syarat::where('id', 1)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $syarat
        ], 200);
    }

    public function tentang () {
        $tentang = \App\Models\tentang::where('id', 1)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $tentang
        ], 200);
    }

    public function faq () {
        $faq = \App\Models\faq::all();
        return response()->json([
            'status' => 'sukses',
            'data' => $faq
        ], 200);
    }

    public function faq_detail ($id) {
        $faq_detail = \App\Models\faq::where('id', $id)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $faq_detail
        ], 200);
    }

    public function request (Request $request) {
        $data = $request->users_id;
        $find_id = \App\Models\request::where('users_id', $data)->get();
        $result = isset($find_id[0]);
        if ($result === true) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, request anda sebelumnya sudah ada didalam database'
            ], 304);
            
        } else {
            $req = \App\Models\request::create($request->all());
            return response()->json([
                'status' => 'sukses',
                'data' => 'sukses! request anda berhasil dikirim'
            ], 200);
        }
    }

    public function search (Request $request) {
        $keyword = $request->keyword;
            $properti = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 1)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                      ->orWhere('provinsi', $keyword)
                      ->orWhere('kabupaten', $keyword)
                      ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

            $properti_res = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 2)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                      ->orWhere('provinsi', $keyword)
                      ->orWhere('kabupaten', $keyword)
                      ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);
            
            $properti_tanah = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 3)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                      ->orWhere('provinsi', $keyword)
                      ->orWhere('kabupaten', $keyword)
                      ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

            $properti_kantor = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 4)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                      ->orWhere('provinsi', $keyword)
                      ->orWhere('kabupaten', $keyword)
                      ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);
            
            $properti_usaha = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 5)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                      ->orWhere('provinsi', $keyword)
                      ->orWhere('kabupaten', $keyword)
                      ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

            $properti_apartemen = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 6)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                      ->orWhere('provinsi', $keyword)
                      ->orWhere('kabupaten', $keyword)
                      ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

            $properti_ruko = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 7)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                      ->orWhere('provinsi', $keyword)
                      ->orWhere('kabupaten', $keyword)
                      ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        return response()->json([
            'status' => 'sukses',
            'rumah' => $properti,
            'resedensial' => $properti_res,
            'tanah' => $properti_tanah,
            'kantor' => $properti_kantor,
            'usaha' => $properti_usaha,
            'apartemen' => $properti_apartemen,
            'ruko' => $properti_ruko,
        ], 200);
    }

    public function searchSewa (Request $request) {
        $keyword = $request->keyword;
        $properti = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 1)->where('tayang', 1)
        ->where(function ($query) use ($keyword){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_res = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 2)->where('tayang', 1)
        ->where(function ($query) use ($keyword){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);
        
        $properti_tanah = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 3)->where('tayang', 1)
        ->where(function ($query) use ($keyword){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_kantor = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 4)->where('tayang', 1)
        ->where(function ($query) use ($keyword){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);
        
        $properti_usaha = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 5)->where('tayang', 1)
        ->where(function ($query) use ($keyword){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_apartemen = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 6)->where('tayang', 1)
        ->where(function ($query) use ($keyword){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_ruko = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 7)->where('tayang', 1)
        ->where(function ($query) use ($keyword){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

    return response()->json([
        'status' => 'sukses',
        'rumah' => $properti,
        'resedensial' => $properti_res,
        'tanah' => $properti_tanah,
        'kantor' => $properti_kantor,
        'usaha' => $properti_usaha,
        'apartemen' => $properti_apartemen,
        'ruko' => $properti_ruko,
    ], 200);
    }

    public function filter (Request $request) {
        if (!isset($request->harga_minimal)) {
            $request->harga_minimal = 0;
        }

        if (!isset($request->harga_maksimal)) {
            $request->harga_maksimal = 99999999999999;
        }

        $min = $request->harga_minimal;
        $max = $request->harga_maksimal;
        $kt = $request->kamar_tidur;
        $km = $request->kamar_mandi;
        $lt = $request->luas_tanah;
        $lb = $request->luas_bangunan;

        $keyword = $request->keyword;
        $properti = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 1)->where('tayang', 1);
        if (isset($request->kamar_tidur)) {
            if (!isset($request->min_kamar_tidur)){
                $request->min_kamar_tidur = 0;
            }

            $properti->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        }

        if (isset($request->kamar_mandi)) {
            if (!isset($request->min_kamar_mandi)) {
                $request->min_kamar_mandi = 0;
            }
            
            $properti->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        }

        if (isset($request->luas_tanah)) {
            if (!isset($request->min_luas_tanah)) {
                $request->min_luas_tanah = 0;
            }

            $properti->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        }

        if (isset($request->luas_bangunan)) {
            if (!isset($request->min_luas_bangunan)) {
                $request->min_luas_bangunan = 0;
            }

            $properti->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        }

        $properti->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                  ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        });

        $properti_res = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 2)->where('tayang', 1);
        if (isset($request->kamar_tidur)) {
            if (!isset($request->min_kamar_tidur)){
                $request->min_kamar_tidur = 0;
            }

            $properti_res->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        }

        if (isset($request->kamar_mandi)) {
            if (!isset($request->min_kamar_mandi)) {
                $request->min_kamar_mandi = 0;
            }
            
            $properti_res->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        }

        if (isset($request->luas_tanah)) {
            if (!isset($request->min_luas_tanah)) {
                $request->min_luas_tanah = 0;
            }

            $properti_res->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        }

        if (isset($request->luas_bangunan)) {
            if (!isset($request->min_luas_bangunan)) {
                $request->min_luas_bangunan = 0;
            }

            $properti_res->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        }

        $properti_res->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                  ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        });
        
        $properti_tanah = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 3)->where('tayang', 1);
        if (isset($request->kamar_tidur)) {
            if (!isset($request->min_kamar_tidur)){
                $request->min_kamar_tidur = 0;
            }

            $properti_tanah->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        }

        if (isset($request->kamar_mandi)) {
            if (!isset($request->min_kamar_mandi)) {
                $request->min_kamar_mandi = 0;
            }
            
            $properti_tanah->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        }

        if (isset($request->luas_tanah)) {
            if (!isset($request->min_luas_tanah)) {
                $request->min_luas_tanah = 0;
            }

            $properti_tanah->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        }

        if (isset($request->luas_bangunan)) {
            if (!isset($request->min_luas_bangunan)) {
                $request->min_luas_bangunan = 0;
            }

            $properti_tanah->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        }

        $properti_tanah->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                  ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        });

        $properti_kantor = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 4)->where('tayang', 1);
        if (isset($request->kamar_tidur)) {
            if (!isset($request->min_kamar_tidur)){
                $request->min_kamar_tidur = 0;
            }

            $properti_kantor->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        }

        if (isset($request->kamar_mandi)) {
            if (!isset($request->min_kamar_mandi)) {
                $request->min_kamar_mandi = 0;
            }
            
            $properti_kantor->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        }

        if (isset($request->luas_tanah)) {
            if (!isset($request->min_luas_tanah)) {
                $request->min_luas_tanah = 0;
            }

            $properti_kantor->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        }

        if (isset($request->luas_bangunan)) {
            if (!isset($request->min_luas_bangunan)) {
                $request->min_luas_bangunan = 0;
            }

            $properti_kantor->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        }

        $properti_kantor->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                  ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        });
        
        $properti_usaha = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 5)->where('tayang', 1);
        if (isset($request->kamar_tidur)) {
            if (!isset($request->min_kamar_tidur)){
                $request->min_kamar_tidur = 0;
            }

            $properti_usaha->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        }

        if (isset($request->kamar_mandi)) {
            if (!isset($request->min_kamar_mandi)) {
                $request->min_kamar_mandi = 0;
            }
            
            $properti_usaha->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        }

        if (isset($request->luas_tanah)) {
            if (!isset($request->min_luas_tanah)) {
                $request->min_luas_tanah = 0;
            }

            $properti_usaha->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        }

        if (isset($request->luas_bangunan)) {
            if (!isset($request->min_luas_bangunan)) {
                $request->min_luas_bangunan = 0;
            }

            $properti_usaha->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        }

        $properti_usaha->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                  ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        });

        $properti_apartemen = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 6)->where('tayang', 1);
        if (isset($request->kamar_tidur)) {
            if (!isset($request->min_kamar_tidur)){
                $request->min_kamar_tidur = 0;
            }

            $properti_apartemen->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        }

        if (isset($request->kamar_mandi)) {
            if (!isset($request->min_kamar_mandi)) {
                $request->min_kamar_mandi = 0;
            }
            
            $properti_apartemen->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        }

        if (isset($request->luas_tanah)) {
            if (!isset($request->min_luas_tanah)) {
                $request->min_luas_tanah = 0;
            }

            $properti_apartemen->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        }

        if (isset($request->luas_bangunan)) {
            if (!isset($request->min_luas_bangunan)) {
                $request->min_luas_bangunan = 0;
            }

            $properti_apartemen->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        }

        $properti_apartemen->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                  ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        });

        $properti_ruko = \App\Models\properti::with('pengguna')->where('jenis', 1)->where('category_id', 7)->where('tayang', 1);
        if (isset($request->kamar_tidur)) {
            if (!isset($request->min_kamar_tidur)){
                $request->min_kamar_tidur = 0;
            }

            $properti_ruko->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        }

        if (isset($request->kamar_mandi)) {
            if (!isset($request->min_kamar_mandi)) {
                $request->min_kamar_mandi = 0;
            }
            
            $properti_ruko->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        }

        if (isset($request->luas_tanah)) {
            if (!isset($request->min_luas_tanah)) {
                $request->min_luas_tanah = 0;
            }

            $properti_ruko->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        }

        if (isset($request->luas_bangunan)) {
            if (!isset($request->min_luas_bangunan)) {
                $request->min_luas_bangunan = 0;
            }

            $properti_ruko->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        }

        $properti_ruko->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                  ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        });

    return response()->json([
        'status' => 'sukses',
        'rumah' => $properti->paginate(10),
        'resedensial' => $properti_res->paginate(10),
        'tanah' => $properti_tanah->paginate(10),
        'kantor' => $properti_kantor->paginate(10),
        'usaha' => $properti_usaha->paginate(10),
        'apartemen' => $properti_apartemen->paginate(10),
        'ruko' => $properti_ruko->paginate(10),
    ], 200);

    }

    public function filterSewa (Request $request) {
        if (!isset($request->harga_minimal)) {
            $request->harga_minimal = 0;
        }

        if (!isset($request->harga_maksimal)) {
            $request->harga_maksimal = 99999999999999;
        }

        if (!isset($request->kamar_tidur)){
            $request->kamar_tidur = 0;
        }

        if (!isset($request->kamar_mandi)){
            $request->kamar_mandi = 0;
        }

        if (!isset($request->luas_tanah)){
            $request->luas_tanah = 0;
        }

        if (!isset($request->luas_bangunan)){
            $request->luas_bangunan = 0;
        }

        if (!isset($request->min_kamar_tidur)){
            $request->min_kamar_tidur = 0;
        }

        if (!isset($request->min_kamar_mandi)){
            $request->min_kamar_mandi = 0;
        }

        if (!isset($request->min_luas_tanah)){
            $request->min_luas_tanah = 0;
        }

        if (!isset($request->min_luas_bangunan)){
            $request->min_luas_bangunan = 0;
        }

        $min = $request->harga_minimal;
        $max = $request->harga_maksimal;
        $kt = $request->kamar_tidur;
        $km = $request->kamar_mandi;
        $lt = $request->luas_tanah;
        $lb = $request->luas_bangunan;

        $keyword = $request->keyword;
        $properti = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 1)->where('tayang', 1)
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        })
        ->where(function ($query) use ($keyword, $request){
            $query
                    ->where('harga', '>', $request->harga_minimal)
                    ->where('harga', '<', $request->harga_maksimal);
                })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_res = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 2)->where('tayang', 1)
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        })
        ->where(function ($query) use ($keyword, $request){
            $query
                    ->where('harga', '>', $request->harga_minimal)
                    ->where('harga', '<', $request->harga_maksimal);
                })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);
        
        $properti_tanah = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 3)->where('tayang', 1)
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        })
        ->where(function ($query) use ($keyword, $request){
            $query
                    ->where('harga', '>', $request->harga_minimal)
                    ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_kantor = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 4)->where('tayang', 1)
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        })
        ->where(function ($query) use ($keyword, $request){
            $query
                    ->where('harga', '>', $request->harga_minimal)
                    ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);
        
        $properti_usaha = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 5)->where('tayang', 1)
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->where('harga', '>', $request->harga_minimal)
                ->where('harga', '<', $request->harga_maksimal);
        })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_apartemen = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 6)->where('tayang', 1)
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        })
        ->where(function ($query) use ($keyword, $request){
            $query
                    ->where('harga', '>', $request->harga_minimal)
                    ->where('harga', '<', $request->harga_maksimal);
                })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        $properti_ruko = \App\Models\properti::with('pengguna')->where('jenis', 0)->where('category_id', 7)->where('tayang', 1)
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_tidur', '>=', $request->min_kamar_tidur)->where('kamar_tidur', '<=', $request->kamar_tidur);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('kamar_mandi', '>=', $request->min_kamar_mandi)->where('kamar_mandi', '<=', $request->kamar_mandi);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_tanah', '>=', $request->min_luas_tanah)->where('luas_tanah', '<=', $request->luas_tanah);
        })
        ->where(function ($query) use ($keyword, $request) {
            $query->where('luas_bangunan', '>=', $request->min_luas_bangunan)->where('luas_bangunan', '<=', $request->luas_bangunan);
        })
        ->where(function ($query) use ($keyword, $request){
            $query
                    ->where('harga', '>', $request->harga_minimal)
                    ->where('harga', '<', $request->harga_maksimal);
                })
        ->where(function ($query) use ($keyword, $request){
            $query->orWhere('nama', $keyword)
                  ->orWhere('provinsi', $keyword)
                  ->orWhere('kabupaten', $keyword)
                  ->orWhere('kecamatan', $keyword);
        })
        ->paginate(10);

        return response()->json([
            'status' => 'sukses',
            'rumah' => $properti,
            'resedensial' => $properti_res,
            'tanah' => $properti_tanah,
            'kantor' => $properti_kantor,
            'usaha' => $properti_usaha,
            'apartemen' => $properti_apartemen,
            'ruko' => $properti_ruko,
        ], 200);
    }

    public function findFav (Request $request) {
        $data = \App\Models\favorite::where('users_id', $request->users_id)->where('properti_id', $request->properti_id)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'sukses',
                'data' => false
            ], 200);
        }
        return response()->json([
            'status' => 'sukses',
            'data' => true
        ], 200);
    }

    public function findUs (Request $request) {
        $data = \App\Models\agenf::where('user_id', $request->user_id)->where('agen_id', $request->agen_id)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'sukses',
                'data' => false
            ], 200);
        }

        return response()->json([
            'status' => 'sukses',
            'data' => true
        ], 200);
    }

    public function informasi () {
        $informasi = \App\Models\informasi::all();
        return response ()->json([
            'status'    => 'sukses',
            'data'  => $informasi
        ]);
    }

    public function kelola (Request $request) {
        $data = \App\Models\properti::where('user_id', $request->user_id)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, properti tidak ditemukan'
            ], 404);
        }
        $current = date('Y-m-d H:i:s');
        $data_aktif = \App\Models\properti::with('pengguna')->where('user_id', $request->user_id)->where('exp', '>', $current)->get();
        $data_no = \App\Models\properti::with('pengguna')->where('user_id', $request->user_id)->where('exp', '<', $current)->get();
        $data_no_2 = \App\Models\properti::with('pengguna')->where('user_id', $request->user_id)->where('exp', null)->get();
        $final = Arr::collapse([$data_no, $data_no_2]);
        $finals = Arr::collapse([$final, $data_aktif]);
        $status_1 = ['aktif' => 0];
        foreach ($final as $finally) {
            $finally['aktif'] = 0;
        }
        foreach ($data_aktif as $data) {
            $data['aktif'] = 1;
        }
        return response()->json([
            'status' => 'sukses',
            'data' => [ 'aktif' => $data_aktif, 
                        'nonaktif' => $final,
                        'semua' => $finals
            ]
        ], 200);
    }

    public function verification (Request $request, $id) {
        $data = \App\Models\User::find($id)->where('activation_code', $request->activation_code)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, kode OTP yang anda masukkan salah'
            ], 400);
        }
        \App\Models\User::where('id',$id)->update([
            'isVerified' => 1
        ]);
        return response()->json([
            'status' => 'sukses',
            'data' => 'Sukses! verifikasi berhasil'
        ], 200);
    }

    public function voucher (Request $request) {
        $data = \App\Models\voucher::where('voucher', $request->voucher)->get();
        $use = \App\Models\voucher_usage::where('users_id', $request->user_id)->where('voucher', $request->voucher)->get();
       
        if (!isset($data[0])){
            return response()->json([
                'status' => 'gagal',
                'data' => 'Maaf! voucher tidak ditemukan',
            ], 404);
        }

        $datas = \App\Models\voucher::where('voucher', $request->voucher)->get('voucher');
        $uses = \App\Models\voucher_usage::where('users_id', $request->user_id)->where('voucher', $datas[0]->voucher)->get();
        $die = count($uses);

        if ($die > 9) {
            \App\Models\voucher::where('voucher', $request->voucher)->delete();
            \App\Models\voucher_usage::where('voucher', $request->voucher)->delete();
            return response()->json([
                'status' => 'error',
                'data'  => 'Gagal! maaf voucher anda sudah kadaluwarsa'
            ], 400);
        }
      
        if ($data[0]->continuous == 2) {
            if ($data[0]->durasi == 1) {
                $date = date('Y-m-d H:i:s', strtotime('+1 month'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
            if ($data[0]->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
            if ($data[0]->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
        }

        if (isset($use[0]->voucher)) {
            return response()->json([
                'status' => 'gagal',
                'data' => 'Maaf! anda telah menggunakan voucher ini',
            ], 400);
        }

        if ($data[0]->expiry_date == null) {
            if ($data[0]->durasi == 1) {
                $date = date('Y-m-d H:i:s', strtotime('+1 month'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher::where('voucher', $request->voucher)->delete();
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
            
            if ($data[0]->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher::where('voucher', $request->voucher)->delete();
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
            if ($data[0]->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher::where('voucher', $request->voucher)->delete();
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
        }

        if ($data[0]->expiry_date !== null) {
            if ($data[0]->durasi == 1) {
                $date = date('Y-m-d H:i:s', strtotime('+1 month'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
            
            if ($data[0]->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }

            if ($data[0]->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                \App\Models\properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);
                \App\Models\voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ], 200);
            }
        }
        $current = date('Y-m-d H:i:s');
        return response()->json([
            'status' => 'gagal',
            'data' => 'Maaf! voucher tidak valid',
        ], 400);
    } 

    public function forgotPass (Request $request) {
        $data = $request->no_telp;
        $user = \App\Models\User::where('no_telp', $data)->get();
        if (!isset($user[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }

        if ($user[0]->isVerified == 0) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, akun anda belum terverifikasi'
            ], 403);
        }
        $kode = substr(str_shuffle(123456789), 0, 6);
        $client = new Client(['base_uri' => 'https://sendtalk-api.taptalk.io']);
        $response = $client->request('POST', '/api/v1/message/send_whatsapp', [
            'headers' => [
                'Content-Type' => 'application/json',
                'API-Key' => '1811c01c2cf1baac13e5df4162fa8721d5f02bdbab2b3d722f639b7f7fb8bdfe'
            ],
            'json' => [
            'phone' => $request->no_telp,
            'messageType' => "otp",
            'body' => "Masukkan kode dibawah ini untuk mengatur ulang kata sandi akun LANDPRO Anda.\n\n".$kode."\n\nJangan berikan kode ini kepada siapapun.",
        ]]);
        \App\Models\User::where('no_telp', $data)->update([
            'activation_code' => $kode
        ]);
        return response()->json([
            'status' => 'sukses',
            'data' => $user
        ], 200);
    }

    public function forgotPassVer (Request $request, $id) {
        $data = \App\Models\User::where('id', $id)->get();
        if ($data[0]->activation_code != $request->activation_code) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, kode yang anda masukkan salah'
            ], 400);
        }
        if ($data[0]->activation_code == $request->activation_code) {
            return response()->json([
                'status' => 'sukses',
                'data' => $data
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'data' => 'Maaf, kode OTP anda tidak valid'
        ], 400);
    }

    public function forgotPassVerPass (Request $request, $id) {
        $data = \App\Models\User::where('id', $id)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'sukses',
            'data' => 'Sukses! password anda telah dirubah'
        ], 200);
    }

    public function editProperti (Request $request, $id) {
        $data = \App\Models\properti::where('id', $id)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'error',
                'data'  => 'Maaf, data tidak valid'
            ], 400);
        }
        
        $cek_kategori = "$request->category_id";

        if ($cek_kategori == 1) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if($files=$request->file('foto_tampak_lain')){
                foreach($files as $file){
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/rumah/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/rumah/'.implode('|public/uploads/properti/rumah/', $foto_tampak_lain);

            $post = \App\Models\properti::where('id', $id)->update([
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
            return response()->json([
                'status' => 'sukses',
                'data' => 'properti berhasil diupdate',
            ], 200);
        }
        if ($cek_kategori == 2) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if($files=$request->file('foto_tampak_lain')){
                foreach($files as $file){
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/resedensial/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }
            $ftl = 'public/uploads/properti/resedensial/'.implode('|public/uploads/properti/resedensial/', $foto_tampak_lain);

            $post = \App\Models\properti::where('id', $id)->update([
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
            return response()->json([
                'status' => 'sukses',
                'data' => 'properti berhasil diupdate'
            ], 200);
        }
        if ($cek_kategori == 3) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if($files=$request->file('foto_tampak_lain')){
                    foreach($files as $file){
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/tanah/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }
                $ftl = 'public/uploads/properti/tanah/'.implode('|public/uploads/properti/tanah/', $foto_tampak_lain);

                $post = \App\Models\properti::where('id', $id)->update([
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
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'properti berhasil diupdate'
                ], 200);
            }
            if ($cek_kategori == 4) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if($files=$request->file('foto_tampak_lain')){
                    foreach($files as $file){
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/kantor/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }
                $ftl = 'public/uploads/properti/kantor/'.implode('|public/uploads/properti/kantor/', $foto_tampak_lain);

                $post = \App\Models\properti::where('id', $id)->update([
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
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'properti berhasil diupdate'
                ], 200);
            }
            if ($cek_kategori == 5) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if($files=$request->file('foto_tampak_lain')){
                    foreach($files as $file){
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/ruang/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }
                $ftl = 'public/uploads/properti/ruang/'.implode('|public/uploads/properti/ruang/', $foto_tampak_lain);

                $post = \App\Models\properti::where('id', $id)->update([
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
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'properti berhasil diupdate'
                ], 200);
            }
            if ($cek_kategori == 6) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if($files=$request->file('foto_tampak_lain')){
                    foreach($files as $file){
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/apartemen/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }
                $ftl = 'public/uploads/properti/apartemen/'.implode('|public/uploads/properti/apartemen/', $foto_tampak_lain);
                $post = \App\Models\properti::where('id', $id)->update([
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
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'properti berhasil diupdate'
                ], 200);
            }

            if ($cek_kategori == 7) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if($files=$request->file('foto_tampak_lain')){
                    foreach($files as $file){
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/ruko/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }
                $ftl = 'public/uploads/properti/ruko/'.implode('|public/uploads/properti/ruko/', $foto_tampak_lain);

                $post = \App\Models\properti::where('id', $id)->update([
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
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'properti berhasil diupdate'
                ], 200);
            }
    }

    public function pesanWa () {
        $data = \App\Models\message::all();
        return response()->json($data);
    }

    public function deleteProperti ($id) {
        $checker = \App\Models\favorite::where('properti_id', $id)->get();

        if (isset($checker[0])) {
            \App\Models\favorite::where('properti_id', $id)->delete();
        }

        \App\Models\properti::withTrashed()->find($id)->delete();
        \App\Models\properti::withTrashed()->find($id)->forceDelete();
        return response()->json([
            'status' => 'sukses',
            'data'  => 'Properti berhasil dihapus'
        ], 200);
    }

    public function customerServices () {
        $data = \App\Models\User::where('role', 1)->get('no_telp');
        return response()->json([
            'status' => 'sukses',
            'data'  => $data
        ]);
    }

    public function tambahPropertiPost (Request $request) {
        $access = \App\Models\properti::with('pengguna')->where('tayang', 0)->where('user_id', $request->user_id)->get();
        $g_access = count($access);

        $validation = Validator::make($request->all(), [
            'harga_uang_muka' => ['nullable', 'numeric']
        ]);

        if ($validation->fails()) {
            return response()->json($validation->messages());
        }

        if ($g_access >= 5) {
            return response()->json([
                'status' => 'gagal',
                'data' => 'Maaf permintaan ditolak, silahkan tayangkan terlebih dahulu properti anda sebelumnya.'
            ], 403);
            
        } else {

            $cek_kategori = "$request->category_id";

            if ($cek_kategori == 1) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if($files=$request->file('foto_tampak_lain')){
                    foreach($files as $file){
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/rumah/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }

                $ftl = 'public/uploads/properti/rumah/'.implode('|public/uploads/properti/rumah/', $foto_tampak_lain);

                $post = \App\Models\properti::create([
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
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'properti berhasil ditambahkan',
                ], 200);
            }
            if ($cek_kategori == 2) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if($files=$request->file('foto_tampak_lain')){
                    foreach($files as $file){
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/resedensial/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }
                $ftl = 'public/uploads/properti/resedensial/'.implode('|public/uploads/properti/resedensial/', $foto_tampak_lain);

                $post = \App\Models\properti::create([
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
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'properti berhasil ditambahkan'
                ], 200);
            }
            if ($cek_kategori == 3) {
                    $gambar_1 = $request->foto_tampak_depan;
                    $gambar_1_final = time().$gambar_1->getClientOriginalName();
                    $gambar_2 = $request->foto_tampak_jalan;
                    $gambar_2_final = time().$gambar_2->getClientOriginalName();
                    $gambar_3 = $request->foto_tampak_ruangan;
                    $gambar_3_final = time().$gambar_3->getClientOriginalName();
                    $foto_tampak_lain = array ();
                    if($files=$request->file('foto_tampak_lain')){
                        foreach($files as $file){
                            $name=time().$file->getClientOriginalName();
                            $file->move('public/uploads/properti/tanah/', $name);
                            $foto_tampak_lain[]=$name;
                        }
                    }
                    $ftl = 'public/uploads/properti/tanah/'.implode('|public/uploads/properti/tanah/', $foto_tampak_lain);

                    $post = \App\Models\properti::create([
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
                    return response()->json([
                        'status' => 'sukses',
                        'data' => 'properti berhasil ditambahkan'
                    ], 200);
                }
                if ($cek_kategori == 4) {
                    $gambar_1 = $request->foto_tampak_depan;
                    $gambar_1_final = time().$gambar_1->getClientOriginalName();
                    $gambar_2 = $request->foto_tampak_jalan;
                    $gambar_2_final = time().$gambar_2->getClientOriginalName();
                    $gambar_3 = $request->foto_tampak_ruangan;
                    $gambar_3_final = time().$gambar_3->getClientOriginalName();
                    $foto_tampak_lain = array ();
                    if($files=$request->file('foto_tampak_lain')){
                        foreach($files as $file){
                            $name=time().$file->getClientOriginalName();
                            $file->move('public/uploads/properti/kantor/', $name);
                            $foto_tampak_lain[]=$name;
                        }
                    }
                    $ftl = 'public/uploads/properti/kantor/'.implode('|public/uploads/properti/kantor/', $foto_tampak_lain);

                    $post = \App\Models\properti::create([
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
                    return response()->json([
                        'status' => 'sukses',
                        'data' => 'properti berhasil ditambahkan'
                    ], 200);
                }
                if ($cek_kategori == 5) {
                    $gambar_1 = $request->foto_tampak_depan;
                    $gambar_1_final = time().$gambar_1->getClientOriginalName();
                    $gambar_2 = $request->foto_tampak_jalan;
                    $gambar_2_final = time().$gambar_2->getClientOriginalName();
                    $gambar_3 = $request->foto_tampak_ruangan;
                    $gambar_3_final = time().$gambar_3->getClientOriginalName();
                    $foto_tampak_lain = array ();
                    if($files=$request->file('foto_tampak_lain')){
                        foreach($files as $file){
                            $name=time().$file->getClientOriginalName();
                            $file->move('public/uploads/properti/ruang/', $name);
                            $foto_tampak_lain[]=$name;
                        }
                    }
                    $ftl = 'public/uploads/properti/ruang/'.implode('|public/uploads/properti/ruang/', $foto_tampak_lain);

                    $post = \App\Models\properti::create([
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
                    return response()->json([
                        'status' => 'sukses',
                        'data' => 'properti berhasil ditambahkan'
                    ], 200);
                }
                if ($cek_kategori == 6) {
                    $gambar_1 = $request->foto_tampak_depan;
                    $gambar_1_final = time().$gambar_1->getClientOriginalName();
                    $gambar_2 = $request->foto_tampak_jalan;
                    $gambar_2_final = time().$gambar_2->getClientOriginalName();
                    $gambar_3 = $request->foto_tampak_ruangan;
                    $gambar_3_final = time().$gambar_3->getClientOriginalName();
                    $foto_tampak_lain = array ();
                    if($files=$request->file('foto_tampak_lain')){
                        foreach($files as $file){
                            $name=time().$file->getClientOriginalName();
                            $file->move('public/uploads/properti/apartemen/', $name);
                            $foto_tampak_lain[]=$name;
                        }
                    }
                    $ftl = 'public/uploads/properti/apartemen/'.implode('|public/uploads/properti/apartemen/', $foto_tampak_lain);

                    $post = \App\Models\properti::create([
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
                    return response()->json([
                        'status' => 'sukses',
                        'data' => 'properti berhasil ditambahkan'
                    ], 200);
                }
                if ($cek_kategori == 7) {
                    $gambar_1 = $request->foto_tampak_depan;
                    $gambar_1_final = time().$gambar_1->getClientOriginalName();
                    $gambar_2 = $request->foto_tampak_jalan;
                    $gambar_2_final = time().$gambar_2->getClientOriginalName();
                    $gambar_3 = $request->foto_tampak_ruangan;
                    $gambar_3_final = time().$gambar_3->getClientOriginalName();
                    $foto_tampak_lain = array ();
                    if($files=$request->file('foto_tampak_lain')){
                        foreach($files as $file){
                            $name=time().$file->getClientOriginalName();
                            $file->move('public/uploads/properti/ruko/', $name);
                            $foto_tampak_lain[]=$name;
                        }
                    }
                    $ftl = 'public/uploads/properti/ruko/'.implode('|public/uploads/properti/ruko/', $foto_tampak_lain);

                    $post = \App\Models\properti::create([
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
                    return response()->json([
                        'status' => 'sukses',
                        'data' => 'properti berhasil ditambahkan'
                    ], 200);
                }
            }
    }
}
