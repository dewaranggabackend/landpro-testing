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
                <div id="Nama" class="mb-3">
                    <label class="form-label" for="nama">Nama</label>
                    <input class="form-control" id="nama" name="nama" type="text" required>
                </div>
                <div class="col-lg-12" style="display: flex;">
                    <div class="col-md-6">
                        <div id="Email" class="mb-3">
                            <label class="form-label" for="email">E-mail</label>
                            <input class="form-control" id="email" name="email" type="email" required>
                        </div>
                    </div>
                    <br/>
                    <div class="col-md-6">
                        <div id="WhatsApp" class="mb-3">
                            <label class="form-label" for="whatsapp">No. WhatsApp</label>
                            <input class="form-control" id="whatsapp" name="whatsapp" type="number" required>
                        </div>
                    </div>
                </div>
                <div id="Password" class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
            </form>
        </div>
    </div>
@endsection
