<?php

namespace App\Http\Controllers;

use App\Exports\PropertiExport;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Validator;
use Hash;

class adminController extends Controller
{
    public function category () {
        $category = \App\Models\category::all();
        return view ('admin.category', compact('category'));
    }

    public function requestOTP () {
        return view ('auth.request-otp');
    }

    public function propertiExcel () {
        return Excel::download(new PropertiExport, 'properti_all.xlsx');
    }

    public function userExcel () {
        return Excel::download(new UserExport, 'user_all.xlsx');
    }

    public function requestOTPost (Request $request) {
        $data = \App\Models\User::where('no_telp', $request->no_telp)->get();
        if (!isset($data[0])) {
            return redirect ('request-otp')->with('error', 'Maaf, nomor yang anda masukkan tidak terdaftar');
        }
        if ($data[0]->isVerified == 1) {
            return redirect ('login')->with('error', 'Maaf, akun anda telah terverifikasi');
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
            'body' => "Masukkan kode 6 digit dibawah ini untuk verifikasi akun LANDPRO Anda.\n\n".$kode."\n\nJangan berikan kode ini kepada siapapun.",
        ]]);
        \App\Models\User::where('no_telp', $request->no_telp)->update([
            'activation_code' => $kode
        ]);
        return view ('auth.request-otp-validate', ['user' => $data[0]]);
    }

    public function requestOTPostVer (Request $request, $id) {
        $data = \App\Models\User::find($id);
        if ($data->activation_code == $request->activation_code) {
            \App\Models\User::where('id', $id)->update([
                'isVerified' => 1
            ]);
            return redirect ('login')->with('sukses', 'Akun anda berhasil diverifikasi');
        }
        return redirect('request-otp')->with('error', 'Maaf, kode OTP yang anda masukkan salah');
    }

    public function fresh () {
        $current = date('Y-m-d H:i:s');
        $voucher = \App\Models\properti::where('exp', '<', $current);
        $voucher->update([
            'tayang' => 0,
        ]);
        return redirect ('properti/expire')->with('sukses', 'sukses! data properti berhasil diupdate');
    }

    public function properti () {
        $current = date('Y-m-d H:i:s');
        $properties = \App\Models\properti::where('exp', '>', $current)->orWhere('exp', null)->paginate(20);
        return view ('admin.properti', ['properties' => $properties]);
    }

    public function propertiExpire () {
        $current = date('Y-m-d H:i:s');
        $properties = \App\Models\properti::where('exp', '<', $current)->paginate(20);
        return view ('admin.properti_expire', ['properties' => $properties]);
    }

    public function propertiStop ($id) {
        $data = \App\Models\properti::find($id);
        $data->update([
            'tayang' => 0,
            'exp' => null
        ]);
        return redirect('properti/expire')->with('sukses', 'sukses! penayangan berhasil di stop');
    }

    public function users () {
        $user = \App\Models\User::paginate(20);
        $role = \App\Models\role::all();
        return view ('admin.user', compact('user', 'role'));
    }

    public function banned ($id) {
        $akun = \App\Models\User::find($id);
        $akuns = \App\Models\agenf::where('agen_id', $id)->delete();
        $akun->delete();

        return redirect ('/users')->with('sukses', 'Sukses! akun berhasil di banned!');
    }

    public function viewban () {
        $banned_users = \App\Models\User::onlyTrashed()->paginate(20);
        return view ('admin.ban', ['banned_users' => $banned_users]);
    }

    public function unban ($id) {
        $user = \App\Models\User::withTrashed()->find($id);
        $user->restore();
        return redirect ('/users')->with('sukses', 'Sukses! akun berhasil dipulihkan.');
    }

    public function upgrade ($id) {
        $user = \App\Models\User::find($id);
        if ($user->role == 2) {
            return redirect ('/users')->with('gagal', 'Gagal! akun sudah menjadi agen.');
        } else {
        $data = ['role' => 2];
        $user->update($data);
        return redirect ('/users')->with('sukses', 'Sukses! akun berhasil diupgrade.');
        }
    }

    public function downgrade ($id) {
        $user = \App\Models\User::find($id);
        if ($user->role == 3) {
            return redirect ('/users')->with('gagal', 'Gagal! akun sudah menjadi pencari.');
        } else {
        $data = ['role' => 3];
        $user->update($data);
        return redirect ('/users')->with('sukses', 'Sukses! akun berhasil didowngrade.');
        }
    }

    public function hapus ($id) {
        $user = \App\Models\User::withTrashed()->find($id);
        $user->forceDelete();
        return redirect ('/users/banned')->with('sukses', 'Sukses! akun berhasil dihapus permanen.');
    }

    public function off ($id) {
        $properti = \App\Models\properti::find($id);
        $propertis = \App\Models\favorite::where('properti_id', $id)->delete();
        $properti->delete();
        return redirect ('properti')->with('sukses', 'Sukses! properti berhasil dipindahkan ke tong sampah.');
    }

    public function nonaktif () {
        $properties = \App\Models\properti::onlyTrashed()->paginate(20);
        return view ('admin.nonaktif', compact('properties'));
    }

    public function aktif ($id) {
        $properties = \App\Models\properti::withTrashed()->find($id);
        $properties->restore();
        return redirect ('/properti/nonaktif')->with('sukses', 'Sukses! properti berhasil dipulihkan kembali!');
    }

    public function hapusProperti ($id) {
        $user = \App\Models\properti::withTrashed()->find($id);
        $user->forceDelete();
        return redirect ('/properti/nonaktif')->with('sukses', 'Sukses! properti berhasil dihapus permanen.');
    }

    public function privacy () {
        $privacy = \App\Models\privacy::all();
        return view ('admin.privasi', ['privasi' => $privacy]);
    }

    public function privacyEdit ($id) {
        $privacy = \App\Models\privacy::where("id", $id)->get();
        return view ('admin.editprivasi', ['privasi' => $privacy]);
    }

    public function privacyPost (Request $request, $id) {
        $privacy = \App\Models\privacy::find($id);
        $privacy->update(['judul' => $request->judul,
                          'isi' => $request->isi]);
        $privasi = \App\Models\privacy::all();
        return redirect ('privacy')->with('sukses', 'Sukses! kebijakan privasi berhasil diupdate.');
    }

    public function voucher () {
        $current = date('Y-m-d H:i:s');
        $voucher = \App\Models\voucher::where('expiry_date', '>', $current)->orWhere('expiry_date', null)->paginate(20);
        return view ('admin.voucher', compact('voucher'));
    }

    public function voucherKadaluwarsa () {
        $current = date('Y-m-d H:i:s');
        $voucher = \App\Models\voucher::where('expiry_date', '<', $current)->paginate(20);
        return view ('admin.voucher_kadaluwarsa', compact('voucher'));
    }

    public function voucherKadaluwarsaSearch (Request $request) {
        $current = date('Y-m-d H:i:s');
        $data = $request->voucher;
        $voucher = \App\Models\voucher::where('expiry_date', '<', $current)->where('voucher', 'LIKE', '%'.$data.'%')->paginate(20);
        return view ('admin.voucher_kadaluwarsa_search', compact('voucher'));
    }

    public function dashboard () {
        $current = date('Y-m-d H:i:s');
        $user = \App\Models\User::count();
        $banned_user = \App\Models\User::onlyTrashed()->count();
        $properti = \App\Models\properti::where('deleted_at', null)->orWhere('exp', '>', $current)->count();
        $properti_rumah = \App\Models\properti::where('category_id', 1)->count();
        $properti_resedensial = \App\Models\properti::where('category_id', 2)->count();
        $properti_tanah = \App\Models\properti::where('category_id', 3)->count();
        $properti_kantor = \App\Models\properti::where('category_id', 4)->count();
        $properti_ruang = \App\Models\properti::where('category_id', 5)->count();
        $properti_apartemen = \App\Models\properti::where('category_id', 6)->count();
        $properti_ruko = \App\Models\properti::where('category_id', 7)->count();
        $agen = \App\Models\User::where('role', 2)->count();
        $pencari = \App\Models\User::where('role', 3)->count();
        $off_properti = \App\Models\properti::onlyTrashed()->count();
        $seven = \App\Models\User::where('created_at', '<=', Carbon::now()->subDays(7)->toDateTimeString())->count();
        $six = \App\Models\User::where('created_at', '<=', Carbon::now()->subDays(6)->toDateTimeString())->count();
        $five = \App\Models\User::where('created_at', '<=', Carbon::now()->subDays(5)->toDateTimeString())->count();
        $four = \App\Models\User::where('created_at', '<=', Carbon::now()->subDays(4)->toDateTimeString())->count();
        $three = \App\Models\User::where('created_at', '<=', Carbon::now()->subDays(3)->toDateTimeString())->count();
        $two = \App\Models\User::where('created_at', '<=', Carbon::now()->subDays(2)->toDateTimeString())->count();
        $one = \App\Models\User::where('created_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->count();

        return view ('admin.dashboard', compact('user', 'banned_user', 'properti', 'off_properti', 'properti_rumah', 
        'properti_resedensial', 'properti_tanah', 'properti_kantor', 'properti_ruang', 'properti_apartemen', 'properti_ruko',
        'agen', 'pencari', 'seven', 'six', 'five', 'four', 'three', 'two', 'one'));
    }

    public function syarat () {
        $syarat = \App\Models\syarat::all();
        return view ('admin.syarat', compact('syarat'));
    }

    public function editSyarat ($id) {
        $syarat = \App\Models\syarat::where("id", $id)->get();
        return view ('admin.editsyarat', ['syarat' => $syarat]);
    }

    public function syaratPost (Request $request, $id) {
        $syarat = \App\Models\syarat::find($id);
        $syarat->update($request->all());
        return redirect ('syarat')->with('sukses', 'Sukses! syarat penggunaan berhasil diupdate.');
    }

    public function tentang () {
        $tentang = \App\Models\tentang::all();
        return view ('admin.tentang', compact('tentang'));
    }

    public function tentangEdit ($id) {
        $tentang = \App\Models\tentang::where("id",$id)->get();
        return view ('admin.edit_tentang', compact('tentang'));
    }

    public function tentangPost (Request $request, $id) {
        $tentang = \App\Models\tentang::find($id);
        $tentang->update($request->all());
        return redirect ('tentang')->with('sukses', 'Sukses! informasi berhasil diupdate.');
    }

    public function faq () {
        $faq = \App\Models\faq::paginate(20);
        return view ('admin.faq', compact ('faq'));
    }

    public function faqDetail ($id) {
        $faq = \App\Models\faq::where("id",$id)->get();
        return view ('admin.faq_details', compact('faq'));
    }

    public function faqEdit ($id) {
        $faq = \App\Models\faq::where("id",$id)->get();
        return view ('admin.editfaq', compact('faq'));
    }

    public function faqPost (Request $request, $id) {
        $faq = \App\Models\faq::find($id);
        $faq->update($request->all());
        return redirect ('faq')->with('sukses', 'Sukses! faq berhasil diupdate.');
    }

    public function hapusFaq ($id) {
        $faq = \App\Models\faq::find($id);
        $faq->delete();
        return redirect ('faq')->with('sukses', 'Sukses! faq berhasil dihapus.');
    }

    public function tambahFaq () {
        return view ('admin.tambah_faq');
    }

    public function tambahFaqPost (Request $request) {
        if ($request->judul === null) {
            return redirect ('/faq/tambah')->with('gagal', 'Gagal! maaf judul tidak boleh kosong.');
        } else if ($request->isi === null) {
            return redirect ('/faq/tambah')->with('gagal', 'Gagal! maaf isi faq tidak boleh kosong.');
        }

        \App\Models\faq::create($request->all());
        return redirect ('faq')->with('sukses', 'Sukses! faq berhasil dibuat.');
    }

    public function tambahVoucher () {
        return view ('admin.tambah_voucher');
    }

    public function tambahVoucherPost (Request $request) {
        if (strlen($request->voucher) > 15) {
            return redirect ('voucher')->with('gagal', 'Gagal! maaf kode voucher tidak boleh lebih dari 15 karakter.');
        } else if (strpos($request->voucher, " ") !== false) {
            return redirect ('voucher')->with('gagal', 'Gagal! maaf kode voucher tidak boleh mengandung spasi.');
        } else if (\App\Models\voucher::where('voucher', $request->voucher)->exists()) {
            return redirect ('voucher')->with('gagal', 'Gagal! maaf kode voucher sudah pernah dibuat.');
        } else if (!isset($request->voucher)){
            return redirect ('voucher')->with('gagal', 'Maaf! voucher tidak boleh kosong');
        };

        if ($request->continuous == 0) {
            if ($request->durasi == 1) {
               
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
    
            if ($request->durasi == 2) {
               
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
    
            if ($request->durasi == 3) {
               
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
        }

        if ($request->continuous == 1) {
            if ($request->durasi == 1) {
                $date = date('Y-m-d H:i:s', strtotime('+1 month'));
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => $date])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
    
            if ($request->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => $date])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
    
            if ($request->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => $date])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
        }
        
        if ($request->continuous == 2) {
            if ($request->durasi == 1) {
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
    
            if ($request->durasi == 2) {
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
    
            if ($request->durasi == 3) {
                \App\Models\voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );
                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.'); 
            }
        }

        return redirect ('voucher')->with('gagal', 'Gagal! request invalid.');
    }

    public function hapusVoucher ($id) {
        $voucher = \App\Models\voucher::find($id);
        $vouchers = \App\Models\voucher_usage::where('voucher', $voucher->voucher)->delete();
        $voucher->delete();
        return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dihapus.');
    }

    public function voucherKadaluwarsaHapus ($id) {
        $current = date('Y-m-d H:i:s');
        $voucher = \App\Models\voucher::where('expiry_date', '<', $current)->find($id);
        $vouchers = \App\Models\voucher_usage::where('voucher', $voucher->voucher)->delete();
        $voucher->delete();
        return redirect ('voucher/kadaluwarsa')->with('sukses', 'Sukses! voucher berhasil dihapus.');
    }

    public function tambahProperti () {
        return view ('admin.tambah_properti');
    }

    public function sorry () {
        return view ('admin.sorry');
    }

    public function detailProperti ($id) {
        $properti = \App\Models\properti::where('id', $id)->get();
        return view ('admin.detail_properti', compact('properti'));
    }

    public function setting_kategori () {
        $gambar = \App\Models\setting_kategori::all();
        $pesan = \App\Models\message::all();
        return view ('admin.pengaturan', compact('gambar', 'pesan'));
    }

    public function ubah_gambar_kategori ($id) {
        $gambar = \App\Models\setting_kategori::where('id', $id)->get();
        return view ('admin.edit_gambar_pengaturan', compact('gambar'));
    }

    public function ubah_pesan_kategori ($id) {
        $pesan = \App\Models\message::where('id', $id)->get();
        return view ('admin.edit_pesan_pengaturan', compact('pesan'));
    }

    public function ubah_pesan_kategoriPost (Request $request, $id) {
        $data = \App\Models\message::where('id', $id);
        $data->update([
            'pesan' => $request->pesan,
            'harga' => $request->harga
        ]);
        return redirect('pengaturan')->with('sukses', 'Berhasil! pesan WhatsApp berhasil dirubah');
    }

    public function ubah_gambar_kategoriPost (Request $request, $id) {
        $gambar = \App\Models\setting_kategori::find($id);
        $gambar_1 = $request->gambar;
        $gambar_1_final = time().$gambar_1->getClientOriginalName();
        $gambar->update([
            'gambar' => 'public/uploads/properti/setting/'.$gambar_1_final,
        ]);
        $gambar_1->move('public/uploads/properti/setting/', $gambar_1_final);
        return redirect ('pengaturan')->with('sukses', 'sukses!');
    }

    public function request () {
        $request = \App\Models\request::paginate(20);
        return view ('admin.request', compact ('request'));
    }

    public function tolakRequest ($id) {
        $request = \App\Models\request::find($id);
        $request->delete();
        return redirect ('users/request')->with('sukses', 'sukses! permohonan berhasil ditolak');
    }

    public function setujuRequest ($id) {
        $data = \App\Models\request::find($id);
        $user_id = $data->users_id;
        $request = \App\Models\User::find($user_id);
        $request->update([
            'role' => 2,
        ]);
        $data->delete();
        return redirect ('users/request')->with('sukses', 'sukses! permohonan berhasil disetujui');
    }

    public function searchVoucher (Request $request) {
        $current = date('Y-m-d H:i:s');
        $data = $request->voucher;
        $result = \App\Models\voucher::where('expiry_date', '>', $current)->where('voucher', 'LIKE', '%'.$data.'%')->orWhere('expiry_date', null)->where('voucher', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.voucher_search', compact ('result'));
    }

    public function searchFaq (Request $request) {
        $data = $request->cari;
        $result = \App\Models\faq::where('judul', 'LIKE', '%'.$data.'%')->orWhere('isi', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.faq_search', compact ('result'));
    }

    public function usersSearch (Request $request) {
        $data = $request->cari;
        $result = \App\Models\User::where('name', 'LIKE', '%'.$data.'%')->orWhere('email', 'LIKE', '%'.$data.'%')->orWhere('no_telp', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.user_search', compact('result'));
    }

    public function bannedSearch (Request $request) {
        $data = $request->cari;
        $result = \App\Models\User::onlyTrashed()->where('id', $data)->paginate(20);
        return view ('admin.ban_search', compact('result'));
    }

    public function requestSearch (Request $request) {
        $data = $request->cari;
        $result = \App\Models\request::where('id',$data)->get();
        return view ('admin.request_search', compact('result'));
    }

    public function tambahVoucherBroker () {
        return view ('admin.tambah_voucher_broker');
    }

    public function searchProperti (Request $request) {
        $data = $request->cari;
        $result = \App\Models\properti::where('nama', 'LIKE', '%'.$data.'%')->orWhere('deskripsi', 'LIKE', '%'.$data.'%')->orWhere('provinsi', 'LIKE', '%'.$data.'%')->orWhere('kabupaten', 'LIKE', '%'.$data.'%')->orWhere('kecamatan', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.properti_search', compact('result'));
    }

    public function searchPropertiTrashed (Request $request) {
        $data = $request->cari;
        $result = \App\Models\properti::onlyTrashed()->where('id', $data)->paginate(20);
        return view ('admin.nonaktif_search', compact('result'));
    }

    public function informasi () {
        $informasi = \App\Models\informasi::paginate(20);
        return view ('admin.informasi', compact ('informasi'));
    }

    public function detailInformasi ($id) {
        $informasi = \App\Models\informasi::where('id',$id)->get();
        return view ('admin.detail_informasi', compact('informasi'));
    }

    public function tambahInformasi () {
        return view ('admin.tambah_informasi');
    }

    public function tambahInformasiPost (Request $request) {
        $gambar_1 = $request->file('gambar');
        $gambar_1_final = time().$gambar_1->getClientOriginalName();

        \App\Models\informasi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => 'public/uploads/informasi/'.$gambar_1_final
        ]);

        $gambar_1->move('public/uploads/informasi/', $gambar_1_final);
        return redirect ('informasi')->with('sukses', 'Sukses! informasi berhasil dibuat.');
    }

    public function hapusInformasi ($id) {
        $data = \App\Models\informasi::find($id);
        $data->delete();
        return redirect ('informasi')->with('sukses', 'sukses! informasi berhasil dihapus');
    }

    public function editInformasi ($id) {
        $data = \App\Models\informasi::where('id', $id)->get();
        return view ('admin.edit_informasi', compact('data'));
    }

    public function editInformasiPost (Request $request, $id) {
        $data = \App\Models\informasi::find($id);
        $gambar_1 = $request->file('gambar');
        $gambar_1_final = time().$gambar_1->getClientOriginalName();

        $data->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => 'public/uploads/informasi/'.$gambar_1_final
        ]);

        $gambar_1->move('public/uploads/informasi/', $gambar_1_final);
        return redirect ('informasi')->with('sukses', 'sukses! informasi berhasil diperbarui');
    }

    public function searchInformasi (Request $request) {
        $data = $request->cari;
        $info = \App\Models\informasi::where('judul', 'LIKE', '%'.$data.'%')->orWhere('isi', 'LIKE', '%'.$data.'%')->paginate(20);
        return view ('admin.informasi_search', compact('info'));
    }

    public function voucherKadaluwarsaFresh () {
        $current = date('Y-m-d H:i:s');
        $voucher = \App\Models\voucher::where('expiry_date', '<', $current);
        $voucherz = \App\Models\voucher::where('expiry_date', '<', $current)->first();
        $vouchers = \App\Models\voucher_usage::where('voucher', $voucherz->voucher)->delete();
        $voucher->delete();
        return redirect ('voucher/kadaluwarsa')->with('sukses', 'sukses! data voucher berhasil diupdate');
    }

    public function verificationOTP (Request $request, $id) {
        $user = \App\Models\User::find($id);
        $code_1 = "$user->activation_code";
        $aktivasi = "$request->activation_code";
        if ($code_1 != $aktivasi) { 
            return redirect('register');
        }
        \App\Models\User::find($id)->update([
        'isVerified' => 1
        ]);
        return redirect ('login')->with('sukses', 'Anda berhasil terdaftar');
    }

    public function lupaPassword () {
        return view ('auth.forgot_password');
    }

    public function lupaPasswordPost (Request $request) {
        $user = \App\Models\User::where('no_telp', $request->no_telp)->get();
        if(!isset($user[0])) {
            return redirect ('register');
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
        \App\Models\User::where('no_telp', $request->no_telp)->update([
            'activation_code' => $kode
        ]);
        return view ('auth.forgot_password_change', ['user' => $user[0]]);
    }

    public function lupaPasswordSet (Request $request, $id) {
        $user = \App\Models\User::find($id);
        $code_1 = "$user->activation_code";
        $aktivasi = "$request->activation_code";
        if ($code_1 != $aktivasi) { 
            return redirect('register')->with('error', 'Maaf, kode OTP yang anda masukkan salah');
        }
        $user = \App\Models\User::find($id);
        return view ('auth.forgot_password_set', compact('user'));
    }

    public function lupaPasswordSetPassword (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            return redirect('login')->with('error', 'Maaf, password yang anda masukkan tidak valid. (ket: minimal 8 karakter)');
        }
        $user = \App\Models\User::find($id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect('login')->with('sukses', 'Sukses! password berhasil diubah');
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
                if($files=$request->file('foto_tampak_lain')) {
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
                    return redirect ('/properti')->with('sukses', 'properti ruko berhasil ditambahkan');
                }
    }
}
