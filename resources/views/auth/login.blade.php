@extends('master')

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h2>Se connecter au compte</h2>
                </div>
                <input type="text" class="form-control" id="nameInput" placeholder="Nom d'utilisateur" name="name" required>
                    @error('name') <p class="fw-bold text-danger">{{ $message }}</p> @enderror
                <br />
                <input type="password" class="form-control" id="passwordInput" placeholder="Mot de passe" name="password" required>
                    @error('password') <p class="fw-bold text-danger">{{ $message }}</p> @enderror
                <br />
                <button class="btn btn-primary" type="submit">Se connecter</button>
                <div>
                    <a href="{{ url('/password') }}" class="btn btn-secondary">Mot de passe oublié ?</a>
                </div>
            </div>
            <div id="bottom">
                <a href="{{ url('/register') }}">Vous n'avez pas encore de compte ?</a>
            </div>
        </div>
    </form>
@endsection
