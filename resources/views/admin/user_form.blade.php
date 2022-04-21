@extends('layout.master')

@section('judul')
    Tambah Customer Service
@endsection

@section('mainjudul')
    Tambah Customer Service Baru
@endsection

@section('subjudul')
    \ Users \ Customer Service \ Create
@endsection

@section('body')
    <div class="card mb-4">
        <div class="card-body">
            <a href="/users"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali ke List User"><i class="fa fa-arrow-left"></i></button></a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="/users/customer-service/create" method="POST">
                <div id="Nama">
                    <label for="nama">Nama</label>
                    <input id="nama" type="text" required>
                </div>
            </form>
        </div>
    </div>
@endsection
