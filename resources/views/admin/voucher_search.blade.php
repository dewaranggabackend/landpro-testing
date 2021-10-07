@extends('layout.master')

@section('judul')
Voucher
@endsection

@section('mainjudul')
Voucher
@endsection

@section('subjudul')
\ Voucher \ Search
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
<a href="/voucher/tambah"><button type="button" class="btn btn-success" data-toggle="tooltip" title="Tambah Voucher"><i class="fa fa-plus"></i></button></a>
<a href="/voucher"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></a>
<form class="d-md-inline-block" style="float: right;" method="GET" action="/voucher/search">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Cari voucher..." name="voucher" aria-describedby="btnNavbarSearch" />
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
        <th>Kode</th>
        <th>Durasi</th>
        <th>Berakhir Pada</th>
        <th>Tipe</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0;
            foreach ($result as $pengguna) : ?>
    <tr>
        <td><?= $count = $count + 1;?></td>
        <td>{{$pengguna->voucher}}</td>
    <td><?php if ($pengguna->durasi === 1) {
        echo "1 Bulan";
    } else if ($pengguna->durasi === 2) {
        echo "3 Bulan";
    } else if ($pengguna->durasi === 3) {
        echo "6 Bulan";
    } ?></td>
     <td><?php 
        echo date('d F Y', strtotime($pengguna->expiry_date));
    ?></td>
    <td><?php 
        if ($pengguna->continuous == 1) {
            echo "Jangka Panjang";
        } else {
            echo "Sekali Pakai";
        }
    ?></td>
        <td><a href="/voucher/{{$pengguna->id}}/hapus" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button></a></td>
                </tr>
    <?php endforeach; ?>
</table>
</div>
<br>
            </div>
            </div>

@endsection
