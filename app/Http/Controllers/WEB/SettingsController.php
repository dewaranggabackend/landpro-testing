<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\message;
use App\Models\setting_kategori;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function setting_kategori () {
        $gambar = setting_kategori::all();
        $pesan = message::all();
        return view ('admin.pengaturan', compact('gambar', 'pesan'));
    }

    public function ubah_gambar_kategori ($id) {
        $gambar = setting_kategori::where('id', $id)->get();
        return view ('admin.edit_gambar_pengaturan', compact('gambar'));
    }

    public function ubah_pesan_kategori ($id) {
        $pesan = message::where('id', $id)->get();
        return view ('admin.edit_pesan_pengaturan', compact('pesan'));
    }

    public function ubah_pesan_kategoriPost (Request $request, $id) {
        $data = message::where('id', $id);
        $data->update([
            'pesan' => $request->pesan,
            'harga' => $request->harga
        ]);

        return redirect('pengaturan')->with('sukses', 'Berhasil! pesan WhatsApp berhasil dirubah');
    }

    public function ubah_gambar_kategoriPost (Request $request, $id) {
        $gambar = setting_kategori::find($id);
        $gambar_1 = $request->gambar;
        $gambar_1_final = time().$gambar_1->getClientOriginalName();
        $gambar->update([
            'gambar' => 'public/uploads/properti/setting/'.$gambar_1_final,
        ]);
        $gambar_1->move('public/uploads/properti/setting/', $gambar_1_final);
        return redirect ('pengaturan')->with('sukses', 'sukses!');
    }
}
