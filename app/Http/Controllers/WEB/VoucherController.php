<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\voucher;
use App\Models\voucher_usage;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function voucher () {
        $current = date('Y-m-d H:i:s');
        $voucher = voucher::where('expiry_date', '>', $current)->orWhere('expiry_date', null)->paginate(20);

        return view ('admin.voucher', compact('voucher'));
    }

    public function searchVoucher (Request $request) {
        $current = date('Y-m-d H:i:s');
        $data = $request->voucher;
        $result = voucher::where('expiry_date', '>', $current)->where('voucher', 'LIKE', '%'.$data.'%')->orWhere('expiry_date', null)->where('voucher', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.voucher_search', compact ('result'));
    }

    public function voucherKadaluwarsaFresh () {
        $current = date('Y-m-d H:i:s');
        $voucher = voucher::where('expiry_date', '<', $current);
        $voucherz = voucher::where('expiry_date', '<', $current)->first();

        if ($voucherz != null) {
            voucher_usage::where('voucher', $voucherz->voucher)->delete();
        }

        $voucher->delete();
        return redirect ('voucher/kadaluwarsa')->with('sukses', 'sukses! data voucher berhasil diupdate');
    }

    public function voucherKadaluwarsaSearch (Request $request) {
        $current = date('Y-m-d H:i:s');
        $data = $request->voucher;
        $voucher = voucher::where('expiry_date', '<', $current)->where('voucher', 'LIKE', '%'.$data.'%')->paginate(20);
        return view ('admin.voucher_kadaluwarsa_search', compact('voucher'));
    }

    public function voucherKadaluwarsa () {
        $current = date('Y-m-d H:i:s');
        $voucher = voucher::where('expiry_date', '<', $current)->paginate(20);
        return view ('admin.voucher_kadaluwarsa', compact('voucher'));
    }

    public function voucherKadaluwarsaHapus ($id) {
        $current = date('Y-m-d H:i:s');
        $voucher = voucher::where('expiry_date', '<', $current)->find($id);
        voucher_usage::where('voucher', $voucher->voucher)->delete();
        $voucher->delete();
        return redirect ('voucher/kadaluwarsa')->with('sukses', 'Sukses! voucher berhasil dihapus.');
    }

    public function tambahVoucher () {
        return view ('admin.tambah_voucher');
    }

    public function tambahVoucherBroker () {
        return view ('admin.tambah_voucher_broker');
    }

    public function tambahVoucherPost (Request $request) {
        if (strlen($request->voucher) > 15) {
            return redirect ('voucher')->with('gagal', 'Gagal! maaf kode voucher tidak boleh lebih dari 15 karakter.');
        } else if (strpos($request->voucher, " ") !== false) {
            return redirect ('voucher')->with('gagal', 'Gagal! maaf kode voucher tidak boleh mengandung spasi.');
        } else if (voucher::where('voucher', $request->voucher)->exists()) {
            return redirect ('voucher')->with('gagal', 'Gagal! maaf kode voucher sudah pernah dibuat.');
        } else if (!isset($request->voucher)){
            return redirect ('voucher')->with('gagal', 'Maaf! voucher tidak boleh kosong');
        };

        if ($request->continuous == 0) {
            if ($request->durasi == 1) {
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }

            if ($request->durasi == 2) {
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }

            if ($request->durasi == 3) {
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }
        }

        if ($request->continuous == 1) {
            if ($request->durasi == 1) {
                $date = date('Y-m-d H:i:s', strtotime('+1 month'));
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => $date])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }

            if ($request->durasi == 2) {
                $date = date('Y-m-d H:i:s', strtotime('+3 months'));
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => $date])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }

            if ($request->durasi == 3) {
                $date = date('Y-m-d H:i:s', strtotime('+6 months'));
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => $date])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }
        }

        if ($request->continuous == 2) {
            if ($request->durasi == 1) {
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }

            if ($request->durasi == 2) {
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }

            if ($request->durasi == 3) {
                voucher::create(
                    array_merge($request->all(), ['expiry_date' => null])
                );

                return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dibuat.');
            }
        }

        return redirect ('voucher')->with('gagal', 'Gagal! request invalid.');
    }

    public function hapusVoucher ($id) {
        $voucher = voucher::find($id);
        voucher_usage::where('voucher', $voucher->voucher)->delete();
        $voucher->delete();
        return redirect ('voucher')->with('sukses', 'Sukses! voucher berhasil dihapus.');
    }
}
