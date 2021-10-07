@extends('layout.master')

@section('judul')
Request
@endsection

@section('mainjudul')
Request
@endsection

@section('subjudul')
\ Request \ Search
@endsection

@section('body')
<div class="card mb-4">
<div class="card-body">
<a href="/users/request"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></a>
<form class="d-md-inline-block" style="float: right;" method="GET" action="/users/request/search">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Cari identifier..." name="cari" aria-describedby="btnNavbarSearch" />
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
        <th>Identifier</th>
        <th>Kandidat</th>
        <th>Diajukan Pada</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0;
            foreach ($result as $faqs) : ?>
    <tr>
        <td><?= $count = $count + 1;?></td>
        <td>{{$faqs->id}}</td>
    <td>{{$faqs->nama->name}}</td>
    <td>{{$faqs->created_at}}</td>
        <td><a href="/users/{{$faqs->id}}/request/setuju" onclick="return confirm('Apakah kamu yakin?')"><button class="btn btn-success" data-toggle="tooltip" title="Setujui"><i class="fa fa-check"></i></button></a>
        <a href="/users/{{$faqs->id}}/request/tolak" onclick="return confirm('Apakah kamu yakin?')"><button class="btn btn-danger" data-toggle="tooltip" title="Tolak"><i class="fa fa-times"></i></button></a></td>
                </tr>
    <?php endforeach; ?>
</table>
            </div>
            <br>
            </div>
            </div>
@endsection
