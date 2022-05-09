<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\favorite;
use App\Models\properti;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;

class PropertiController extends Controller
{
    public function properti () {
        $properties = properti::with('pengguna')->where('tayang', 1)->paginate(10);
        return response()->json($properties);
    }

    public function search (Request $request) {
        $keyword = $request->keyword;
        $properti = properti::with('pengguna')->where('jenis', 1)->where('category_id', 1)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_res = properti::with('pengguna')->where('jenis', 1)->where('category_id', 2)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_tanah = properti::with('pengguna')->where('jenis', 1)->where('category_id', 3)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_kantor = properti::with('pengguna')->where('jenis', 1)->where('category_id', 4)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_usaha = properti::with('pengguna')->where('jenis', 1)->where('category_id', 5)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_apartemen = properti::with('pengguna')->where('jenis', 1)->where('category_id', 6)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_ruko = properti::with('pengguna')->where('jenis', 1)->where('category_id', 7)->where('tayang', 1)
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
        ]);
    }

    public function searchSewa (Request $request) {
        $keyword = $request->keyword;
        $properti = properti::with('pengguna')->where('jenis', 0)->where('category_id', 1)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_res = properti::with('pengguna')->where('jenis', 0)->where('category_id', 2)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_tanah = properti::with('pengguna')->where('jenis', 0)->where('category_id', 3)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_kantor = properti::with('pengguna')->where('jenis', 0)->where('category_id', 4)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_usaha = properti::with('pengguna')->where('jenis', 0)->where('category_id', 5)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_apartemen = properti::with('pengguna')->where('jenis', 0)->where('category_id', 6)->where('tayang', 1)
            ->where(function ($query) use ($keyword){
                $query->orWhere('nama', $keyword)
                    ->orWhere('provinsi', $keyword)
                    ->orWhere('kabupaten', $keyword)
                    ->orWhere('kecamatan', $keyword);
            })
            ->paginate(10);

        $properti_ruko = properti::with('pengguna')->where('jenis', 0)->where('category_id', 7)->where('tayang', 1)
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
        ]);
    }

    public function filter (Request $request) {
        if (!isset($request->harga_minimal)) {
            $request->harga_minimal = 0;
        }

        if (!isset($request->harga_maksimal)) {
            $request->harga_maksimal = 99999999999999;
        }

        $keyword = $request->keyword;
        $properti = properti::with('pengguna')->where('jenis', 1)->where('category_id', 1)->where('tayang', 1);
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

        $properti_res = properti::with('pengguna')->where('jenis', 1)->where('category_id', 2)->where('tayang', 1);
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

        $properti_tanah = properti::with('pengguna')->where('jenis', 1)->where('category_id', 3)->where('tayang', 1);
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

        $properti_kantor = properti::with('pengguna')->where('jenis', 1)->where('category_id', 4)->where('tayang', 1);
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

        $properti_usaha = properti::with('pengguna')->where('jenis', 1)->where('category_id', 5)->where('tayang', 1);
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

        $properti_apartemen = properti::with('pengguna')->where('jenis', 1)->where('category_id', 6)->where('tayang', 1);
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

        $properti_ruko = properti::with('pengguna')->where('jenis', 1)->where('category_id', 7)->where('tayang', 1);
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
        ]);
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

        $keyword = $request->keyword;
        $properti = properti::with('pengguna')->where('jenis', 0)->where('category_id', 1)->where('tayang', 1)
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

        $properti_res = properti::with('pengguna')->where('jenis', 0)->where('category_id', 2)->where('tayang', 1)
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

        $properti_tanah = properti::with('pengguna')->where('jenis', 0)->where('category_id', 3)->where('tayang', 1)
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

        $properti_kantor = properti::with('pengguna')->where('jenis', 0)->where('category_id', 4)->where('tayang', 1)
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

        $properti_usaha = properti::with('pengguna')->where('jenis', 0)->where('category_id', 5)->where('tayang', 1)
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

        $properti_apartemen = properti::with('pengguna')->where('jenis', 0)->where('category_id', 6)->where('tayang', 1)
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

        $properti_ruko = properti::with('pengguna')->where('jenis', 0)->where('category_id', 7)->where('tayang', 1)
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
        ]);
    }

    public function kelola (Request $request) {
        $data = properti::where('user_id', $request->user_id)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'error',
                'data' => 'Maaf, properti tidak ditemukan'
            ], 404);
        }

        $current = date('Y-m-d H:i:s');
        $data_aktif = properti::with('pengguna')->where('user_id', $request->user_id)->where('exp', '>', $current)->get();
        $data_no = properti::with('pengguna')->where('user_id', $request->user_id)->where('exp', '<', $current)->get();
        $data_no_2 = properti::with('pengguna')->where('user_id', $request->user_id)->where('exp', null)->get();
        $final = Arr::collapse([$data_no, $data_no_2]);
        $finals = Arr::collapse([$final, $data_aktif]);

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
        ]);
    }

    public function detailProperti ($id) {
        $properti = properti::with('pengguna')->find($id);
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
        ]);
    }

    public function editProperti (Request $request, $id) {
        $data = properti::where('id', $id)->get();
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

            if ($files=$request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/rumah/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/rumah/'.implode('|public/uploads/properti/rumah/', $foto_tampak_lain);

            properti::where('id', $id)->update([
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
            ]);
        }

        if ($cek_kategori == 2) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/resedensial/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/resedensial/'.implode('|public/uploads/properti/resedensial/', $foto_tampak_lain);

            properti::where('id', $id)->update([
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
            ]);
        }

        if ($cek_kategori == 3) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if ($files=$request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/tanah/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/tanah/'.implode('|public/uploads/properti/tanah/', $foto_tampak_lain);

            properti::where('id', $id)->update([
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
            ]);
        }

        if ($cek_kategori == 4) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/kantor/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/kantor/'.implode('|public/uploads/properti/kantor/', $foto_tampak_lain);

            properti::where('id', $id)->update([
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
            ]);
        }

        if ($cek_kategori == 5) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/ruang/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/ruang/'.implode('|public/uploads/properti/ruang/', $foto_tampak_lain);

            properti::where('id', $id)->update([
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
            ]);
        }

        if ($cek_kategori == 6) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();
            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/apartemen/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/apartemen/'.implode('|public/uploads/properti/apartemen/', $foto_tampak_lain);

            properti::where('id', $id)->update([
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
            ]);
        }

        if ($cek_kategori == 7) {
            $gambar_1 = $request->foto_tampak_depan;
            $gambar_1_final = time().$gambar_1->getClientOriginalName();
            $gambar_2 = $request->foto_tampak_jalan;
            $gambar_2_final = time().$gambar_2->getClientOriginalName();
            $gambar_3 = $request->foto_tampak_ruangan;
            $gambar_3_final = time().$gambar_3->getClientOriginalName();
            $foto_tampak_lain = array ();

            if ($files = $request->file('foto_tampak_lain')) {
                foreach ($files as $file) {
                    $name=time().$file->getClientOriginalName();
                    $file->move('public/uploads/properti/ruko/', $name);
                    $foto_tampak_lain[]=$name;
                }
            }

            $ftl = 'public/uploads/properti/ruko/'.implode('|public/uploads/properti/ruko/', $foto_tampak_lain);

            properti::where('id', $id)->update([
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
            ]);
        }
    }

    public function deleteProperti ($id) {
        $checker = favorite::where('properti_id', $id)->get();

        if (isset($checker[0])) {
            favorite::where('properti_id', $id)->delete();
        }

        properti::withTrashed()->find($id)->delete();
        properti::withTrashed()->find($id)->forceDelete();

        return response()->json([
            'status' => 'sukses',
            'data'  => 'Properti berhasil dihapus'
        ]);
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

        favorite::create($request->all());
        return response()->json([
            'status' => 'sukses'
        ]);
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
        $data = favorite::where('users_id', $request->users_id)->where('properti_id', $request->properti_id);
        $data->delete();
        return response()->json([
            'status' => 'sukses'
        ]);
    }

    public function favorite ($id) {
        $favorit = favorite::with('properti.pengguna')->where('users_id', $id)->get();

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
        ]);
    }

    public function tambahPropertiPost (Request $request) {
        $access = properti::with('pengguna')->where('tayang', 0)->where('user_id', $request->user_id)->get();
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

                if ($files = $request->file('foto_tampak_lain')) {
                    foreach ($files as $file) {
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/rumah/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }

                $ftl = 'public/uploads/properti/rumah/'.implode('|public/uploads/properti/rumah/', $foto_tampak_lain);

                properti::create([
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
                ]);
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

                properti::create([
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
                ]);
            }

            if ($cek_kategori == 3) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();

                if ($files = $request->file('foto_tampak_lain')) {
                    foreach ($files as $file) {
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/tanah/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }

                $ftl = 'public/uploads/properti/tanah/'.implode('|public/uploads/properti/tanah/', $foto_tampak_lain);

                properti::create([
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
                ]);
            }

            if ($cek_kategori == 4) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();

                if($files = $request->file('foto_tampak_lain')) {
                    foreach ($files as $file) {
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/kantor/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }

                $ftl = 'public/uploads/properti/kantor/'.implode('|public/uploads/properti/kantor/', $foto_tampak_lain);

                properti::create([
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
                ]);
            }

            if ($cek_kategori == 5) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();

                if ($files = $request->file('foto_tampak_lain')) {
                    foreach ($files as $file) {
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/ruang/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }

                $ftl = 'public/uploads/properti/ruang/'.implode('|public/uploads/properti/ruang/', $foto_tampak_lain);

                properti::create([
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
                ]);
            }

            if ($cek_kategori == 6) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();
                if ($files = $request->file('foto_tampak_lain')) {
                    foreach ($files as $file) {
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/apartemen/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }

                $ftl = 'public/uploads/properti/apartemen/'.implode('|public/uploads/properti/apartemen/', $foto_tampak_lain);

                properti::create([
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
                ]);
            }

            if ($cek_kategori == 7) {
                $gambar_1 = $request->foto_tampak_depan;
                $gambar_1_final = time().$gambar_1->getClientOriginalName();
                $gambar_2 = $request->foto_tampak_jalan;
                $gambar_2_final = time().$gambar_2->getClientOriginalName();
                $gambar_3 = $request->foto_tampak_ruangan;
                $gambar_3_final = time().$gambar_3->getClientOriginalName();
                $foto_tampak_lain = array ();

                if ($files = $request->file('foto_tampak_lain')) {
                    foreach ($files as $file) {
                        $name=time().$file->getClientOriginalName();
                        $file->move('public/uploads/properti/ruko/', $name);
                        $foto_tampak_lain[]=$name;
                    }
                }

                $ftl = 'public/uploads/properti/ruko/'.implode('|public/uploads/properti/ruko/', $foto_tampak_lain);

                properti::create([
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
                ]);
            }
        }
    }

    public function findFav (Request $request) {
        $data = favorite::where('users_id', $request->users_id)->where('properti_id', $request->properti_id)->get();
        if (!isset($data[0])) {
            return response()->json([
                'status' => 'sukses',
                'data' => false
            ], 200);
        }

        return response()->json([
            'status' => 'sukses',
            'data' => true
        ]);
    }
}
