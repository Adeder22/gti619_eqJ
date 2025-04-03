@extends('master')

@section('content')
    <form action="{{ route('password-change') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h2>Changement de mot de passe</h2>
                </div>
                <input type="text" class="form-control" id="nameInput" placeholder="Nom d'utilisateur" name="name" required>
                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                <br />
                <input type="password" class="form-control" id="passwordInput" placeholder="Nouveau mot de passe" name="password" required>
                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                <br />
                <button class="btn btn-primary" type="submit">Changer votre mot de passe</button>
            </div>
        </div>
    </form>
@endsection
