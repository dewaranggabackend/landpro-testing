@extends('layout.master')

@section('judul')
Kelola Akun
@endsection

@section('mainjudul')
Pengguna Terdaftar
@endsection

@section('subjudul')
\ User
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
<a href="/users"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
<a href="/users/export"><button class="btn btn-success" data-toggle="tooltip" title="Ekspor ke Excel"><i class="fas fa-file-excel"></i></button></a>
<form class="d-md-inline-block" style="float: right;" method="GET" action="/users/search">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Cari pengguna..." name="cari" aria-describedby="btnNavbarSearch" />
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
        <th>Nama User</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0;
            foreach ($user as $pengguna) : ?>
    <tr>
        <td><?= $count = $count + 1; $role = $pengguna->roles ?></td>
        <td>{{$pengguna->name}}</td>
        <td>{{$pengguna->email}}</td>
        <td>{{$role->nama}}</td>
        <?php if ($pengguna->role != 1) { ?>
            <?php if ($pengguna->role == 2) { ?>
        <td>
        <a href="/users/{{$pengguna->id}}/ban" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-danger" data-toggle="tooltip" title="Banned"><i class="fa fa-times"></i></button></a>
        <a href="/users/{{$pengguna->id}}/downgrade" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Downgrade"><i class="fa fa-chevron-down"></i></button></a>
                </td>
                <?php } else { ?>
                    <td>
                    <a href="/users/{{$pengguna->id}}/ban" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-danger" data-toggle="tooltip" title="Banned"><i class="fa fa-times"></i></button></a>
        <a href="/users/{{$pengguna->id}}/upgrade" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-success" data-toggle="tooltip" title="Upgrade"><i class="fa fa-chevron-up"></i></button></a>
        <a href="/users/{{$pengguna->id}}/downgrade" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Downgrade"><i class="fa fa-chevron-down"></i></button></a>
        </td>            
        <?php }} ?>
        <?php endforeach; ?>
                </tr>
</table>
            </div>
            <br>
{{$user->links()}}
            </div>
</div>

@endsection