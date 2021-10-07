@extends('layout.master')

@section('judul')
Edit Pesan WhatsApp
@endsection

@section('mainjudul')
Edit Pesan WhatsApp
@endsection

@section('subjudul')
\ Pengaturan \ Pesan \ Edit
@endsection

@section('body')
<?php if(Session::has('gagal')) : ?>

<div class="alert alert-danger" role="alert">
    {{Session('gagal')}}
</div>

<?php endif; ?>

<div class="card mb-4">
<div class="card-body">
<a href="/pengaturan"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<?php foreach ($pesan as $info) : ?>
<form action="/pengaturan/pesan/{{$info->id}}/edit" method="POST">
{{ csrf_field() }}
<div class="mb-3">
  <label for="isi" class="form-label">Pesan</label>
  <textarea class="form-control" id="edit_informasi" name="pesan" rows="10" required>{{$info->pesan}}</textarea>
</div>
<div class="mb-3">
  <label for="harga" class="form-label">Harga</label>
  <input type="number" class="form-control" id="harga" name="harga" value="{{$info->harga}}" required>
</div>
<button type="submit" class="btn btn-success">Simpan</button>
</form>
<?php endforeach; ?>

</div>
</div>


@endsection