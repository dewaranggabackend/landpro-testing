@extends('layout.master')

@section('judul')
Dashboard
@endsection

@section('mainjudul')
Dashboard
@endsection

@section('subjudul')
\ Dashboard
@endsection

@section('body')
<?php if(Session::has('sukses')) : ?>

<div class="alert alert-success" role="alert">
    {{Session('sukses')}}
</div>
<?php endif; ?>
<div class="row">
<div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"> <i class="fa fa-user"></i> &nbsp;{{$user}} Pengguna Terdaftar</div>
                                    
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/users">Lihat</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body"> <i class="fa fa-user"></i> &nbsp;{{$banned_user}} Akun Terbanned</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/users/banned">Lihat</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body"> <i class="fa fa-house-user"></i> &nbsp;{{$properti}} Properti Aktif</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/properti">Lihat</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body"> <i class="fa fa-house-user"></i> &nbsp;{{$off_properti}} Properti Nonaktif</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/properti/nonaktif">Lihat</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
</div>
</div>
                            </div>
                            <br>
                            <div class="row">
                            <div class="shadow bg-white rounded">
                                <br>
                            <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Total Pengguna dalam 7 Hari Terakhir
                            </div>
                            <div class="card-body"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                            <div class="card-footer small text-muted">Diupdate pada {{date('d-m-Y');}}</div>
                        </div>
</div>
</div>
<br>
<div class="row">
                            <div class="shadow bg-white rounded">
                         
                        <div class="row">
                            <div class="col-lg-6">
                            <br>
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Pengguna Berdasarkan Role
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                                    <div class="card-footer small text-muted">Diupdate pada {{date('d-m-Y');}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <br>
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Kategori Properti
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                                    <div class="card-footer small text-muted">Diupdate pada {{date('d-m-Y');}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
</div>
</div>

@endsection

@section('script')
<script>
// Pie Chart
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Rumah", "Resedensial", "Tanah", "Kantor", "Ruang Usaha", "Apartemen", "Ruko"],
    datasets: [{
    data: [{{$properti_rumah}}, {{$properti_resedensial}},{{$properti_tanah}}, {{$properti_kantor}}, {{$properti_ruang}}, {{$properti_apartemen}}, {{$properti_ruko}}],
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#323232', '#bf00ff', '#FFC0CB'],
    }],
  },
});
</script>
<script>
// Bar Chart
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Agen", "Pencari"],
    datasets: [{
      label: "Total",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [{{$agen}}, {{$pencari}}],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 1000,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>
<script>
// Area Chart
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["7 Hari yang lalu", "6 Hari yang lalu", "5 Hari yang lalu", "4 Hari yang lalu", "3 Hari yang lalu", "2 Hari yang lalu", "Kemarin"],
    datasets: [{
      label: "Sessions",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [{{$seven}}, {{$six}}, {{$five}}, {{$four}}, {{$three}}, {{$two}}, {{$one}}],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 500,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>
@endsection