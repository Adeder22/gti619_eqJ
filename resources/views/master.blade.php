<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GTI619 LAB5</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color:rgb(239, 229, 229);
        }

        .card {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 50%;
            border-radius: 25px;
            text-align: center;
            background-color:rgb(86, 109, 185);
            color: white;
        }

        .card-body {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        #bottom {
            position: absolute;
            right: 3%;
            bottom: -8%;
        }

        .alert {
            position: absolute;
            left: 15%;
            right: 15%;
            text-align: center;
        }

        @media screen and (max-width: 400px) {

            .form-control, .btn-primary {
                font-size: 2vw;
            }

            a {
                font-size: 2.5vw;
            }
            
        }
        
    </style>
</head>
<body>
    @if(Auth::check())
        <a href="{{ url('/dashboard') }}" class="btn btn-primary" >Tableau de bord</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Se déconnecter</button>
        </form>
    @else
        <a href="{{ url('/login') }}">Se connecter</a>
    @endif

<div class="container">
   @yield('content')
</div>
 
</body>
</html>