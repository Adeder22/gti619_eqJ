<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authentification</title>
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
            height: 45%;
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
    <form action="#" method="POST">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h2>Se connecter au compte</h2>
                </div>
                <input type="text" class="form-control" id="usernameInput" placeholder="Nom d'utilisateur" name="username" required >
                <br />
                <input type="password" class="form-control" id="passwordInput" placeholder="Mot de passe" name="password" required >
                <br />
                <button class="btn btn-primary" type="submit" >Se connecter</button>
            </div>
            <div id="bottom">
                <a href="" >Vous n'avez pas encore de compte ?</a>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>