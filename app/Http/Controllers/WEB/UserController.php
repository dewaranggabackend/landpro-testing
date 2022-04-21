<?php

namespace App\Http\Controllers\WEB;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\agenf;
use App\Models\favorite;
use App\Models\properti;
use App\Models\role;
use App\Models\User;
use App\Models\voucher_usage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function lupaPasswordSet (Request $request, $id) {
        $user = User::find($id);
        $code_1 = "$user->activation_code";
        $aktivasi = "$request->activation_code";
        if ($code_1 != $aktivasi) {
            return redirect('register')->with('error', 'Maaf, kode OTP yang anda masukkan salah');
        }

        $user = User::find($id);
        return view ('auth.forgot_password_set', compact('user'));
    }

    public function lupaPasswordSetPassword (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect('login')->with('error', 'Maaf, password yang anda masukkan tidak valid. (ket: minimal 8 karakter)');
        }

        $user = User::find($id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect('login')->with('sukses', 'Sukses! password berhasil diubah');
    }

    public function verificationOTP (Request $request, $id) {
        $user = User::find($id);
        $code_1 = "$user->activation_code";
        $aktivasi = "$request->activation_code";
        if ($code_1 != $aktivasi) {
            return redirect('register');
        }

        User::find($id)->update([
            'isVerified' => 1
        ]);

        return redirect ('login')->with('sukses', 'Anda berhasil terdaftar');
    }

    public function users () {
        $user = User::paginate(20);
        $role = role::all();
        return view ('admin.user', compact('user', 'role'));
    }

    public function requestSearch (Request $request) {
        $data = $request->cari;
        $result = \App\Models\request::where('id',$data)->get();
        return view ('admin.request_search', compact('result'));
    }

    public function request () {
        $request = \App\Models\request::paginate(20);
        return view ('admin.request', compact ('request'));
    }

    public function userExcel () {
        return Excel::download(new UserExport, 'user_all.xlsx');
    }

    public function usersSearch (Request $request) {
        $data = $request->cari;
        $result = User::where('name', 'LIKE', '%'.$data.'%')->orWhere('email', 'LIKE', '%'.$data.'%')->orWhere('no_telp', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.user_search', compact('result'));
    }

    public function viewban () {
        $banned_users = User::onlyTrashed()->paginate(20);
        return view ('admin.ban', ['banned_users' => $banned_users]);
    }

    public function bannedSearch (Request $request) {
        $data = $request->cari;
        $result = User::onlyTrashed()->where('id', $data)->paginate(20);
        return view ('admin.ban_search', compact('result'));
    }

    public function banned ($id) {
        $akun = User::find($id);
        agenf::where('agen_id', $id)->delete();
        $akun->delete();

        return redirect ('/users')->with('sukses', 'Sukses! akun berhasil di banned!');
    }

    public function unban ($id) {
        $user = User::withTrashed()->find($id);
        $user->restore();
        return redirect ('/users')->with('sukses', 'Sukses! akun berhasil dipulihkan.');
    }

    public function upgrade ($id) {
        $user = User::find($id);

        if ($user->role == 2) {
            return redirect ('/users')->with('gagal', 'Gagal! akun sudah menjadi agen.');
        } else {
            $data = ['role' => 2];
            $user->update($data);

            return redirect ('/users')->with('sukses', 'Sukses! akun berhasil diupgrade.');
        }
    }

    public function downgrade ($id) {
        $user = User::find($id);

        if ($user->role == 3) {
            return redirect ('/users')->with('gagal', 'Gagal! akun sudah menjadi pencari.');
        } else {
            $data = ['role' => 3];
            $user->update($data);

            return redirect ('/users')->with('sukses', 'Sukses! akun berhasil didowngrade.');
        }
    }

    public function hapus ($id) {
        $user = User::withTrashed()->find($id);
        properti::where('user_id', $id)->delete();
        favorite::where('users_id', $id)->delete();
        agenf::where('user_id', $id)->orWhere('agen_id', $id)->delete();
        voucher_usage::where('users_id', $id)->delete();

        $user->forceDelete();

        return redirect ('/users/banned')->with('sukses', 'Sukses! akun berhasil dihapus permanen.');
    }

    public function tolakRequest ($id) {
        $request = \App\Models\request::find($id);
        $request->delete();
        return redirect ('users/request')->with('sukses', 'sukses! permohonan berhasil ditolak');
    }

    public function setujuRequest ($id) {
        $data = \App\Models\request::find($id);
        $user_id = $data->users_id;
        $request = User::find($user_id);
        $request->update([
            'role' => 2,
        ]);
        $data->delete();
        return redirect ('users/request')->with('sukses', 'sukses! permohonan berhasil disetujui');
    }

    public function custServForm () {
        return view ('admin.user_form');
    }

    public function custServPost(Request $request) {
        $this->validate($request, [
            'email' => ['required', 'email', 'unique:users,email'],
            'whatsapp' => ['required', 'unique:users,no_telp']
        ]);

        $request['password'] = Hash::make($request['password']);

        User::create([
            'name' => $request['nama'],
            'email' => $request['email'],
            'no_telp' => $request['whatsapp'],
            'role' => 1,
            'password' => $request['password'],
            'isVerified' => 1
        ]);

        return redirect('users')->with('sukses', 'Sukses! Customer Service berhasil dibuat.');
    }

    public function delCustServ($id) {
        User::find($id)->forceDelete();

        return redirect('users')->with('sukses', 'Sukses! Customer Service berhasil dihapus.');
    }
}
