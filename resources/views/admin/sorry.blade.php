<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    div {
        position: absolute;
        margin: auto;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 200px;
        height: 200px;
    }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorry</title>
</head>
    <body>
        <div>
            <center>
            <h1>
                <b>
                Maaf,
                </b>
            </h1> 
            <p>Hanya admin yang dapat mengakses halaman ini.
            </p>
            <p>Jika anda adalah admin, silahkan <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form></a></p>
            </center> 
        </div>
  </body>
  <script>
      event.preventDefault();
  </script>
</html>
