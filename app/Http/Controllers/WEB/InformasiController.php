<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function informasi () {
        $informasi = informasi::paginate(20);
        return view ('admin.informasi', compact ('informasi'));
    }

    public function searchInformasi (Request $request) {
        $data = $request->cari;
        $info = informasi::where('judul', 'LIKE', '%'.$data.'%')->orWhere('isi', 'LIKE', '%'.$data.'%')->paginate(20);
        return view ('admin.informasi_search', compact('info'));
    }

    public function tambahInformasi () {
        return view ('admin.tambah_informasi');
    }

    public function tambahInformasiPost (Request $request) {
        $gambar_1 = $request->file('gambar');
        $gambar_1_final = time().$gambar_1->getClientOriginalName();

        informasi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => 'public/uploads/informasi/'.$gambar_1_final
        ]);

        $gambar_1->move('public/uploads/informasi/', $gambar_1_final);
        return redirect ('informasi')->with('sukses', 'Sukses! informasi berhasil dibuat.');
    }

    public function hapusInformasi ($id) {
        $data = informasi::find($id);
        $data->delete();
        return redirect ('informasi')->with('sukses', 'sukses! informasi berhasil dihapus');
    }

    public function editInformasi ($id) {
        $data = informasi::where('id', $id)->get();
        return view ('admin.edit_informasi', compact('data'));
    }

    public function editInformasiPost (Request $request, $id) {
        $data = informasi::find($id);
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

    public function detailInformasi ($id) {
        $informasi = informasi::where('id',$id)->get();
        return view ('admin.detail_informasi', compact('informasi'));
    }
}
