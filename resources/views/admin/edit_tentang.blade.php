@extends('layout.master')

@section('judul')
Tentang Kami
@endsection

@section('mainjudul')
Tentang Kami
@endsection

@section('subjudul')
\ Tentang \ Edit
@endsection

@section('body')

<div class="card mb-4">
<div class="card-body">
<a href="/tentang"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<?php foreach ($tentang as $about) : ?>

<form action="/tentang/{{$about->id}}/edit" method="POST">
{{ csrf_field() }}
<div class="mb-3">
  <label for="judul" class="form-label">Judul</label>
  <input type="text" class="form-control" id="judul" name="judul" value="{{$about->judul}}">
</div>
<div class="mb-3">
  <label for="isi" class="form-label">Isi</label>
  <textarea class="form-control" id="edit_tentang" name="isi" rows="20">{{$about->isi}}</textarea>
</div>
<button type="submit" class="btn btn-success">Simpan</button>
</form>

</div>
</div>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js">
</script>
<script>
  CKEDITOR.replace('edit_tentang');
</script>

<?php endforeach; ?>

@endsection