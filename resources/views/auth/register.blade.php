@extends('master')

@section('content')
<div class="container">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h2>Créer un compte</h2>
                </div>
                <input type="text" class="form-control" placeholder="Nom d'utilisateur" name="name" required>
                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                <br />

                <select class="form-control" name="role_id" required>
                    <option value="" disabled selected>Choisissez un rôle</option>
                    <option value="1">Préposé aux clients résidentiels</option>
                    <option value="2">Préposé aux clients d’affaire</option>
                    <option value="3">Administrateur</option>
                    <option value="4">Aucune</option>
                </select>
                @error('role_id') <p class="text-danger">{{ $message }}</p> @enderror
                <br />

                <input type="password" class="form-control" placeholder="Mot de passe" name="password" required>
                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                <br />

                <input type="password" class="form-control" placeholder="Confirmer le mot de passe" name="password_confirmation" required>
                <br />

                <button class="btn btn-primary" type="submit">Créer un compte</button>
            </div>
            <div id="bottom">
                <a href="{{ url('/login') }}">Vous avez déjà un compte ?</a>
            </div>
        </div>
    </form>
</div>
@endsection
