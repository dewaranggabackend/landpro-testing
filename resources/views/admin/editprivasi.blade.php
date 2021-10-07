@extends('layout.master')

@section('judul')
Privacy Policy
@endsection

@section('mainjudul')
Kebijakan Privasi
@endsection

@section('subjudul')
\ Privasi \ Edit
@endsection

@section('body')

<div class="card mb-4">
<div class="card-body">
<a href="/privacy"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<?php foreach ($privasi as $privacy) : ?>

<form action="/privacy/{{$privacy->id}}/edit" method="POST">
{{ csrf_field() }}
<div class="mb-3">
  <label for="judul" class="form-label">Judul</label>
  <input type="text" class="form-control" id="judul" name="judul" value="{{$privacy->judul}}">
</div>
<div class="mb-3">
  <label for="isi" class="form-label">Isi</label>
  <textarea class="form-control" id="edit_privasi" name="isi" rows="20">{{$privacy->isi}}</textarea>
</div>
<button type="submit" class="btn btn-success">Simpan</button>
</form>

</div>
</div>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js">
</script>
<script>
  CKEDITOR.replace('edit_privasi');
</script>

<?php endforeach; ?>

@endsection