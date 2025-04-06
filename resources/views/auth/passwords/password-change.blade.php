@extends('master')

@section('content')
    <form action="{{ route('password-change') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h2>{{ $title }}</h2>
                </div>
                <input type="text" class="form-control" id="nameInput" placeholder="Nom d'utilisateur" name="name" value="{{ $name ?? '' }}" {{ $name ? 'readonly' : '' }} required>
                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                <br />
                <input type="password" class="form-control" id="oldPasswordInput" placeholder="Ancien mot de passe" name="oldPassword" required>
                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                <br />
                <input type="password" class="form-control" id="newPasswordInput" placeholder="Nouveau mot de passe" name="newPassword" required>
                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                <br />
                <button class="btn btn-primary" type="submit">Changer votre mot de passe</button>
            </div>
        </div>
    </form>
@endsection
