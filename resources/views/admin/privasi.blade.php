@extends('layout.master')

@section('judul')
Privacy Policy
@endsection

@section('mainjudul')
Kebijakan Privasi
@endsection

@section('subjudul')
\ Privasi
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">

<?php foreach ($privasi as $privacy) : ?>
<a href="/privacy/{{$privacy->id}}/edit"><button type="button" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button></a>
<a href="/privacy"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
   <h2> <center> {{$privacy->judul}}</center></h2>
    <p>{!! $privacy->isi !!}</p>
    <br>
    <?php endforeach; ?>
</div>
</div>
@endsection