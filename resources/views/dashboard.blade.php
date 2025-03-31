@extends('master')

@section('content')
<div class="container">
  
    <div class="card-body text-center">
        <h2>Bienvenue, {{ Auth::user()->name }}!</h2>
        <p>Vous êtes connecté en tant que <strong>{{ $role }}</strong>.</p>

        <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Se déconnecter</button>
        </form>
    </div>
</div>
@endsection