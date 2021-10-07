@extends('layout.master')

@section('judul')
Pengaturan
@endsection

@section('mainjudul')
Pengaturan
@endsection

@section('subjudul')
\ Pengaturan
@endsection

@section('body')
<?php if(Session::has('sukses')) { ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php } else if (Session::has('gagal')) { ?>

<div class="alert alert-danger" role="alert">
    {{Session('gagal')}}
</div>
<?php } ?>
<div class="card mb-4">
<div class="card-body">
<a href="/pengaturan"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<h5>Gambar Kategori</h5>
<hr>
<table class="table table-bordered" id="datatablesSimple">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Gambar</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0;
            foreach ($gambar as $faqs) : ?>
    <tr>
        <td><?= $count = $count + 1;?></td>
        <td>{{$faqs->nama}}</td>
        <td><img src="{{$faqs->gambar}}" width=100px height=100px></td>
        <td><a href="/pengaturan/{{$faqs->id}}/ubah"><button class="btn btn-warning" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></button></a>
                </tr>
    <?php endforeach; ?>
</table>
            </div>
            </div>


<div class="card mb-4">
<div class="card-body">
<h5>Pesan WhatsApp</h5>
<hr>
<table class="table table-bordered" id="datatablesSimple">
    <tr>
        <th>Bulan</th>
        <th>Properti</th>
        <th>Pesan</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0;
            foreach ($pesan as $pesans) : ?>
    <tr>
        <td>{{$pesans->bulan}}</td>
        <td>{{$pesans->user}}</td>
        <td>{{$pesans->pesan}}</td>
        <td>{{$pesans->harga}}</td>
        <td><a href="/pengaturan/pesan/{{$pesans->id}}/ubah"><button class="btn btn-warning" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></button></a>
                </tr>
    <?php endforeach; ?>
</table>
            </div>
            </div>

@endsection