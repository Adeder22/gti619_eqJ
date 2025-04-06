@extends('master')

@section('content')
<div class="container">
  
    <div class="card-body text-center">
        <h2>Bienvenue, {{ Auth::user()->name }}!</h2>
        <p>Vous êtes connecté avec le role <strong>{{ $role }}</strong>.</p>

        @foreach ($links as $item)
            <a href="{{ url('/' . $item) }}" class="btn-block mb-2">{{ ucfirst($item)}}</a>
        @endforeach

        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary ">Retour à l'accueil</a>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Se déconnecter</button>
            </form>
        </div>
    </div>
</div>
@endsection