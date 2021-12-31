@extends('layout.master')

@section('judul')
Informasi
@endsection

@section('mainjudul')
Informasi
@endsection

@section('subjudul')
\ Informasi
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
<a href="/informasi/tambah"><button type="button" class="btn btn-success" data-toggle="tooltip" title="Tambah Informasi Baru"><i class="fa fa-plus"></i></button></a>
<a href="/informasi"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
<form class="d-md-inline-block" style="float: right;" method="GET" action="/informasi/search">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Cari informasi..." name="cari" aria-describedby="btnNavbarSearch" />
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
        <th>Foto Informasi</th>
        <th>Judul</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0;
            foreach ($informasi as $faqs) : ?>
    <tr>
        <td><?= $count = $count + 1;?></td>
        <td><img src="/{{$faqs->gambar}}" width=100px height=100px></td>
        <td><?php if(strlen($faqs->judul) > 30) {
            echo substr($faqs->judul, 0, 30)."...";
        } else {
            echo "$faqs->judul";
        } ?></td>
        <td>
        <a href="/informasi/{{$faqs->id}}/edit"><button class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button></a>
        <a href="/informasi/{{$faqs->id}}/hapus"><button class="btn btn-danger" onclick="return confirm('Apakah kamu yakin?')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button></a>
        <a href="/informasi/{{$faqs->id}}"><button class="btn btn-info">Lihat</button></a></td>
                </tr>
    <?php endforeach; ?>
</table>
    </div>
    <br>
{{$informasi->links()}}
            </div>
            </div>

@endsection