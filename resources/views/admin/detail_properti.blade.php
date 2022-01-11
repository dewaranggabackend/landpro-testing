@extends('layout.master')

@section('judul')
<?php foreach ($properti as $properties) : ?>
{{$properties->nama}}
<?php endforeach; ?>
@endsection


@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="card mb-4">
<div class="card-body">
 <a href="/properti"><button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i></button></a>
 <a href="/properti/{{$properties->id}}/off"><button type="button" class="btn btn-danger" onclick="return confirm('Apakah kamu yakin?')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button></a>
</div>
</div>
</div>
</div>
<br>
<div class="row">
                            <div class="shadow bg-white rounded">
                                <br>
 <div class="card mb-4">
<div class="card-body">
<?php foreach ($properti as $properties) : ?>
   <h1> <center> {{$properties->nama}} <a href="{{$properties->alamat_gmap}}"><i class="fas fa-map-marker"></i></a></center></h1>
   <center>
  
   </div>
</div>
</div>
</div>
<br>
<div class="row">
                            <div class="shadow bg-white rounded">
                                <br>
 <div class="card mb-4">
<div class="card-body">
   <center><img src="/{{$properties->foto_tampak_depan}}" width=400px height=400px>
   <img src="/{{$properties->foto_tampak_ruangan}}" width=400px height=400px>
   <img src="/{{$properties->foto_tampak_jalan}}" width=400px height=400px></center>
   </div>
</div>
</div>
</div>
<br>
<div class="row">
                            <div class="shadow bg-white rounded">
                                <br>
 <div class="card mb-4">
<div class="card-body">
<center>
<p style="color: #FF7A00; font-size: 40px; font-style: bold;"><?php $temp = $properties->harga;
        $english_format_number = number_format($temp);
        echo "Rp. $english_format_number";
    ?></p>
      <p style="font-size: 30px;">{!! $properties->nama !!}</p>
     </center>
     <center>
        <p>{!! $properties->deskripsi !!}</p>
    </center>
   </div>
</div>
</div>
</div>
<br>
<div class="row">
                            <div class="shadow bg-white rounded">
                                <br>
 <div class="card mb-4">
<div class="card-body">
    </center>
    <div class="table-responsive-xl">
    <table class="table table-bordered" id="datatablesSimple">
        <tr>
            <th>Kamar Tidur</th>
            <th>Kamar Mandi</th>
            <th>Luas Bangunan</th>
            <th>Jumlah Lantai</th>
            <th>Kamar Tidur ART</th>
            <th>Kamar Mandi ART</th>
            <th>Daya Listrik</th>
            <th>Orientasi Bangunan</th>
            <th>Tahun Dibangun</th>
            <th>Interior</th>
            <th>Sertifikat</th>
            <th>Umur Bangunan</th>
            <th>Fasilitas</th>
        </tr>
   
    <tr>
    <td>{{$properties->kamar_tidur}}</td>
    <td>{{$properties->kamar_mandi}}</td>
    <td>{{$properties->luas_bangunan}}</td>
  
    <td>{{$properties->jumlah_lantai}}</td>
    <td>{{$properties->kamar_tidur_art}}</td>
    <td>{{$properties->kamar_mandi_art}}</td>
    <td>{{$properties->daya_listrik}}</td>
    <td>{{$properties->orientasi_bangunan}}</td>
    <td>{{$properties->tahun_dibangun}}</td>
    <td>{{$properties->interior}}</td>
    <td>{{$properties->sertifikat}}</td>
    <td>{{$properties->umur_bangunan}}</td>
    <td>{!! $properties->fasilitas !!}</td>
    </tr>
    <?php endforeach; ?>
   

    </table>
    
    </div>
</div>
</div>
</div>
</div>
@endsection