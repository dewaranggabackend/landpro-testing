<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\faq;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function faq () {
        $faq = faq::paginate(20);
        return view ('admin.faq', compact ('faq'));
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

        faq::create($request->all());
        return redirect ('faq')->with('sukses', 'Sukses! faq berhasil dibuat.');
    }

    public function searchFaq (Request $request) {
        $data = $request->cari;
        $result = faq::where('judul', 'LIKE', '%'.$data.'%')->orWhere('isi', 'LIKE', '%'.$data.'%')->get();
        return view ('admin.faq_search', compact ('result'));
    }

    public function faqDetail ($id) {
        $faq = faq::where("id",$id)->get();
        return view ('admin.faq_details', compact('faq'));
    }

    public function faqEdit ($id) {
        $faq = faq::where("id",$id)->get();
        return view ('admin.editfaq', compact('faq'));
    }

    public function faqPost (Request $request, $id) {
        $faq = faq::find($id);
        $faq->update($request->all());
        return redirect ('faq')->with('sukses', 'Sukses! faq berhasil diupdate.');
    }

    public function hapusFaq ($id) {
        $faq = faq::find($id);
        $faq->delete();
        return redirect ('faq')->with('sukses', 'Sukses! faq berhasil dihapus.');
    }
}
