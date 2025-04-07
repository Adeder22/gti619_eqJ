<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
</head>

<body>
    @extends('master')

    @section('content')
    <h1>Admin</h1>
    <h2><u>Options de sécurité</u></h2>

    <form method="post" action="{{ route('admin') }}">
        @csrf
        <h4>Changement de mot de passe</h4>
        <div>
            <label for="max_day">Durée avant changement de mot de passe (en jours): </label>
            <input type="number" id="max_day" name="max_day" min="1" value="{{ $passResetTime ?? 1 }}" size="2">
        </div>
        <div>
            <label for="attempt-limit">Limite de tentatives de connections: </label>
            <input type="number" id="attempt-limit-count" name="attempt-limit-count" min="1" value="{{ $attempts ?? 3 }}" size="2">
            <label for="attempt-limit"> tentatives</label>
        </div>

        <br />
        <h4>Complexité du mot de passe</h4>
        <div>
            <label for="old-password">Ne peut pas utiliser un certain nombre d'anciens mots de passe: </label>
            <input type="text" id="old-password-count" name="old-password-count" min="0" value="1" size="2">
            <label for="old-password"> anciens mots de passes </label>
        </div>
        <div>
            <input type="checkbox" id="lowercase-uppercase" name="lowercase-uppercase">
            <label for="lowercase-uppercase">Doit contenir au moins une minuscule et une majuscule</label>
        </div>
        <div>
            <input type="checkbox" id="special-character" name="special-character">
            <label for="special-character">Doit contenir un caractère spécial (parmi ~!@#$%^&*()_+)</label>
        </div>
        <div>
            <input type="checkbox" id="number" name="number">
            <label for="number">Doit contenir un nombre</label>
        </div>
        <div>
            <label for="minLength">Longueur minimale:</label>
            <input type="number" id="minLength" name="minLength" min="0" value="4">
        </div>
        <div>
            <button type="submit">Valider</button>
        </div>
    </form>
    @endsection
