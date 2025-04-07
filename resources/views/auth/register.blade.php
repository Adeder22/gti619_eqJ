@extends('master')

@section('content')
<div class="container">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="card" >
            <div class="card-body">
                <div class="card-header">
                    <h2>Créer un compte</h2>
                </div>
                <input type="text" class="form-control" placeholder="Nom d'utilisateur" name="name" required>
                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                <br />

                <select class="form-control" name="role_id" required>
                    <option value="" disabled selected>Choisissez un rôle</option>
                    <option value="1">Administrateur</option>
                    <option value="2">Préposé aux clients résidentiels</option>
                    <option value="3">Préposé aux clients d’affaire</option>
                    <option value="4">Aucune</option>
                </select>
                @error('role_id') <p class="text-danger">{{ $message }}</p> @enderror
                <br />

                <input type="password" class="form-control" placeholder="Mot de passe" name="password" required>
                <ul class="text-start">
                    @if ($capitals)
                        <li>
                            Doit contenir au moins une lettre majuscules
                        </li>
                    @endif
                    @if ($special_chars)
                        <li>
                            Doit contenir un caractère spécial parmi ~!@#$%^&*()_+
                        </li>
                    @endif
                    @if ($numbers)
                        <li>
                            Doit contenir au moins un chiffre
                        </li>
                        @endif
                        <li>
                            Doit avoir au moins {{ $length }} caractères
                        </li>
                </ul>
                @error('password') <p class="fw-bold text-danger">{{ $message }}</p> @enderror

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
