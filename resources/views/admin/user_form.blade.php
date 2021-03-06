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
                {{csrf_field()}}
                <div id="Nama" class="mb-3">
                    <label class="form-label" for="nama">Nama</label>
                    <input class="form-control" id="nama" name="nama" type="text" required>
                </div>
                <div class="col-lg-12" style="display: flex;">
                    <div class="col-md-6">
                        <div id="Email" class="mb-3">
                            <label class="form-label" for="email">E-mail</label>
                            <input class="form-control" id="email" name="email" type="email" required>
                            @if($errors->has('email'))
                                <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-5">
                        <div id="WhatsApp" class="mb-3">
                            <label class="form-label" for="whatsapp">No. WhatsApp</label>
                            <input class="form-control" id="whatsapp" maxlength="13" name="whatsapp" type="number" required>
                            <strong>* Gunakan format 62</strong>
                            @if($errors->has('whatsapp'))
                                <div class="error" style="color: red;">{{ $errors->first('whatsapp') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="Password" class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" minlength="8" name="password" type="password" required>
                    <br/>
                    <span id="StrengthDisp" class="badge displayBadge">Weak</span>
                </div>
                <div id="submit" class="mb-3">
                    <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let timeout;

        let password = document.getElementById('password')
        let strengthBadge = document.getElementById('StrengthDisp')

        let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
        let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')

        function StrengthChecker(PasswordParameter){

            if(strongPassword.test(PasswordParameter)) {
                strengthBadge.style.backgroundColor = "green"
                strengthBadge.textContent = 'Strong'
            } else if(mediumPassword.test(PasswordParameter)){
                strengthBadge.style.backgroundColor = 'blue'
                strengthBadge.textContent = 'Medium'
            } else{
                strengthBadge.style.backgroundColor = 'red'
                strengthBadge.textContent = 'Weak'
            }
        }

        password.addEventListener("input", () => {

            strengthBadge.style.display= 'block'
            clearTimeout(timeout);

            timeout = setTimeout(() => StrengthChecker(password.value), 500);

            if(password.value.length !== 0){
                strengthBadge.style.display != 'block'
            } else{
                strengthBadge.style.display = 'none'
            }
        });
    </script>
@endsection
