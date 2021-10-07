@extends('layout.master')

@section('judul')
Syarat Penggunaan
@endsection

@section('mainjudul')
Syarat Penggunaan
@endsection

@section('subjudul')
\ Syarat
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">

<?php foreach ($syarat as $syarats) : ?>
<a href="/syarat/{{$syarats->id}}/edit"><button type="button" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button></a>
<a href="/syarat"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
   <h2> <center> {{$syarats->judul}}</center></h2>
    <p>{!! $syarats->isi !!}</p>
    <br>
    <?php endforeach; ?>
</div>
</div>
@endsection