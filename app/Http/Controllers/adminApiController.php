<?php

namespace App\Http\Controllers;

use App\Models\faq;
use App\Models\informasi;
use App\Models\message;
use App\Models\privacy;
use App\Models\properti;
use App\Models\setting_kategori;
use App\Models\syarat;
use App\Models\tentang;
use App\Models\User;
use App\Models\voucher;
use App\Models\voucher_usage;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Validator;

class adminApiController extends Controller
{
    public function gambar_kategori () {
        $gambar = setting_kategori::all();
        return response()->json([
            'status' => 'sukses',
            'data' => $gambar,
        ]);
    }

    public function privasi () {
        $privasi = privacy::where('id', 1)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $privasi
        ]);
    }

    public function syarat () {
        $syarat = syarat::where('id', 1)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $syarat
        ]);
    }

    public function tentang () {
        $tentang = tentang::where('id', 1)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $tentang
        ]);
    }

    public function faq () {
        $faq = faq::all();
        return response()->json([
            'status' => 'sukses',
            'data' => $faq
        ]);
    }

    public function faq_detail ($id) {
        $faq_detail = faq::where('id', $id)->get();
        return response()->json([
            'status' => 'sukses',
            'data' => $faq_detail
        ]);
    }

    public function informasi () {
        $informasi = informasi::all();
        return response ()->json([
            'status'    => 'sukses',
            'data'  => $informasi
        ]);
    }

    public function voucher (Request $request) {
        $data = voucher::where('voucher', $request->voucher)->get();
        $use = voucher_usage::where('users_id', $request->user_id)->where('voucher', $request->voucher)->get();

        if (!isset($data[0])){
            return response()->json([
                'status' => 'gagal',
                'data' => 'Maaf! voucher tidak ditemukan',
            ], 404);
        }

        $datas = voucher::where('voucher', $request->voucher)->get('voucher');
        $die = voucher_usage::where('users_id', $request->user_id)->where('voucher', $datas[0]->voucher)->count();

        if ($die > 9) {
            voucher::where('voucher', $request->voucher)->delete();
            voucher_usage::where('voucher', $request->voucher)->delete();

            return response()->json([
                'status' => 'error',
                'data'  => 'Gagal! maaf voucher anda sudah kadaluwarsa'
            ], 400);
        }

        if ($data[0]->continuous == 2) {
            if ($data[0]->durasi == 1) {
                $date = date('Y-m-d H:i:s', strtotime('+1 month'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);

                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }

            if ($data[0]->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);

                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }

            if ($data[0]->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher_usage::create([
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
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher::where('voucher', $request->voucher)->delete();
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }

            if ($data[0]->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher::where('voucher', $request->voucher)->delete();
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }
            if ($data[0]->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher::where('voucher', $request->voucher)->delete();
                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }
        }

        if ($data[0]->expiry_date !== null) {
            if ($data[0]->durasi == 1) {
                $date = date('Y-m-d H:i:s', strtotime('+1 month'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);

                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }

            if ($data[0]->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);

                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }

            if ($data[0]->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                properti::where('id', $request->properti_id)->update([
                    'tayang' => 1,
                    'exp' => $date
                ]);

                voucher_usage::create([
                    'users_id' => $request->user_id,
                    'voucher' => $request->voucher
                ]);

                return response()->json([
                    'status' => 'sukses',
                    'data' => 'Berhasil! voucher telah digunakan',
                ]);
            }
        }

        return response()->json([
            'status' => 'gagal',
            'data' => 'Maaf! voucher tidak valid',
        ], 400);
    }

    public function forgotPass (Request $request) {
        $data = $request->no_telp;
        $user = User::where('no_telp', $data)->get();
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
        $client->request('POST', '/api/v1/message/send_whatsapp', [
            'headers' => [
                'Content-Type' => 'application/json',
                'API-Key' => '1811c01c2cf1baac13e5df4162fa8721d5f02bdbab2b3d722f639b7f7fb8bdfe'
            ],
            'json' => [
            'phone' => $request->no_telp,
            'messageType' => "otp",
            'body' => "Masukkan kode dibawah ini untuk mengatur ulang kata sandi akun LANDPRO Anda.\n\n".$kode."\n\nJangan berikan kode ini kepada siapapun.",
        ]]);

        User::where('no_telp', $data)->update([
            'activation_code' => $kode
        ]);

        return response()->json([
            'status' => 'sukses',
            'data' => $user
        ]);
    }

    public function forgotPassVer (Request $request, $id) {
        $data = User::where('id', $id)->get();
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
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => 'Maaf, kode OTP anda tidak valid'
        ], 400);
    }

    public function forgotPassVerPass (Request $request, $id) {
        User::where('id', $id)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'sukses',
            'data' => 'Sukses! password anda telah dirubah'
        ]);
    }

    public function pesanWa () {
        $data = message::all();
        return response()->json($data);
    }

    public function customerServices () {
        $data = User::where('role', 1)->get('no_telp');

        return response()->json([
            'status' => 'sukses',
            'data'  => $data
        ]);
    }
}
