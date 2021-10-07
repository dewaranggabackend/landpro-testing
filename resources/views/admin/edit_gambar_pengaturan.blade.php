@extends('layout.master')

@section('judul')
Edit Thumbail
@endsection

@section('mainjudul')
Edit Thumbail
@endsection

@section('subjudul')
\ Pengaturan \ Gambar Kategori \ Edit
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
<?php   $count = 0;
            foreach ($gambar as $faqs) : ?>
            <a href="/pengaturan"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></a>
<a href="/pengaturan/{{$faqs->id}}/ubah"><button type="button" class="btn btn-primary" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync" aria-hidden="true"></i></button></a>
            </div>
            </div>
<div class="card mb-4">
<div class="card-body">
<form action="/pengaturan/{{$faqs->id}}/ubah" method="POST" enctype="multipart/form-data">
@csrf
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body">{{$faqs->nama}}</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <input name="gambar" type="file" class="small text-white stretched-link" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
            </form>
                   
            </div>
            </div>
            <?php endforeach; ?>

@endsection