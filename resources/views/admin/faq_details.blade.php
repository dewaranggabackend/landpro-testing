@extends('layout.master')

@section('judul')
<?php foreach ($faq as $faqs) : ?>
{{$faqs->judul}}
@endsection


@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">
 <a href="/faq"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>
 <a href="/faq/{{$faqs->id}}/edit"><button type="button" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button></a>
 <a href="/faq/{{$faqs->id}}/hapus" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button></a>
</div>
</div>
 <div class="card mb-4">
<div class="card-body">
   <h2> <center> {{$faqs->judul}}</center></h2>
    <p> <center>{!! $faqs->isi !!}</center></p>
    <br>
    <?php endforeach; ?>
</div>
</div>
@endsection