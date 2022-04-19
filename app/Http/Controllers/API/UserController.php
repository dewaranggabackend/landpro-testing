<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\agenf;
use App\Models\properti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profileUsers ($id) {
        $user = User::where('id', $id)->get();
        if (!isset($user[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ]);
        }

        $properti = properti::with('pengguna')->where('user_id', $id)->where('tayang', 1)->get();
        return response()->json([
            'status' => 'status',
            'profile' => $user,
            'data' => $properti,
        ]);
    }

    public function verification (Request $request, $id) {
        $data = User::find($id)->where('activation_code', $request->activation_code)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, kode OTP yang anda masukkan salah'
            ], 400);
        }

        User::where('id',$id)->update([
            'isVerified' => 1
        ]);

        return response()->json([
            'status' => 'sukses',
            'data' => 'Sukses! verifikasi berhasil'
        ]);
    }

    public function request (Request $request) {
        $data = $request->users_id;
        $find_id = \App\Models\request::where('users_id', $data)->get();
        $result = isset($find_id[0]);
        if ($result === true) {
            return response()->json([
                'status' => 'error',
                'data' => 'maaf, request anda sebelumnya sudah ada didalam database'
            ], 409);

        } else {
            \App\Models\request::create($request->all());
            return response()->json([
                'status' => 'sukses',
                'data' => 'sukses! request anda berhasil dikirim'
            ]);
        }
    }

    public function avatar (Request $request) {
        $user = User::where('id', $request->user_id);
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
        ]);
    }

    public function gantiPassword (Request $request) {
        $users = User::where('id', $request->id)->first();
        if (!isset ($users)) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ]);
        }

        if (Hash::check($request->password, $users->password)) {
            $user = User::where('id', $request->id);
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

    public function findUs (Request $request) {
        $data = agenf::where('user_id', $request->user_id)->where('agen_id', $request->agen_id)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'sukses',
                'data' => false
            ]);
        }

        return response()->json([
            'status' => 'sukses',
            'data' => true
        ]);
    }

    public function editProfile (Request $request) {
        $user = User::where('id', $request->user_id)->get();
        if (!isset($user[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }
        return response()->json($user);
    }

    public function editProfilePost (Request $request) {
        $user = User::where('id', $request->id)->first();
        if (!isset($user)) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }

        $nama = $request->nama;
        $no_telp = $request->no_telp;

        User::where('id', $request->id)->update([
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

        agenf::create($request->all());
        return response()->json([
            'status' => 'sukses'
        ], 200);
    }

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

        $data = agenf::where('user_id', $request->user_id)->where('agen_id', $request->agen_id);
        $data->delete();
        return response()->json([
            'status' => 'sukses'
        ], 200);
    }

    public function usersFavorite ($id) {
        $favorit = agenf::with('pengguna')->where('user_id', $id)->get();

        if (!isset($favorit[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, user tidak ditemukan'
            ], 404);
        }

        foreach ($favorit as $fav) {
            $hasil = (int) $fav->agen_id;
            $properti = properti::where('user_id', $hasil)->where('tayang', 1)->get();
            $propertis = properti::where('user_id', $hasil)->where('jenis', 0)->where('tayang', 1)->get();
            $propertiz = properti::where('user_id', $hasil)->where('jenis', 1)->where('tayang', 1)->get();
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
        ]);
    }
}
