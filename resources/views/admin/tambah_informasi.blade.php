@extends('layout.master')

@section('judul')
Tambah Informasi
@endsection

@section('mainjudul')
Tambah Informasi
@endsection

@section('subjudul')
\ Informasi \ Tambah
@endsection

@section('body')
<?php if(Session::has('gagal')) : ?>

<div class="alert alert-danger" role="alert">
    {{Session('gagal')}}
</div>
<?php endif; ?>

<div class="card mb-4">
<div class="card-body">
<a href="/informasi"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<form action="/informasi/tambah" method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="mb-3">
  <label for="judul" class="form-label">Judul</label>
  <input type="text" class="form-control" id="judul" name="judul" required>
</div>
<div class="mb-3">
  <label for="isi" class="form-label">Isi</label>
  <textarea class="form-control" id="tambah_informasi" name="isi" rows="20" required></textarea>
</div>
<div class="mb-3">
  <label class="form-label">Thumbnail</label>
  <input class="form-control" type="file" name="gambar" required>
</div>
<button type="submit" class="btn btn-success">Simpan</button>
</form>

</div>
</div>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js">
</script>
<script>
  CKEDITOR.replace('tambah_informasi');
</script>


@endsection