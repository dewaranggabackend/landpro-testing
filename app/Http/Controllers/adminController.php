<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\privacy;
use App\Models\properti;
use App\Models\syarat;
use App\Models\tentang;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Validator;
use Hash;

class adminController extends Controller
{
    public function category () {
        $category = category::all();
        return view ('admin.category', compact('category'));
    }

    public function requestOTP () {
        return view ('auth.request-otp');
    }

    public function requestOTPost (Request $request) {
        $data = User::where('no_telp', $request->no_telp)->get();
        if (!isset($data[0])) {
            return redirect ('request-otp')->with('error', 'Maaf, nomor yang anda masukkan tidak terdaftar');
        }

        if ($data[0]->isVerified == 1) {
            return redirect ('login')->with('error', 'Maaf, akun anda telah terverifikasi');
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
            'body' => "Masukkan kode 6 digit dibawah ini untuk verifikasi akun LANDPRO Anda.\n\n".$kode."\n\nJangan berikan kode ini kepada siapapun.",
        ]]);

        User::where('no_telp', $request->no_telp)->update([
            'activation_code' => $kode
        ]);
        return view ('auth.request-otp-validate', ['user' => $data[0]]);
    }

    public function requestOTPostVer (Request $request, $id) {
        $data = User::find($id);
        if ($data->activation_code == $request->activation_code) {
            User::where('id', $id)->update([
                'isVerified' => 1
            ]);

            return redirect ('login')->with('sukses', 'Akun anda berhasil diverifikasi');
        }

        return redirect('request-otp')->with('error', 'Maaf, kode OTP yang anda masukkan salah');
    }

    public function privacy () {
        $privacy = privacy::all();
        return view ('admin.privasi', ['privasi' => $privacy]);
    }

    public function privacyEdit ($id) {
        $privacy = privacy::where("id", $id)->get();
        return view ('admin.editprivasi', ['privasi' => $privacy]);
    }

    public function privacyPost (Request $request, $id) {
        $privacy = privacy::find($id);
        $privacy->update([
            'judul' => $request->judul,
            'isi' => $request->isi
        ]);

        privacy::all();
        return redirect ('privacy')->with('sukses', 'Sukses! kebijakan privasi berhasil diupdate.');
    }

    public function dashboard () {
        $current = date('Y-m-d H:i:s');
        $user = User::count();
        $banned_user = User::onlyTrashed()->count();
        $properti = properti::where('exp', '>', $current)->orWhere('exp', null)->count();
        $properti_rumah = properti::where('category_id', 1)->count();
        $properti_resedensial = properti::where('category_id', 2)->count();
        $properti_tanah = properti::where('category_id', 3)->count();
        $properti_kantor = properti::where('category_id', 4)->count();
        $properti_ruang = properti::where('category_id', 5)->count();
        $properti_apartemen = properti::where('category_id', 6)->count();
        $properti_ruko = properti::where('category_id', 7)->count();
        $agen = User::where('role', 2)->count();
        $pencari = User::where('role', 3)->count();
        $off_properti = properti::onlyTrashed()->count();
        $seven = User::where('created_at', '<=', Carbon::now()->subDays(7)->toDateTimeString())->count();
        $six = User::where('created_at', '<=', Carbon::now()->subDays(6)->toDateTimeString())->count();
        $five = User::where('created_at', '<=', Carbon::now()->subDays(5)->toDateTimeString())->count();
        $four = User::where('created_at', '<=', Carbon::now()->subDays(4)->toDateTimeString())->count();
        $three = User::where('created_at', '<=', Carbon::now()->subDays(3)->toDateTimeString())->count();
        $two = User::where('created_at', '<=', Carbon::now()->subDays(2)->toDateTimeString())->count();
        $one = User::where('created_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->count();

        return view ('admin.dashboard', compact('user', 'banned_user', 'properti', 'off_properti', 'properti_rumah',
        'properti_resedensial', 'properti_tanah', 'properti_kantor', 'properti_ruang', 'properti_apartemen', 'properti_ruko',
        'agen', 'pencari', 'seven', 'six', 'five', 'four', 'three', 'two', 'one'));
    }

    public function syarat () {
        $syarat = syarat::all();
        return view ('admin.syarat', compact('syarat'));
    }

    public function editSyarat ($id) {
        $syarat = syarat::where("id", $id)->get();
        return view ('admin.editsyarat', ['syarat' => $syarat]);
    }

    public function syaratPost (Request $request, $id) {
        $syarat = syarat::find($id);
        $syarat->update($request->all());
        return redirect ('syarat')->with('sukses', 'Sukses! syarat penggunaan berhasil diupdate.');
    }

    public function tentang () {
        $tentang = tentang::all();
        return view ('admin.tentang', compact('tentang'));
    }

    public function tentangEdit ($id) {
        $tentang = tentang::where("id",$id)->get();
        return view ('admin.edit_tentang', compact('tentang'));
    }

    public function tentangPost (Request $request, $id) {
        $tentang = tentang::find($id);
        $tentang->update($request->all());
        return redirect ('tentang')->with('sukses', 'Sukses! informasi berhasil diupdate.');
    }

    public function sorry () {
        return view ('admin.sorry');
    }

    public function lupaPassword () {
        return view ('auth.forgot_password');
    }

    public function lupaPasswordPost (Request $request) {
        $user = User::where('no_telp', $request->no_telp)->get();

        if (!isset($user[0])) {
            return redirect ('register');
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

        User::where('no_telp', $request->no_telp)->update([
            'activation_code' => $kode
        ]);

        return view ('auth.forgot_password_change', ['user' => $user[0]]);
    }
}
