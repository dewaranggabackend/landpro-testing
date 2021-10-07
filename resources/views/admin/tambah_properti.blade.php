@extends('layout.master')

@section('judul')
Tambah Properti
@endsection

@section('mainjudul')
Tambah Properti Baru
@endsection

@section('subjudul')
\ Properti \ Tambah
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>

<div class="card mb-4">
<div class="card-body">
<a href="/properti"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>

</div>
</div>
<div class="card mb-4">
<div class="card-body">
<form action="/properti/tambah" method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
<input name="user_id" value="{{Auth::user()->id;}}" type="hidden" required>
<div class="row">
<div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body">Foto Tampak Depan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <input name="foto_tampak_depan" type="file" class="small text-white stretched-link" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body">Foto Tampak Jalan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <input name="foto_tampak_jalan" type="file" class="small text-white stretched-link" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body">Foto Tampak Ruangan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <input  name="foto_tampak_ruangan" type="file" class="small text-white stretched-link" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body">Foto Tampak Lain</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <input name="foto_tampak_lain[]" multiple type="file" class="small text-white stretched-link" required>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
</div>
<div class="card mb-4">
<div class="card-body">
<div class="mb-3">
  <label for="jenis" class="form-label">Jenis</label>
  <select class="form-select" name="jenis" id="jenis">
  <option value="0">Sewa</option>
  <option selected value="1">Jual</option>
</select>
</div>
<div class="mb-3">
  <label for="kategori" class="form-label">Kategori</label>
  <select class="form-select" name="category_id" id="kategori">
  <option selected value="1">Rumah</option>
  <option value="2">Resedensial</option>
  <option value="3">Tanah</option>
  <option value="4">Kantor</option>
  <option value="5">Ruang Usaha</option>
  <option value="6">Apartemen</option>
  <option value="7">Ruko</option>
</select>
</div>
<div class="mb-3">
  <label for="nama" class="form-label">Judul</label>
  <input type="text" class="form-control" id="nama" name="nama" required>
</div>
<div class="mb-3">
  <label for="deskripsi" class="form-label">Deskripsi</label>
  <textarea class="form-control" id="tambah_voucher" name="deskripsi" rows="20"></textarea>
</div>
<div class="mb-3">
  <label for="nama" class="form-label">Alamat Google Map</label>
  <input type="text" class="form-control" name="alamat_gmap">
  <div id="gmapHelp" class="form-text">* Opsional</div>
  <div id="gmapHelp2" class="form-text">** Buka lokasi pada google map, lalu tempel link disini</div>
</div>
<div class="mb-3">
  <label for="provinsi" class="form-label">Provinsi</label>
  <input type="text" class="form-control" name="provinsi" id="provinsi">
</div>
<div class="mb-3">
  <label for="kabupaten" class="form-label">Kabupaten</label>
  <input type="text" class="form-control" name="kabupaten" id="kabupaten">
</div>
<div class="mb-3">
  <label for="kecamatan" class="form-label">Kecamatan</label>
  <input type="text" class="form-control" name="kecamatan" id="kecamatan">
</div>
<div class="mb-3">
  <label for="kode_pos" class="form-label">Kode Pos</label>
  <input type="number" class="form-control" name="kode_pos" id="kode_pos">
</div>
<div class="mb-3">
  <label for="luas_tanah" class="form-label">Luas Tanah</label>
  <input type="number" class="form-control" name="luas_tanah" id="luas_tanah">
</div>
<div class="mb-3">
  <label for="luas_bangunan" class="form-label">Luas Bangunan</label>
  <input type="number" class="form-control" name="luas_bangunan" id="luas_bangunan">
</div>
<div class="mb-3">
  <label for="sertifikat" class="form-label">Sertifikat</label>
  <select class="form-select" name="sertifikat" id="sertifikat">
  <option selected value="SHM">Sertifikat Hak Milik</option>
  <option value="SHGB">Sertifikat Hak Guna Bangunan</option>
  <option value="SHMSRS">Sertifikat Hak Milik Satuan Rumah Susun</option>
  <option value="Girik">Tanah Adat</option>
  <option value="AJB">Akta Jual Beli</option>
</select>
</div>
<div class="mb-3">
  <label for="umur_bangunan" class="form-label">Umur Bangunan</label>
  <input type="text" class="form-control" name="umur_bangunan" id="umur_bangunan">
</div>
<div class="mb-3">
  <label for="jumlah_lantai" class="form-label">Jumlah Lantai</label>
  <input type="number" class="form-control" name="jumlah_lantai" id="jumlah_lantai">
</div>
<div class="mb-3">
  <label for="kamar_tidur" class="form-label">Jumlah Kamar Tidur</label>
  <input type="number" class="form-control" name="kamar_tidur" id="kamar_tidur">
</div>
<div class="mb-3">
  <label for="kamar_mandi" class="form-label">Jumlah Kamar Mandi</label>
  <input type="number" class="form-control" name="kamar_mandi" id="kamar_mandi">
</div>
<div class="mb-3">
  <label for="kamar_tidur_art" class="form-label">Jumlah Kamar Tidur ART</label>
  <input type="number" class="form-control" name="kamar_tidur_art" id="kamar_tidur_art">
</div>
<div class="mb-3">
  <label for="kamar_mandi_art" class="form-label">Jumlah Kamar Mandi ART</label>
  <input type="number" class="form-control" name="kamar_mandi_art" id="kamar_mandi_art">
</div>
<label for="daya-listrik" class="form-label">Daya Listrik</label>
<div class="mb-3 input-group">
  <input type="number" class="form-control" id="daya_listrik" name="daya_listrik">
  <span class="input-group-text">WATT</span>
</div>
<div class="mb-3">
  <label for="orientasi_bangunan" class="form-label">Orientasi Bangunan</label>
  <select class="form-select" name="orientasi_bangunan" id="orientasi_bangunan">
  <option selected value="">Pilih Orientasi Bangunan</option>
  <option value="Utara">Utara</option>
  <option value="Selatan">Selatan</option>
  <option value="Timur">Timur</option>
  <option value="Barat">Barat</option>
</select>
</div>
<div class="mb-3">
  <label for="tahun_dibangun" class="form-label">Tahun Dibangun</label>
  <input type="number" class="form-control" name="tahun_dibangun" id="tahun_dibangun">
  <div id="tahun_dibangunHelp" class="form-text">* Contoh: 2021</div>
</div>
<div class="mb-3">
  <label for="interior" class="form-label">Interior</label>
  <select class="form-select" name="interior" id="interior">
  <option selected value="">Pilih Interior</option>
  <option value="Full Fournished">Full Fournished</option>
  <option value="Non-Fournish">Non-Fournish</option>
</select>
</div>
<div class="mb-3">
  <label for="fasilitas" class="form-label">Fasilitas</label>
  <textarea class="form-control" id="fasilitas" name="fasilitas" rows="3"></textarea>
</div>
<div class="mb-3">
  <label for="interior" class="form-label">PDAM</label>
  <select class="form-select" name="interior" id="interior">
  <option selected value="">Apakah menggunakan PDAM?</option>
  <option value="1">Ya</option>
  <option value="0">Tidak</option>
</select>
</div>
<div class="mb-3">
  <label for="harga" class="form-label">Harga</label>
  <input type="number" class="form-control" name="harga" id="harga">
</div>
<div class="mb-3">
  <label for="cicilan" class="form-label">Cicilan</label>
  <input type="text" class="form-control" name="cicilan" id="cicilan">
</div>
<div class="mb-3">
  <label for="uang_muka" class="form-label">Uang Muka</label>
  <select class="form-select" name="uang_muka" id="uang_muka">
  <option value="1">Ya</option>
  <option selected value="0">Tidak</option>
</select>
</div>
<div class="mb-3">
  <label for="nego" class="form-label">Nego</label>
  <select class="form-select" name="nego" id="nego">
  <option value="1">Ya</option>
  <option selected value="0">Tidak</option>
</select>
</div>
<div class="mb-3">
  <label for="harga_uang_muka" class="form-label">Harga Uang Muka</label>
  <input type="number" class="form-control" name="harga_uang_muka" id="harga_uang_muka">
  <div id="humHelp" class="form-text">* Opsional</div>
</div>
<div class="mb-3">
  <label for="longitude" class="form-label">Longitude</label>
  <input type="text" class="form-control" name="longitude" id="longitude">
</div>
<div class="mb-3">
  <label for="latitude" class="form-label">Latitude</label>
  <input type="text" class="form-control" name="latitude" id="latitude">
</div>
<div class="mb-3">
  <label for="whatsapp" class="form-label">WhatsApp</label>
  <input type="number" class="form-control" name="whatsapp" id="whatsapp">
</div>
<div class="mb-3">
  <label for="kontak" class="form-label">Kontak</label>
  <input type="number" class="form-control" name="kontak" id="kontak">
</div>
<input name="tayang" value="0" type="hidden" required>
<div class="mb-3">
  <label for="pet_allowed" class="form-label">Pet Allowed?</label>
  <select class="form-select" name="pet_allowed" id="pet_allowed">
  <option selected value="">Apakah hewan diperbolehkan masuk?</option>
  <option value="1">Ya</option>
  <option value="0">Tidak</option>
</select>
</div>
<button type="submit" class="btn btn-success">Simpan</button>
</form>

</div>
</div>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js">
</script>
<script>
  CKEDITOR.replace('tambah_voucher');
  CKEDITOR.replace('fasilitas');
</script>


@endsection