@extends('layout.master')

@section('judul')
Akun Terban
@endsection

@section('mainjudul')
Akun Terban
@endsection

@section('subjudul')
\ Ban
@endsection

@section('body')

<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">

<a href="/users/banned"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>

<form class="d-md-inline-block" style="float: right;" method="GET" action="/users/banned/search">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Cari UID..." name="cari" aria-describedby="btnNavbarSearch" />
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
        <th>UID</th>
        <th>Nama</th>
        <th>Role</th>
        <th>Tanggal Banned</th>
        <th>Aksi</th>
    </tr>
    <?php $count = 0;
              foreach ($banned_users as $banned_user) : ?>
    <tr>
       
              <td><?= $count = $count + 1 ?></td>
              <td>{{$banned_user->id}}</td>
              <td>{{$banned_user->name}}</td>
              <td>{{$banned_user->roles->nama}}</td>
              <td>{{$banned_user->deleted_at}}</td>
              <td>
              <a href="/users/{{$banned_user->id}}/unban" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-success" data-toggle="tooltip" title="Unban"><i class="fas fa-chevron-up"></i></button></a>
              <a href="/users/{{$banned_user->id}}/hapus" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-danger" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button></a>
            </td>
    </tr>
    <?php endforeach; ?>
</table>
              </div>
              <br>
{{$banned_users->links()}}
              </div>
              </div>
@endsection