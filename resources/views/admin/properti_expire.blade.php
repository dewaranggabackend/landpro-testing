@extends('layout.master')

@section('judul')
Properti Kadaluwarsa
@endsection

@section('mainjudul')
Properti Kadaluwarsa
@endsection

@section('subjudul')
\ Properti \ Kadaluwarsa
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>

<?php if(Session::has('gagal')) : ?>

<div class="alert alert-danger" role="alert">
    {{Session('gagal')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">
<a href="/properti/expire"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
<a href="/properti/expire/fresh"><button class="btn btn-danger" data-toggle="tooltip" title="Hard Refresh"><i class="fas fa-asterisk"></i></button></a>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<div class="scroll">
<table class="table table-bordered" id="datatablesSimple">
    <tr>
        <th>No</th>
        <th>Foto Properti</th>
        <th>Kategori</th>
        <th>Nama Properti</th>
        <th>Lokasi</th>
        <th>User</th>
        <th>Harga</th>
        <th>Status</th>
        <th>Berakhir Pada</th>
        <th>Kontak</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0; 
                foreach ($properties as $properti) : ?>
    <tr>
        <td><?= $count = $count + 1 ?></td>
        <td><img src="/{{$properti->foto_tampak_depan}}" width=100px height=100px></td>
        <td>{{$properti->category->nama}}</td>
        <td>{{$properti->nama}}</td>
        <td><a href="{{$properti->alamat_gmap}}" style="text-decoration: none;"><i class="fas fa-map-marker-alt"></i> &nbsp;Lihat</a></td>
        <td><?php if (!isset($properti->pengguna->name)) {
            echo "Pengguna dihapus";
        } else { 
            echo $properti->pengguna->name;
        } ?></td>
        <td><?php 
            echo "Rp " . number_format($properti->harga,2,',','.');
        ?></td>
        <td><?php 
            if ($properti->tayang !== 0) {
                echo "Tayang";
            } else {
                echo "Belum tayang";
            }
        ?></td>
        <td><?php
        if ($properti->exp == null) {
            "";
        } else {
            echo date('d F Y', strtotime($properti->exp));
        }
    ?></td>
        <td><a href="tel:{{$properti->kontak}}"><button type="button" class="btn btn-secondary"><i class="fa fa-phone-alt"></i></button></a>
        <a href="https://wa.me/{{$properti->whatsapp}}"><button type="button" class="btn btn-success"><i class="fab fa-whatsapp"></i></button></a>
    </td>
        <td>
        <a href="/properti/{{$properti->id}}/detail"><button class="btn btn-primary">Detail</button></a></td>
    </tr>
    <?php endforeach; ?>
</table>
        </div>
        <br>
{{$properties->links()}}
                </div>
                </div>
@endsection