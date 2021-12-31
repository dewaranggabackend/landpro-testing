@extends('layout.master')

@section('judul')
Akun Terbanned
@endsection

@section('mainjudul')
Akun Terbanned
@endsection

@section('subjudul')
\ Ban \ Search
@endsection

@section('body')
<div class="card mb-4">
<div class="card-body">
<a href="/users/banned"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></a>
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
              foreach ($result as $banned_user) : ?>
    <tr>
       <?php if ($banned_user->deleted_at == null) {
           echo "";
       } 
       if ($banned_user != null) : ?>
              <td><?= $count = $count + 1 ?></td>
              <td>{{$banned_user->id}}</td>
              <td>{{$banned_user->name}}</td>
              <td>{{$banned_user->roles->nama}}</td>
              <td>{{$banned_user->deleted_at}}</td>
              <td><a href="/users/{{$banned_user->id}}/unban" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-success" data-toggle="tooltip" title="Unban"><i class="fas fa-chevron-up"></i></button></a>
              <a href="/users/{{$banned_user->id}}/hapus" onclick="return confirm('Apakah kamu yakin?')"><button type="button" class="btn btn-danger" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button></a>
            </td>
            <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>
              </div>
              <br>
              </div>
              </div>

@endsection
