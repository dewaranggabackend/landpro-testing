@extends('layout.master')

@section('judul')
FAQ
@endsection

@section('mainjudul')
FAQ
@endsection

@section('subjudul')
\ FAQ \ Search
@endsection

@section('body')
<div class="card mb-4">
<div class="card-body">
<a href="/faq/tambah"><button type="button" class="btn btn-success" data-toggle="tooltip" title="Tambah FAQ Baru"><i class="fa fa-plus"></i></button></a>
<a href="/faq"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></a>
<form class="d-md-inline-block" style="float: right;" method="GET" action="/faq/search">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Cari faq..." name="cari" aria-describedby="btnNavbarSearch" />
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
        <th>Judul</th>
        <th>Isi</th>
        <th>Aksi</th>
    </tr>
    <?php   $count = 0;
            foreach ($result as $faqs) : ?>
    <tr>
        <td><?= $count = $count + 1;?></td>
        <td><?php if(strlen($faqs->judul) > 30) {
            echo substr($faqs->judul, 0, 30)."...";
        } else {
            echo "$faqs->judul";
        } ?></td>
        <td><?php if (strlen($faqs->isi) > 170) {
            echo substr($faqs->isi, 0, 170)."...";
        } else {
            echo "$faqs->isi";
        } ?></td>
         <td>
        <a href="/faq/{{$faqs->id}}/edit"><button class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button></a>
        <a href="/faq/{{$faqs->id}}/hapus" onclick="return confirm('Apakah kamu yakin?')"><button class="btn btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button></a>
        <a href="/faq/{{$faqs->id}}"><button class="btn btn-info">Lihat</button></a></td>
       
                </tr>
    <?php endforeach; ?>
</table>
    </div>
    <br>
            </div>
            </div>

@endsection