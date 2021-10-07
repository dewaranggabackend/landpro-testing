@extends('layout.master')

@section('judul')
Buat Voucher
@endsection

@section('mainjudul')
Buat Voucher Baru
@endsection

@section('subjudul')
\ Voucher \ Tambah
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">
<a href="/voucher"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<form action="/voucher/tambah" method="POST">
{{ csrf_field() }}
<label for="voucher" class="form-label">Kode Voucher</label>
<div class="input-group mb-3">
  <input type="text" max-length="15" id="voucher" name="voucher" class="form-control" placeholder="Generate kode voucher.." readonly required>
  <button class="btn btn-primary" type="button" id="button-addon2" onclick="copy();"><i class="fas fa-copy"></i></button>
  <button type="button" id="generate" class="btn btn-primary" onclick="
    randomString(15,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    ">Generate</button>
</div>
<div class="mb-3">
  <label for="durasi" class="form-label">Durasi</label>
  <select class="form-select" aria-label="Default select example" name="durasi">
  <option value="1">30 Hari</option>
  <option value="2">90 Hari</option>
  <option value="3">180 Hari</option>
</select>
</div>
<div class="form-check">
  <input id="sp" class="form-check-input" name="continuous" type="checkbox" value="1" id="flexCheckDefault">
  <label for="sp" class="form-check-label" for="flexCheckDefault">
    Jangka Panjang
  </label>
</div>
<br>
<button type="submit" class="btn btn-success">Simpan</button>
</form>

</div>
</div>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js">
</script>
<script>
  CKEDITOR.replace('tambah_voucher');

  function copy() {
  var copyText = document.getElementById("voucher");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  }

  function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return document.querySelector('#voucher').value = result;
  }

</script>

@endsection
