@extends('layout.master')

@section('judul')
Kategori
@endsection
@section('mainjudul')
Kategori
@endsection

@section('subjudul')
\ Kategori
@endsection

@section('body')
<div class="card mb-4">
<div class="card-body">
<a href="/kategori"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<table class="table table-bordered" id="datatablesSimple">
    <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Slug</th>
    </tr>
    <?php   $count = 0;
            foreach ($category as $kategori) :  ?>
    <tr>
        <td><?= $count = $count + 1; ?></td>
        <td>{{$kategori->nama}}</td>
        <td>{{$kategori->slug}}</td>
    <?php endforeach; ?>
    </tr>
</table>
            </div>
            </div>
@endsection