@extends('layout.master')

@section('judul')
Tentang Kami
@endsection

@section('mainjudul')
Tentang Kami
@endsection

@section('subjudul')
\ Tentang
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">

<?php foreach ($tentang as $about) : ?>
<a href="/tentang/{{$about->id}}/edit"><button type="button" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button></a>
<a href="/tentang"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
   <h2> <center> {{$about->judul}}</center></h2>
    <p>{!! $about->isi !!}</p>
    <br>
    <?php endforeach; ?>
</div>
</div>
@endsection