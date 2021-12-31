@extends('layout.master')

@section('judul')
Trash
@endsection

@section('mainjudul')
Properti Dihapus
@endsection

@section('subjudul')
\ Trash
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">
<a href="/properti/nonaktif"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
<form class="d-md-inline-block" style="float: right;" method="GET" action="/properti/nonaktif/search">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Cari TID..." name="cari" aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-secondary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
</div>
</div>
            <div class="card mb-4">
<div class="card-body">
<div class="scroll">
<table class="table table-bordered" id="datatablesSimple">
    <tr>
        <th>No</th>
        <th>TID</th>
        <th>Foto Properti</th>
        <th>Kategori</th>
        <th>Nama Properti</th>
        <th>Lokasi</th>
        <th>User</th>
        <th>Harga</th>
        <th>Dihapus Pada</th>
        <th>Kontak</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0; 
                foreach ($properties as $properti) : ?>
    <tr>
        <td><?= $count = $count + 1 ?></td>
        <td>{{$properti->id}}</td>
        <td><img src="/{{$properti->foto_tampak_depan}}" width=100px height=100px></td>
        <td>{{$properti->category->nama}}</td>
        <td>{{$properti->nama}}</td>
        <td><a href="{{$properti->alamat_gmap}}"><i class="fas fa-map-marker-alt"></i> &nbsp;Lihat</a></td>
        <td><?php if (!isset($properti->pengguna->name)) {
            echo "Pengguna dihapus";
        } else { 
            echo $properti->pengguna->name;
        } ?></td>
        <td>{{$properti->harga}}</td>
        <td>{{$properti->deleted_at}}</td>
        <td><a href="tel:{{$properti->kontak}}"><button type="button" class="btn btn-secondary"><i class="fa fa-phone-alt"></i></button></a>
        <a href="https://wa.me/{{$properti->whatsapp}}"><button type="button" class="btn btn-success"><i class="fab fa-whatsapp"></i></button></a>
    </td>
        <td><a href="/properti/{{$properti->id}}/on"><button class="btn btn-success" onclick="return confirm('Apakah kamu yakin?')" data-toggle="tooltip" title="Recover"><i class="fa fa-chevron-up"></i></button></a>
        <a href="/properti/{{$properti->id}}/hapus"><button class="btn btn-danger" onclick="return confirm('Apakah kamu yakin?')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button></a></td>
    </tr>
    <?php endforeach; ?>
</table>
                </div>
                <br>
{{$properties->links()}}
                </div>
                </div>
@endsection
